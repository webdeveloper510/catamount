<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\plan_request;
use App\Models\Utility;
use Illuminate\Http\Request;

class PlanController extends Controller
{

    public function index()
    {
        if (\Auth::user()->type == 'super admin' || (\Auth::user()->type == 'owner')) {
            $plans = Plan::get();

            return view('plan.index', compact('plans'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        if (\Auth::user()->type == 'super admin') {
            $arrDuration = Plan::$arrDuration;

            return view('plan.create', compact('arrDuration'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function store(Request $request)
    {
        if (\Auth::user()->type == 'super admin') {
            $payment = Utility::set_payment_settings();
            if (count($payment) > 0 || $request->price <= 0) {

                $validation                   = [];
                $validation['name']           = 'required|unique:plans';
                $validation['price']          = 'required|numeric|min:0';
                $validation['duration']       = 'required';
                $validation['max_user']       = 'required|numeric';
                $validation['max_account']    = 'required|numeric';
                $validation['max_contact']    = 'required|numeric';
                $validation['storage_limit']  = 'required|numeric';
                $validation['enable_chatgpt'] = 'required|string';

                // if($request->image)
                // {
                //     $validation['image'] = 'required|max:20480';
                // }
                // $request->validate($validation);
                $post = $request->all();

                // if($request->hasFile('image'))
                // {
                //     $filenameWithExt = $request->file('image')->getClientOriginalName();
                //     $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //     $extension       = $request->file('image')->getClientOriginalExtension();
                //     $fileNameToStore = 'plan_' . time() . '.' . $extension;

                //     $dir = storage_path('uploads/plan/');
                //     if(!file_exists($dir))
                //     {
                //         mkdir($dir, 0777, true);
                //     }
                //     $path          = $request->file('image')->storeAs('uploads/plan/', $fileNameToStore);
                //     $post['image'] = $fileNameToStore;
                // }

                if (Plan::create($post)) {
                    return redirect()->back()->with('success', __('Plan Successfully created.'));
                } else {
                    return redirect()->back()->with('error', __('Something is wrong.'));
                }
            } else {
                return redirect()->back()->with('error', __('Please set payment api key & secret key for add new plan.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function edit($plan_id)
    {
        if (\Auth::user()->type == 'super admin') {
            $arrDuration = Plan::$arrDuration;
            $plan        = Plan::find($plan_id);
            return view('plan.edit', compact('plan', 'arrDuration'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function update(Request $request, $plan_id)
    {
        if (\Auth::user()->type == 'super admin') {
            $plan = Plan::find($plan_id);
            $payment = Utility::set_payment_settings();
            if (count($payment) > 0 || $request->price <= 0) {


                if (!empty($plan)) {
                    $validation                = [];
                    $validation['name']        = 'required|unique:plans,name,' . $plan_id;
                    $validation['duration']    = 'required';
                    $validation['max_user']    = 'required|numeric';
                    $validation['max_account'] = 'required|numeric';
                    $validation['max_contact'] = 'required|numeric';
                    $validation['storage_limit']  = 'required|numeric';
                    $validation['enable_chatgpt'] = 'required|string';

                    $post = $request->all();
                    $post['enable_chatgpt'] = ($request->enable_chatgpt == 'on') ? 'on' : 'off';


                    if ($plan->update($post)) {
                        return redirect()->back()->with('success', __('Plan successfully updated.'));
                    } else {
                        return redirect()->back()->with('error', __('Something is wrong.'));
                    }
                } else {
                    return redirect()->back()->with('error', __('Plan not found.'));
                }
            } else {
                return redirect()->back()->with('error', __('Please set payment api key & secret key for add new plan.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function userPlan(Request $request)
    {
        $objUser = \Auth::user();
        $planID  = \Illuminate\Support\Facades\Crypt::decrypt($request->code);
        $plan    = Plan::find($planID);
        if ($plan) {
            if ($plan->price <= 0) {
                $objUser->assignPlan($plan->id);

                return redirect()->route('plans.index')->with('success', __('Plan successfully activated.'));
            } else {
                return redirect()->back()->with('error', __('Something is wrong.'));
            }
        } else {
            return redirect()->back()->with('error', __('Plan not found.'));
        }
    }

    public function getpaymentgatway($code)
    {

        $plan_id = \Illuminate\Support\Facades\Crypt::decrypt($code);
        $plan    = Plan::find($plan_id);
        $planReqs = plan_request::where('user_id',\Auth::user()->id)->where('plan_id',$plan_id)->first();
        if ($plan) {
            $admin_payment_setting = Utility::payment_settings();
            return view('plan/payments', compact('plan', 'admin_payment_setting','planReqs'));
        } else {
            return redirect()->back()->with('error', __('Plan is deleted.'));
        }
    }
}
