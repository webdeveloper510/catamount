<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountIndustry;
use App\Models\AccountType;
use App\Models\Campaign;
use App\Models\Contact;
use App\Models\Document;
use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\Plan;
use App\Models\Stream;
use App\Models\Task;
use App\Models\Utility;
use App\Models\Billing;
use App\Models\Proposal;
use App\Models\ProposalInfo;
use App\Mail\ProposalResponseMail;
use App\Models\User;
use App\Models\UserDefualtView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\SendPdfEmail;
use App\Mail\LeadWithrawMail;
use App\Models\MasterCustomer;
use App\Models\NotesLeads;
use Log;
use Mail;
use Str;
use App\Models\LeadDoc;
use Storage;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            if (\Auth::user()->can('Manage Lead')) {
                $statuss = Lead::$stat;

                if(\Auth::user()->type == 'owner'){
                $leads = Lead::with('accounts','assign_user')->where('created_by', \Auth::user()->creatorId())->orderby('id','desc')->get();
                $defualtView         = new UserDefualtView();
                $defualtView->route  = \Request::route()->getName();
                $defualtView->module = 'lead';
                $defualtView->view   = 'list';
                User::userDefualtView($defualtView);
                }
                else{
                $leads = Lead::with('accounts','assign_user')->where('user_id', \Auth::user()->id)->get();
                $defualtView         = new UserDefualtView();
                $defualtView->route  = \Request::route()->getName();
                $defualtView->module = 'lead';
                $defualtView->view   = 'list';
                }
                return view('lead.index', compact('leads','statuss'));
            } else {
                return redirect()->back()->with('error', 'permission Denied');
            }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type, $id)
    {
        if (\Auth::user()->can('Create Lead')){
            $users       = User::where('created_by', \Auth::user()->creatorId())->get();
            $status     = Lead::$status;
            return view('lead.create', compact('status', 'users', 'id','type'));
        } else {
            return redirect()->back()->with('error', 'permission Denied');
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if (\Auth::user()->can('Create Lead')) {
            // echo"<pre>";
            // print_r($request->all());die;

            $validator = \Validator::make(
                $request->all(),
                [
                    'lead_name'=>'required',
                    'name' => 'required|max:120',
                ]);
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first()) 
                ->withErrors($validator)
                ->withInput();
            }
            $data = $request->all();
            $package = [];
            $additional = [];
            $bar_pack = [];
            foreach ($data as $key => $values) {
                if (strpos($key, 'package_') === 0) {
                    $newKey = strtolower(str_replace('package_', '', $key));
                    $package[$newKey] = $values;
                }
                if (strpos($key, 'additional_') === 0) {
                    // Extract the suffix from the key
                    $newKey = strtolower(str_replace('additional_', '', $key));
                    // Check if the key exists in the output array, if not, initialize it
                    if (!isset($additional[$newKey])) {
                        $additional[$newKey] = [];
                    }
                    $additional[$newKey] = $values;
                }
                if (strpos($key, 'bar_') === 0) {
                    // Extract the suffix from the key
                    $newKey = ucfirst(strtolower(str_replace('bar_', '', $key)));
                    // Check if the key exists in the output array, if not, initialize it
                    if (!isset($bar_pack[$newKey])) {
                        $bar_pack[$newKey] = [];
                    }
                    // Assign the values to the new key in the output array
                    $bar_pack[$newKey] = $values;
                }
            }
            
            $package = json_encode($package);
            $additional = json_encode($additional);
            $bar_pack = json_encode($bar_pack);
            $phone= preg_replace('/\D/', '', $request->input('phone'));
            $lead                       = new Lead();
            $lead['user_id']            = Auth::user()->id;
            $lead['name']               = $request->name;
            $lead['leadname']           = $request->lead_name;
            $lead['assigned_user']      = $request->user ?? '';
            $lead['email']              = $request->email ?? '';
            $lead['phone']              = $phone ;
            $lead['lead_address']       = $request->lead_address;
            $lead['company_name']       = $request->company_name;
            $lead['relationship']       = $request->relationship;
            $lead['start_date']         = $request->start_date;
            $lead['end_date']           = $request->start_date;
            $lead['type']               = $request->type;
            $lead['venue_selection']    = isset($request->venue)?implode(',',$request->venue) :'';
            $lead['function']           = isset($request->function)? implode(',',$request->function) :'';
            $lead['func_package']       = isset($package) && (!empty($package)) ? $package : '';
            $lead['guest_count']        = $request->guest_count ?? 0;
            $lead['description']        = $request->description;
            $lead['spcl_req']           = $request->spcl_req;
            $lead['allergies']          = $request->allergies;
            $lead['start_time']         = $request->start_time ?? '';
            $lead['end_time']           = $request->end_time ?? '';
            $lead['bar']                = $request->baropt;
            $lead['bar_package']        = isset($bar_pack) && !empty($bar_pack) ? $bar_pack : '';
            $lead['ad_opts']            = isset($additional) && !empty($additional) ? $additional : '';
            $lead['rooms']              = $request->rooms ?? 0;
            $lead['lead_status']        = ($request->is_active == 'on') ? 1 : 0;
            $lead['created_by']         = \Auth::user()->creatorId();
            $lead->save();

            $existingcustomer = MasterCustomer::where('email',$lead->email)->first();
            if(!$existingcustomer){
                $customer = new MasterCustomer();
                $customer->ref_id = $lead->id;
                $customer->name = $request->name;
                $customer->email = $request->email ??'';
                $customer->phone = $phone;
                $customer->address = $request->lead_address ?? '';
                $customer->category = 'lead';
                $customer->type = $request->type ?? '';
                $customer->save();
            }
            $uArr = [
                'lead_name' => $lead->name,
                'lead_email' => $lead->email,
            ];
            $resp = Utility::sendEmailTemplate('lead_assign', [$lead->id => $lead->email], $uArr);

            //webhook
            $module = 'New Lead';
            $Assign_user_phone = User::where('id', $request->user)->first();
            $setting  = Utility::settings(\Auth::user()->creatorId());
            $uArr = [
                'lead_name' => $lead->name,
                'lead_email' => $lead->email,
             ];
            // $resp = Utility::sendEmailTemplate('lead_assigned', [$lead->id => $Assign_user_phone->email], $uArr);
            if (isset($setting['twilio_lead_create']) && $setting['twilio_lead_create'] == 1) {
                $uArr = [
                    //'company_name'  => $lead->name,
                    'lead_email' => $lead->email,
                    'lead_name' => $lead->name
                ];
                Utility::send_twilio_msg($Assign_user_phone->phone, 'new_lead', $uArr);       
            }
            $url = 'https://fcm.googleapis.com/fcm/send';
            // $FcmToken = 'e0MpDEnykMLte1nJ0k3SU7:APA91bGpbv-KQEzEQhR1ApEgGFmn9H5tEkdpvG2FHuyiWP3JZsP_8CKJMi5tKyTn5DYgOmeDvAWFwdiDLeG_qTXZ6lUIWL2yqrFYJkUg-KUwTsQYupk0qYsi3OCZ8MZQNbCIDa6pbJ4j';
            $FcmToken = User::where('type','owner')->orwhere('type','admin')->pluck('device_key')->first();
            $serverKey = 'AAAAn2kzNnQ:APA91bE68d4g8vqGKVWcmlM1bDvfvwOIvBl-S-KUNB5n_p4XEAcxUqtXsSg8TkexMR8fcJHCZxucADqim2QTxK2s_P0j5yuy6OBRHVFs_BfUE0B4xqgRCkVi86b8SwBYT953dE3X0wdY'; // ADD SERVER KEY HERE PROVIDED BY FCM
            $data = [
                "to" =>$FcmToken,
                "notification" => [
                    "title" => 'Lead created.',
                    "body" => 'New Lead is Created',  
                ]
            ];
            $encodedData = json_encode($data);
        
            $headers = [
                'Authorization:key=' . $serverKey,
                  'Content-Type: application/json',
            ];
        
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
            // Execute post
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }        
            // Close connection
            curl_close($ch);
            // FCM response
            // dd($result);
            // if (Auth::user()) {
            //     return redirect()->back()->with('success', __('Lead created!') . ((isset($msg) ? '<br> <span class="text-danger">' . $msg . '</span>' : '')));
            // } else {
            //     return redirect()->back()->with('error', __('Webhook call failed.') . ((isset($msg) ? '<br> <span class="text-danger">' . $msg . '</span>' : '')));
            // }
            return redirect()->back()->with('success', __('Lead Created.'));
        } else {
            return redirect()->back()->with('error', 'permission Denied');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Lead $lead
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Lead $lead)
    {

        if (\Auth::user()->can('Show Lead')) {
            $settings = Utility::settings();
            $venue = explode(',',$settings['venue']);
            $fixed_cost = json_decode($settings['fixed_billing'],true);
            $additional_items = json_decode($settings['additional_items'],true);
            return view('lead.view', compact('lead','venue','fixed_cost','additional_items'));
        } else {
            return redirect()->back()->with('error', 'permission Denied');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Lead $lead
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Lead $lead)
    {
        if (\Auth::user()->can('Edit Lead')) {
            $venue_function = explode(',', $lead->venue_selection);
            $function_package =  explode(',', $lead->function);
            $status   = Lead::$status;
            $users     = User::where('created_by', \Auth::user()->creatorId())->get();             
            return view('lead.edit', compact('venue_function','function_package','lead','users', 'status'));
        } else {
            return redirect()->back()->with('error', 'permission Denied');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Lead $lead
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lead $lead)
    {
     
        if (\Auth::user()->can('Edit Lead')) {
           
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:120',
                    'phone' => 'required',
                    'venue' =>'required',
                    'function'=>'required'
                   
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first()) 
                ->withErrors($validator)
                ->withInput();
                // return redirect()->back()->with('error', $messages->first());
            }
            $data = $request->all();
            $package = [];
            $additional = [];
            $bar_pack = [];
            $venue_function = implode(',',$_REQUEST['venue']);
            $function = isset($request->function) ? implode(',',$_REQUEST['function']) : '';
          
            foreach ($data as $key => $values) {
                if (strpos($key, 'package_') === 0) {
                    $newKey = strtolower(str_replace('package_', '', $key));
                    $package[$newKey] = $values;
                }
                if (strpos($key, 'additional_') === 0) {
                    // Extract the suffix from the key
                    $newKey = strtolower(str_replace('additional_', '', $key));
                    // Check if the key exists in the output array, if not, initialize it
                    if (!isset($additional[$newKey])) {
                        $additional[$newKey] = [];
                    }
                    $additional[$newKey] = $values;
                }
                if (strpos($key, 'bar_') === 0) {
                    // Extract the suffix from the key
                    $newKey = ucfirst(strtolower(str_replace('bar_', '', $key)));
                    // Check if the key exists in the output array, if not, initialize it
                    if (!isset($bar_pack[$newKey])) {
                        $bar_pack[$newKey] = [];
                    }
                    // Assign the values to the new key in the output array
                    $bar_pack[$newKey] = $values;
                }
            }
           
            $package = json_encode($package);
            $additional = json_encode($additional);
            $bar_pack = json_encode($bar_pack);
            $phone= preg_replace('/\D/', '', $request->input('phone'));
            $lead['user_id']            = $request->user;
            $lead['name']               = $request->name;
            $lead['leadname']          = $request->lead_name;
            $lead['email']              = $request->email;
            $lead['assigned_user']      = $request->user ?? '';
            $lead['phone']              = $phone;
            $lead['lead_address']       = $request->lead_address;
            $lead['company_name']       = $request->company_name;
            $lead['relationship']       = $request->relationship;
            $lead['start_date']         = $request->start_date;
            $lead['end_date']           = $request->start_date;
            $lead['type']               = $request->type;
            $lead['venue_selection']    = isset($venue_function) && (!empty($venue_function)) ? $venue_function : '';
            $lead['function']           = $function;
            $lead['guest_count']        = $request->guest_count ?? 0;
            $lead['description']        = $request->description;
            $lead['spcl_req']           = $request->spcl_req;
            $lead['allergies']          = $request->allergies;
            $lead['start_time']         = $request->start_time;
            $lead['end_time']           = $request->end_time;
            $lead['func_package']       = isset($package) && (!empty($package)) ? $package : '';
            $lead['bar_package']        = isset($bar_pack) && !empty($bar_pack) ? $bar_pack : '';
            $lead['ad_opts']            = isset($additional) && !empty($additional) ? $additional : '';
            $lead['bar']                = $request->baropt;
            $lead['rooms']              = $request->rooms ?? 0;
            $lead['lead_status']        = ($request->is_active == 'on') ? 1 : 0;
            $lead['created_by']         = \Auth::user()->creatorId();
            $lead->update();
            $statuss = Lead::$stat;

            if(\Auth::user()->type == 'owner'){
            $leads = Lead::with('accounts','assign_user')->where('created_by', \Auth::user()->creatorId())->orderby('id','desc')->get();
         
            }
            else{
            $leads = Lead::with('accounts','assign_user')->where('user_id', \Auth::user()->id)->get();
          
            }
            return redirect()->route('lead.index', compact('leads','statuss'))->with('success', __('Lead successfully updated!'));
            // return view('lead.index', compact('leads','statuss'))->with('success', __('Lead  Updated.'));
            // return redirect()->back()->with('success', __('Lead Updated.'));
        } else {
            return redirect()->back()->with('error', 'permission Denied');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Lead $lead
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lead $lead)
    {
        if (\Auth::user()->can('Delete Lead')) {
            $lead->delete();
            return redirect()->back()->with('success', __('Lead  Deleted.'));
        } else {
            return redirect()->back()->with('error', 'permission Denied');
        }
    }

    public function grid()
    {
        $leads   = Lead::where('created_by', '=', \Auth::user()->creatorId())->get();
        $statuss = Lead::where('created_by', '=', \Auth::user()->creatorId())->get();

        // if($leads->isNotEmpty())
        // {
        //     $users = user::where('id', $leads[0]->user_id)->get();
        // }

        $defualtView         = new UserDefualtView();
        $defualtView->route  = \Request::route()->getName();
        $defualtView->module = 'lead';
        $defualtView->view   = 'kanban';
        User::userDefualtView($defualtView);
        // if($leads->isEmpty())
        // {
        //     return view('lead.grid', compact( 'statuss'));
        // }
        // else
        // {
        //      return view('lead.grid', compact('leads', 'statuss','users'));
        // }
        return view('lead.grid', compact('leads', 'statuss'));
    }

    public function changeorder(Request $request)
    {
        $post   = $request->all();
        $lead   = Lead::find($post['lead_id']);
        $status = Lead::where('status', $post['status_id'])->get();


        if (!empty($status)) {
            $lead->status = $post['status_id'];
            $lead->save();
        }

        foreach ($post['order'] as $key => $item) {
            $order         = Lead::find($item);
            $order->status = $post['status_id'];
            $order->save();
        }
    }

    public function showConvertToAccount($id)
    {
        if (\Auth::user()->type == 'owner') {
            $lead        = Lead::findOrFail($id);
            $accountype  = accountType::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $industry    = accountIndustry::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $user        = User::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $document_id = Document::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            return view('lead.convert', compact('lead', 'accountype', 'industry', 'user', 'document_id'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function convertToAccount($id, Request $request)
    {
        if (\Auth::user()->type == 'owner') {
            $lead = Lead::findOrFail($id);
            $usr  = \Auth::user();

            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:accounts,email',
                    'shipping_postalcode' => 'required',
                    'lead_postalcode' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $account                        = new account();
            $account['user_id']             = $request->user;
            $account['document_id']         = $request->document_id;
            $account['name']                = $request->name;
            $account['email']               = $request->email;
            $account['phone']               = $request->phone;
            $account['website']             = $request->website;
            $account['billing_address']     = $request->lead_address;
            $account['billing_city']        = $request->lead_city;
            $account['billing_state']       = $request->lead_state;
            $account['billing_country']     = $request->lead_country;
            $account['billing_postalcode']  = $request->lead_postalcode;
            $account['shipping_address']    = $request->shipping_address;
            $account['shipping_city']       = $request->shipping_city;
            $account['shipping_state']      = $request->shipping_state;
            $account['shipping_country']    = $request->shipping_country;
            $account['shipping_postalcode'] = $request->shipping_postalcode;
            $account['type']                = $request->type;
            $account['industry']            = $request->industry;
            $account['description']         = $request->description;
            $account['created_by']          = \Auth::user()->creatorId();
            $account->save();
            // end create deal

            // Update is_converted field as deal_id
            $lead->is_converted = $account->id;
            $lead->save();

            return redirect()->back()->with('success', __('Lead converted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function proposal($id){
        $decryptedId = decrypt(urldecode($id));
        $proposal_info = Proposal::where('lead_id',$decryptedId)->orderby('id','desc')->get();
        return view('lead.proposal_information',compact('proposal_info','decryptedId'));
    }
    public function view_proposal($id){
        $decryptedId = decrypt(urldecode($id));
        $lead = Lead::find($decryptedId);
        $settings = Utility::settings();
        if(isset($settings['fixed_billing'])){
            $fixed_cost= json_decode($settings['fixed_billing'],true);
        }
        $additional_items = json_decode($settings['additional_items'],true);
        $proposal = Proposal::where('lead_id',$decryptedId)->first();
        $data = [
                'settings'=>$settings,
                'proposal'=> $proposal,
                'lead'=>$lead,
                'fixed_cost' => $fixed_cost,
                'additional_items'=>$additional_items
        ];

        $pdf = Pdf::loadView('lead.signed_proposal', $data);
        // return $pdf->stream('proposal.pdf');
        return response($pdf->output(), 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="proposal.pdf"');
    }
    public function share_proposal_view($id){
        $decryptedId = decrypt(urldecode($id));
        $lead = Lead::find($decryptedId);
        return view('lead.share_proposal',compact('lead'));
    }
    public function proposalpdf(Request $request,$id){
        $settings = Utility::settings();
        $id = decrypt(urldecode($id));
        $lead = Lead::find($id);
        if (!empty($request->file('attachment'))){
            $file =  $request->file('attachment');
            $filename = Str::random(3).'_'. $file->getClientOriginalName();
            $folder = 'Proposal_attachments/' . $id; 
            try {
                $path = $file->storeAs($folder, $filename, 'public');
            } catch (\Exception $e) {
                Log::error('File upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'File upload failed');
            }
        }
        $proposalinfo = new ProposalInfo();
        $proposalinfo->lead_id = $id;
        $proposalinfo->email = $request->email;
        $proposalinfo->subject = $request->subject;
        $proposalinfo->content = $request->emailbody;
        $proposalinfo->proposal_info = json_encode($request->billing,true);
        $proposalinfo->attachments = $filename ?? '';
        $proposalinfo->created_by = Auth::user()->id;
        $proposalinfo->save();
        $propid = $proposalinfo->id;
        $subject = $request->subject;
        $content = $request->emailbody;
        try {
            config(
                [
                    'mail.driver'       => $settings['mail_driver'],
                    'mail.host'         => $settings['mail_host'],
                    'mail.port'         => $settings['mail_port'],
                    'mail.username'     => $settings['mail_username'],
                    'mail.password'     => $settings['mail_password'],
                    'mail.from.address' => $settings['mail_from_address'],
                    'mail.from.name'    => $settings['mail_from_name'],
                ]
            );
            Mail::to($request->email)->send(new SendPdfEmail($lead,$subject,$content,$proposalinfo,$propid));
            $upd = Lead::where('id',$id)->update(['status' => 1]);
        } catch (\Exception $e) {
            //   return response()->json(
            //             [
            //                 'is_success' => false,
            //                 'message' => $e->getMessage(),
            //             ]
            //         );
          return redirect()->back()->with('success', 'Email Not Sent');
      
        }
        return redirect()->back()->with('success', 'Email Sent Successfully');
    }
    public function proposalview($id){
            $id = decrypt(urldecode($id));
            $lead = Lead::find($id);
            $settings = Utility::settings();
            $venue = explode(',',$settings['venue']);
            $fixed_cost = json_decode($settings['fixed_billing'],true);
            $additional_items = json_decode($settings['additional_items'],true);
            return view('lead.proposal',compact('lead','venue','settings','fixed_cost','additional_items'));
    }
    public function proposal_resp(Request $request,$id){
            $settings = Utility::settings();
            $id = decrypt(urldecode($id));

            if(!empty($request->imageData)){
                $image = $this->uploadSignature($request->imageData);
            }else{
                return redirect()->back()->with('error',('Please Sign it for confirmation'));
            }
            $existproposal = Proposal::where('lead_id', $id)->exists();
            // if ($existproposal == TRUE) {
            //     Proposal::where('lead_id',$id)->update(['image' => $image]);
            //     return redirect()->back()->with('error','Proposal is already confirmed');
            // }
            $proposals = new Proposal();
           
            $proposals['lead_id'] = $id;
            $proposals['image'] = $image;
            $proposals['notes'] = $request->comments;
            $proposals['proposal_id'] = isset($request->proposal) && ($request->proposal != '')?$request->proposal :'';
            $proposals->save();
            $lead = Lead::find($id);
            $users = User::where('type','owner')->orwhere('type','Admin')->get();
           
            // die;
            $fixed_cost = json_decode($settings['fixed_billing'],true);
            $additional_items = json_decode($settings['additional_items'],true);
            $data = [
                'proposal'=> $proposals,
                'lead'=>$lead,
                'fixed_cost' => $fixed_cost,
                'settings'=>$settings,
                'additional_items'=>$additional_items
            ];
            $pdf = Pdf::loadView('lead.signed_proposal', $data);
            try {
                $filename = 'proposal_' . time() . '.pdf'; // You can adjust the filename as needed
                $folder = 'Proposal_response/' . $id; 
                $path = Storage::disk('public')->put($folder . '/' . $filename, $pdf->output());
                $proposals->update(['proposal_response' => $filename]);
             
            } catch (\Exception $e) {
                // Log the error for future reference
                \Log::error('File upload failed: ' . $e->getMessage());
                // Return an error response
                return response()->json([
                    'is_success' => false,
                    'message' => 'Failed to save PDF: ' . $e->getMessage(),
                ]);
            }
            try {
                config(
                    [
                        'mail.driver'       => $settings['mail_driver'],
                        'mail.host'         => $settings['mail_host'],
                        'mail.port'         => $settings['mail_port'],
                        'mail.username'     => $settings['mail_username'],
                        'mail.password'     => $settings['mail_password'],
                        'mail.from.address' => $settings['mail_from_address'],
                        'mail.from.name'    => $settings['mail_from_name'],
                    ]
                );
                foreach ($users as  $user) {
                    Mail::to($lead->email)->cc($user->email)
                    ->send(new ProposalResponseMail($proposals,$lead));
                }      
                $upd = Lead::where('id',$id)->update(['status' => 2]);
            } catch (\Exception $e) {
                //   return response()->json(
                //             [
                //                 'is_success' => false,
                //                 'message' => $e->getMessage(),
                //             ]
                //         );
              return redirect()->back()->with('success', 'Email Not Sent');
          
            }
            return $pdf->stream('proposal.pdf');
          
            
    } 
    public function uploadSignature($signed){
        $folderPath = public_path('upload/');
        $image_parts = explode(";base64,", $signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . uniqid() . '.'.$image_type;
        file_put_contents($file, $image_base64);
        return $file;
    }
    public function review_proposal($id){
       
        $id = decrypt(urldecode($id));
        $lead = Lead::find($id);
        $venue_function = explode(',', $lead->venue_selection);
        $function_package =  explode(',', $lead->function);
        $status   = Lead::$status;
        $users     = User::where('created_by', \Auth::user()->creatorId())->get();           
        // $proposal = ProposalInfo::where('lead_id',$id)->orderby('id','desc')->first();
        return view('lead.review_proposal',compact('lead','venue_function','function_package','users','status'));
    }
    public function review_proposal_data(Request $request, $id){
        // echo "<pre>";print_r($request->all());die;
        $settings = Utility::settings();
        $validator = \Validator::make($request->all(), [
            'status' => 'required|in:Approve,Resend,Withdraw',
        ],[
            'status.in' => 'The status field is required',
        ]);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $lead = Lead::find($id);
        $venue_function = isset($request->venue) ? implode(',',$_REQUEST['venue']) :'';
        $function =  isset($request->function) ? implode(',',$_REQUEST['function']) :'';
        $phone= preg_replace('/\D/', '', $request->input('phone'));

            if($request->status == 'Approve'){  
                $status = 4;              
                // $status = 2;
                // $lead->proposal_status = 2;
            }elseif($request->status == 'Resend'){
                $status = 5;
                // $status = 0;
                // $lead->proposal_status = 1;
                
            }elseif($request->status == 'Withdraw'){
                $status = 3;
                // $status = 3;
                // $lead->proposal_status = 3;
            }
            $data = [
                'user_id'=> $request->user,
                'name'      => $request->name,
                'email'=>   $request->email,
                'phone'=>   $phone,
                'lead_address'=>$request->lead_address,
                'company_name'      =>$request->company_name,
                'relationship'       =>$request->relationship,
                'start_date'        =>$request->start_date,
                'end_date'           =>$request->start_date,
                'type'              =>$request->type,
                'venue_selection'    =>$venue_function,
                'function'           =>$function,
                'status'           => $status,
                'guest_count'        =>$request->guest_count,
                'description'      =>$request->description,
                'spcl_req'      => $request->spcl_req,
                'allergies'       => $request->allergies,
                'start_time'        =>$request->start_time,
                'end_time'       =>$request->end_time,
                'bar'       =>  $request->baropt,
                'rooms'         =>$request->rooms,
                'created_by'        => \Auth::user()->creatorId()
            ];
            $lead->update($data);
            

            $statuss = Lead::$stat;
                if(\Auth::user()->type == 'owner'){
                    $leads = Lead::with('accounts','assign_user')->where('created_by', \Auth::user()->creatorId())->orderby('id','desc')->get();
                }
                else{
                    $leads = Lead::with('accounts','assign_user')->where('user_id', \Auth::user()->id)->get();
                }
            if($status == 4){
                return redirect()->route('lead.index', compact('leads','statuss'))->with('success', __('Lead Approved!'));
            }elseif($status == 3 ){
                Proposal::where('lead_id',$id)->delete();
                try {
                    config(
                        [
                            'mail.driver'       => $settings['mail_driver'],
                            'mail.host'         => $settings['mail_host'],
                            'mail.port'         => $settings['mail_port'],
                            'mail.username'     => $settings['mail_username'],
                            'mail.password'     => $settings['mail_password'],
                            'mail.from.address' => $settings['mail_from_address'],
                            'mail.from.name'    => $settings['mail_from_name']
                        ]
                    );
                    Mail::to($lead->email)->send(new LeadWithrawMail($lead));
                } catch (\Exception $e) {
                    // return response()->json(
                    //     [
                    //         'is_success' => false,
                    //         'message' => $e->getMessage(),
                    //     ]
                    // );
                    return redirect()->route('lead.index', compact('leads','statuss'))->with('danger', __('Email Not Sent!'));
                }
                return redirect()->route('lead.index', compact('leads','statuss'))->with('danger', __('Lead Withdrawn!'));
            }elseif($status == 5){
                $subject = 'Lead Details';
                $content = '';
                $proposalinfo = ProposalInfo::where('lead_id',$id)->orderby('id','desc')->first();
                $propid = $proposalinfo->id;
                try {
                    config(
                        [
                            'mail.driver'       => $settings['mail_driver'],
                            'mail.host'         => $settings['mail_host'],
                            'mail.port'         => $settings['mail_port'],
                            'mail.username'     => $settings['mail_username'],
                            'mail.password'     => $settings['mail_password'],
                            'mail.from.address' => $settings['mail_from_address'],
                            'mail.from.name'    => $settings['mail_from_name'],
                        ]
                    );
                    Mail::to($request->email)->send(new SendPdfEmail($lead,$subject,$content,$proposalinfo,$propid));
                    // Mail::to($request->email)->send(new SendPdfEmail($lead,$subject,$content,$tempFilePath = NULL));
                    // unlink($tempFilePath);
                    // $upd = Lead::where('id',$id)->update(['status' => 1]);
                } catch (\Exception $e) {
                    //   return response()->json(
                    //             [
                    //                 'is_success' => false,
                    //                 'message' => $e->getMessage(),
                    //             ]
                    //         );
                    return redirect()->route('lead.index', compact('leads','statuss'))->with('danger', __('Email Not Sent!'));              
                }
                return redirect()->route('lead.index', compact('leads','statuss'))->with('danger', __('Lead Resent!'));
            }
    }
    public function duplicate($id){
        
        $id = decrypt(urldecode($id));
        $lead = Lead::find($id);
        $newlead = new Lead();
        $newlead['user_id']            = Auth::user()->id;
        $newlead['name']               = $lead->name;
        $newlead['leadname']          =  $lead->leadname;
        $newlead['assigned_user']      = $lead->user_id;
        $newlead['start_date']      = date('Y-m-d');
        $newlead['end_date']      = date('Y-m-d');
        $newlead['email']              = $lead->email;
        $newlead['phone']              = $lead->phone;
        $newlead['lead_address']       = $lead->lead_address;
        $newlead['company_name']       = $lead->company_name;
        $newlead['relationship']       = $lead->relationship;
        $newlead['created_by']         = \Auth::user()->creatorId();
        $newlead->save();
        return redirect()->back()->with('success','Lead Cloned successfully');
    }
    public function lead_info($id){
        $id = decrypt(urldecode($id));
        $lead = Lead::find($id);
        if(!empty($lead->email)){
            $leads = Lead::where('email',$lead->email)->get();
        }else{
            $leads = Lead::where('phone',$lead->phone)->get();
        }
        $notes = NotesLeads::where('lead_id',$id)->orderby('id','desc')->get();
        $docs = LeadDoc::where('lead_id',$id)->get();
        return view('lead.leadinfo',compact('leads','lead','docs','notes'));
    }
    public function lead_user_info($id){

        $id = decrypt(urldecode($id));
        $email = Lead::withTrashed()->find($id)->email;
        $leads = Lead::withTrashed()->where('email',$email)->get();
        $notes = NotesLeads::where('lead_id',$id)->orderby('id','desc')->get();
        $docs = LeadDoc::where('lead_id',$id)->get();
        return view('customer.leaduserview',compact('leads','docs','notes'));
    }
    public function lead_upload($id){
        return view('lead.uploaddoc',compact('id'));
    }
    public function lead_upload_doc(Request $request,$id){
        $validator = \Validator::make(
            $request->all(),
            [
                'lead_file'=>'required|mimes:doc,docx,pdf',
            ]);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first()) ;
        }
        $file = $request->file('lead_file');
        if ($file) {
            $originalName = $file->getClientOriginalName();
            $filename = Str::random(4) . '.' . $file->getClientOriginalExtension();
            $folder = 'leadInfo/' . $id; // Example: uploads/1
            try {
                $path = $file->storeAs($folder, $filename, 'public');
            } catch (\Exception $e) {
                Log::error('File upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'File upload failed');
            }
            $document = new LeadDoc();
            $document->lead_id = $id; // Assuming you have a lead_id field
            $document->filename = $originalName; // Store original file name
            $document->filepath = $path; // Store file path
            $document->save();
            return redirect()->back()->with('success', 'Document Uploaded Successfully');
        } else {
            return redirect()->back()->with('error', 'No file uploaded');
        }
        
    }
    public function lead_billinfo($id){
        return view('lead.bill_information') ;
    }
    public function uploaded_docs($id){
        $docs = LeadDoc::where('lead_id',$id)->get();
        return view('lead.viewdocument',compact('docs'));

    }
    public function status(Request $request){
        $id = $request->id;
        Lead::where('id',$id)->update([
            'lead_status' => $request->status
        ]);
       return true;
    }
    public function leadnotes(Request $request,$id){
        $notes = new NotesLeads();
        $notes->notes = $request->notes;
        $notes->created_by = $request->createrid;
        $notes->lead_id = $id;
        $notes->save();
        return true;
    }
}