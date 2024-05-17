<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Utility;
use App\Models\User;
use App\Models\Plan;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginDetail;
use Exception;
use PhpParser\Node\Stmt\Catch_;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function __construct()
    {
        if (!file_exists(storage_path() . "/installed")) {
            header('location:install');
            die;
        }
    }

    /*protected function authenticated(Request $request, $user)
    {
        if($user->delete_status == 1)
        {
            auth()->logout();
        }

        return redirect('/check');
    }*/

    public function store(LoginRequest $request)
    {

        $user = User::where('email',$request->email)->first();
        if(!$user){
            return redirect()->back()->with('error', 'Invalid Credentials');
        }
        if($user->is_active == 0)
        {
            return redirect()->back()->with('status', 'User is not Active Please Activate User.');
        }

        if (Utility::getValByName('recaptcha_module') == 'yes') {
            $validation['g-recaptcha-response'] = 'required';
        } else {
            $validation = [];
        }
        $this->validate($request, $validation);

        $request->authenticate();
        $request->session()->regenerate();

        $setting = Utility::settings();
        // if(isset($setting['verified_button']) && $setting['verified_button'] == "on"){
        //     // if ($request->user()->hasVerifiedEmail()) {
        //     //     return redirect()->intended(RouteServiceProvider::HOME);
        //     // }
        //     try{
        //         $request->user()->sendEmailVerificationNotification();
        //     }
        //     catch(Exception $e)
        //     {
        //         $smtp="Email SMTP settings does not configure so please contact to your site admin. ";
        //     }

        // }


        $user = Auth::user();
        // $ip = '49.36.83.154'; // This is static ip address
        $ip = $_SERVER['REMOTE_ADDR']; // your ip address here
        $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));
        $whichbrowser = new \WhichBrowser\Parser($_SERVER['HTTP_USER_AGENT']);
        if ($whichbrowser->device->type == 'bot') {
            return;
        }
        $referrer = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER']) : null;
        /* Detect extra details about the user */
        $query['browser_name'] = $whichbrowser->browser->name ?? null;
        $query['os_name'] = $whichbrowser->os->name ?? null;
        $query['browser_language'] = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? mb_substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : null;
        $query['device_type'] = get_device_type($_SERVER['HTTP_USER_AGENT']);
        $query['referrer_host'] = !empty($referrer['host']);
        $query['referrer_path'] = !empty($referrer['path']);

        isset($query['timezone'])?date_default_timezone_set($query['timezone']):'';

        $json = json_encode($query);

        $user = \Auth::user();

        if ($user->type != 'owner' && $user->type != 'super admin') {
            $login_detail = LoginDetail::create([
                'user_id' =>  $user->id,
                'ip' => $ip,
                'date' => date('Y-m-d H:i:s'),
                'details' => $json,
                'created_by' => \Auth::user()->creatorId(),
            ]);
        }

        if ($user->delete_status == 1) {
            auth()->logout();
        }
        if($user->type == 'Owner') {
            $plan = Plan::find($user->plan);
            if ($plan) {
                if ($plan->duration != 'lifetime') {
                    $datetime1 = new \Datetime($user->plan_expire_date);
                    $datetime2 = new \Datetime(date('Y-m-d'));
                    $interval = $datetime2->diff($datetime1);
                    $days = $interval->format('%r%a');
                    if ($days <= 0) {
                        $user->assignPlan(1);
                        return redirect()->intended(RouteServiceProvider::HOME)->with('error', __('Your Plan is expired.'));
                    }
                }
            }
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function showLoginForm($lang = '')
    {
        if (empty($lang)) {
            $lang = Utility::getValByName('default_language');
        }

        \App::setLocale($lang);

        return view('auth.login', compact('lang'));
    }

    public function showLinkRequestForm($lang = '')
    {
        if (empty($lang)) {
            $lang = Utility::getValByName('default_language');
        }

        \App::setLocale($lang);

        return view('auth.forgot-password', compact('lang'));
        /*return view('auth.passwords.email', compact('lang'));*/
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
    public function showVerification($lang = 'en')
    {
        if ($lang == 'en') {
            $lang = env('DEFAULT_ADMIN_LANG') ? 'en' : '';
        }
        \App::setLocale($lang);
        return view('auth.verify-email', compact('lang'));
    }
}
function get_device_type($user_agent)
{
    $mobile_regex = '/(?:phone|windows\s+phone|ipod|blackberry|(?:android|bb\d+|meego|silk|googlebot) .+? mobile|palm|windows\s+ce|opera mini|avantgo|mobilesafari|docomo)/i';
    $tablet_regex = '/(?:ipad|playbook|(?:android|bb\d+|meego|silk)(?! .+? mobile))/i';
    if (preg_match_all($mobile_regex, $user_agent)) {
        return 'mobile';
    } else {
        if (preg_match_all($tablet_regex, $user_agent)) {
            return 'tablet';
        } else {
            return 'desktop';
        }
    }
}
