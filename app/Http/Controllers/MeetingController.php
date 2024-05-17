<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CommonCase;
use App\Models\Contact;
use App\Models\Lead;
use App\Models\Meeting;
use App\Models\Opportunities;
use App\Models\Plan;
use App\Models\Stream;
use App\Models\Utility;
use App\Models\User;
use App\Models\UserDefualtView;
use Illuminate\Http\Request;
use App\Models\Blockdate;
use App\Models\Setup;
use App\Models\Billing;
use App\Models\Agreement;
use App\Models\EventDoc;
use App\Models\MasterCustomer;
use App\Mail\SendBillingMail;
use App\Mail\AgreementResponseMail;
use App\Mail\AgreementMail;
use App\Models\NotesEvents;
use App\Models\AgreementInfo;
use DateTime;
use Mpdf\Mpdf;
use DateInterval;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Mail\SendEventMail;
use App\Mail\TestingMail;
use Str;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::user()->can('Manage Meeting')) {
            if (\Auth::user()->type == 'owner') {
                $meetings = Meeting::with('assign_user')->orderby('id','desc')->get();
                $defualtView         = new UserDefualtView();
                $defualtView->route  = \Request::route()->getName();
                $defualtView->module = 'meeting';
                $defualtView->view   = 'list';
                User::userDefualtView($defualtView);
            } else {
                $meetings = Meeting::with('assign_user')->where('user_id', \Auth::user()->id)->orderby('id','desc')->get();
                $defualtView         = new UserDefualtView();
                $defualtView->route  = \Request::route()->getName();
                $defualtView->module = 'meeting';
                $defualtView->view   = 'list';
            }
            return view('meeting.index', compact('meetings'));
        } else {
            return redirect()->back()->with('error', 'permission Denied');
        }
    }

    public function create($type, $id)
    {
        if (\Auth::user()->can('Create Meeting')) {
            $status            = Meeting::$status;
            $parent            = Meeting::$parent;
            $users              = User::where('created_by', \Auth::user()->creatorId())->get();
            $attendees_lead    = Lead::where('created_by', \Auth::user()->creatorId())->where('status',4)->where('lead_status',1)->get()->pluck('leadname', 'id');
            $attendees_lead->prepend('Select Lead', 0);
            $setup = Setup::all();
            return view('meeting.create', compact('status', 'type',  'setup', 'parent', 'users', 'attendees_lead'));
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

    // WORKING  17-01-2024
    public function store(Request $request)
    {
        if (\Auth::user()->can('Create Meeting')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:120',
                    'start_date' => 'required',
                    'email' => 'required|email|max:120',
                    'type' => 'required',
                    'venue' => 'required|max:120',
                    'function' => 'required|max:120',
                    'guest_count' => 'required',
                    'user'=>'required'
                ]
            );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()
                ->back()->with('error', $messages->first())
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
            $start_date = $request->input('start_date');
            $end_date = $request->input('start_date');
            $start_time = $request->input('start_time');
            $end_time = $request->input('end_time');
            $venue_selected = $request->input('venue');

            $overlapping_event = Meeting::where('start_date', '<=', $end_date)
                ->where('end_date', '>=', $start_date)
                ->where(function ($query) use ($start_date, $end_date,$start_time,$end_time, $venue_selected) {
                    foreach ($venue_selected as $v) {
                        $query->orWhere(function ($q) use ($start_date, $end_date,$start_time,$end_time, $v) {
                            $q->where('venue_selection', 'LIKE', "%$v%")
                                ->where('end_time', '>', $start_time)
                                ->where('start_time', '<', $end_time)
                                ->where('start_date', '<=', $end_date)
                                ->where('end_date', '>=', $start_date);
                        });
                    }
                })->count();

            if ($overlapping_event > 0) {
                return redirect()->back()->with('error', 'Event exists for correspomding time or venue!');
            }

            $overlapping_event = Blockdate::where('start_date', '<=', $end_date)
                ->where('end_date', '>=', $start_date)
                ->where(function ($query) use ($start_date, $end_date, $venue_selected) {
                    foreach ($venue_selected as $v) {
                        $query->orWhere(function ($q) use ($start_date, $end_date, $v) {
                            $q->where('venue', 'LIKE', "%$v%")
                                // ->where('end_time', '>', $start_time)
                                // ->where('start_time', '<', $end_time)
                                ->where('start_date', '<=', $end_date)
                                ->where('end_date', '>=', $start_date);
                        });
                    }
                })->count();

            if ($overlapping_event > 0) {
                return redirect()->back()->with('error', 'Date is Blocked for corrosponding time and venue');
            }
            $phone= preg_replace('/\D/', '', $request->input('phone'));
            $meeting                      = new Meeting();
            $meeting['user_id']           = isset($request->user)?implode(',', $request->user):'';
            $meeting['name']              = $request->name;
            $meeting['start_date']        = $request->start_date;
            $meeting['end_date']          = $request->start_date;
            $meeting['email']              = $request->email;
            $meeting['lead_address']       = $request->lead_address ??'';
            $meeting['company_name']      = $request->company_name;
            $meeting['relationship']       = $request->relationship;
            $meeting['type']               = $request->type;
            $meeting['venue_selection']    = implode(',', $request->venue);
            $meeting['func_package']       = $package;
            $meeting['function']            = implode(',', $request->function);
            $meeting['guest_count']         = $request->guest_count;
            $meeting['room']                = $request->rooms ?? 0;
            $meeting['meal']                = $request->meal ??'';
            $meeting['bar']                 = $request->baropt;
            $meeting['bar_package']         = $bar_pack;
            $meeting['spcl_request']        = $request->spcl_request;
            $meeting['alter_name']          = $request->alter_name;
            $meeting['alter_email']         = $request->alter_email;
            $meeting['alter_relationship']  = $request->alter_relationship;
            $meeting['alter_lead_address']  = $request->alter_lead_address;
            $meeting['attendees_lead']      = $request->lead;
            $meeting['eventname']           = $request->eventname ?? $request->name;
            $meeting['phone']               = $phone;
            $meeting['start_time']          = $request->start_time;
            $meeting['end_time']            = $request->end_time;
            $meeting['ad_opts']             = $additional;
            $meeting['floor_plan']          = $request->uploadedImage;
            $meeting['allergies']          = $request->allergies;
            $meeting['created_by']          = \Auth::user()->creatorId();

            $meeting->save();
            // echo "<pre>";print_r($meeting);die;
            
            if (!empty($request->file('atttachment'))) {
                $file= $request->file('atttachment');
                $originalName = $file->getClientOriginalName();
                $filename =  Str::random(3).'_'.$originalName;
                $folder = 'Event/' .  $meeting->id; // Example: uploads/1
                try {
                    $path = $file->storeAs($folder, $filename, 'public');
                    $document = new EventDoc();
                    $document->event_id =  $meeting->id; // Assuming you have a lead_id field
                    $document->filename = $filename; // Store original file name
                    $document->filepath = $path; // Store file path
                    $document->save();
                } catch (\Exception $e) {
                    Log::error('File upload failed: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'File upload failed');
                }
               
            } 
            // if (!empty($request->file('atttachment'))){
            //     $file =  $request->file('atttachment');
            //     $filename = 'Event_'.Str::random(7) . '.' . $file->getClientOriginalExtension();
            //     $folder = 'Event/' . $meeting->id; 
            //     try {
            //         $path = $file->storeAs($folder, $filename, 'public');
            //     } catch (\Exception $e) {
            //         Log::error('File upload failed: ' . $e->getMessage());
            //         return redirect()->back()->with('error', 'File upload failed');
            //     }
            // }
                $existingcustomer = MasterCustomer::where('email',$request->email)->first();
                if(!$existingcustomer){
                    $customer = new MasterCustomer();
                    $customer->ref_id = $meeting->id;
                    $customer->name = $request->name;
                    $customer->email = $request->email;
                    $customer->phone = $phone;
                    $customer->address = $request->lead_address ?? '';
                    $customer->category = 'event';
                    $customer->type = $request->type;
                    $customer->save();
                }
            $Assign_user_phone = User::where('id', $request->user)->first();
            $setting  = Utility::settings(\Auth::user()->creatorId());
            $uArr = [
                'meeting_name' => $request->name,
                'meeting_start_date' => $request->start_date,
                'meeting_due_date' => $request->start_date,
            ];
            $resp = Utility::sendEmailTemplate('meeting_assigned', [$meeting->id => $Assign_user_phone->email], $uArr);
            if (isset($setting['twilio_meeting_create']) && $setting['twilio_meeting_create'] == 1) {
                $uArr = [
                    'meeting_name' => $request->name,
                    'meeting_start_date' => $request->start_date,
                    'meeting_due_date' => $request->start_date,
                    'user_name' => \Auth::user()->name,
                ];
                Utility::send_twilio_msg($Assign_user_phone->phone, 'new_meeting', $uArr);
            }
            if ($request->get('is_check')  == '1') {
                $type = 'meeting';
                $request1 = new Meeting();
                $request1->title = $request->name;
                $request1->start_date = $request->start_date;
                $request1->end_date = $request->start_date;
                Utility::addCalendarData($request1, $type);
            }
            $url = 'https://fcm.googleapis.com/fcm/send';
            // $FcmToken = 'e0MpDEnykMLte1nJ0k3SU7:APA91bGpbv-KQEzEQhR1ApEgGFmn9H5tEkdpvG2FHuyiWP3JZsP_8CKJMi5tKyTn5DYgOmeDvAWFwdiDLeG_qTXZ6lUIWL2yqrFYJkUg-KUwTsQYupk0qYsi3OCZ8MZQNbCIDa6pbJ4j';
           
            $FcmToken = User::where('type','owner')->orwhere('type','admin')->pluck('device_key')->first();
            // echo"<pre>";print_r($FcmToken);die;
            $serverKey = 'AAAAn2kzNnQ:APA91bE68d4g8vqGKVWcmlM1bDvfvwOIvBl-S-KUNB5n_p4XEAcxUqtXsSg8TkexMR8fcJHCZxucADqim2QTxK2s_P0j5yuy6OBRHVFs_BfUE0B4xqgRCkVi86b8SwBYT953dE3X0wdY'; // ADD SERVER KEY HERE PROVIDED BY FCM
            $data = [
                "to" =>$FcmToken,
                "notification" => [
                    "title" => 'Event created.',
                    "body" => 'New Event is Created',  
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
            // if (\Auth::user()) {
            //     return redirect()->back()->with('success', __('Event created!') . ((isset($msg) ? '<br> <span class="text-danger">' . $msg . '</span>' : '')));
            // } else {
            //     return redirect()->back()->with('error', __('Webhook call failed.') . ((isset($msg) ? '<br> <span class="text-danger">' . $msg . '</span>' : '')));
            // }
            if (\Auth::user()->type == 'owner') {
                $meetings = Meeting::with('assign_user')->orderby('id','desc')->get();
             
            } else {
                $meetings = Meeting::with('assign_user')->where('user_id', \Auth::user()->id)->orderby('id','desc')->get();
              
            }
            return redirect()->route('meeting.index', compact('meetings'))->with('success', __('Event created!'));

        }
    }
    /**
     * Display the specified resource.
     *
     * @param \App\Meeting $meeting
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Meeting $meeting)
    {
        if (\Auth::user()->can('Show Meeting')) {
            $status = Meeting::$status;
            $ids = explode(',', $meeting->user_id);
            foreach ($ids as $id) {
                $name[] = User::where('id', $id)->pluck('name')->first();
            }
            $name = implode(',', $name);
            return view('meeting.view', compact('meeting', 'status', 'name'));
        } else {
            return redirect()->back()->with('error', 'permission Denied');
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Meeting $meeting
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Meeting $meeting)
    {
        if (\Auth::user()->can('Edit Meeting')) {
            $status            = Meeting::$status;
            $attendees_lead    = Lead::where('id', $meeting->attendees_lead)->where('lead_status',1)->get()->pluck('leadname')->first();
            $users  = User::where('created_by', \Auth::user()->creatorId())->get();
            $function_p = explode(',', $meeting->function);
            $venue_function = explode(',', $meeting->venue_selection);
            $food_package =  json_decode($meeting->func_package, true);
            $user_id = explode(',', $meeting->user_id);
            $setup = Setup::all();
            return view('meeting.edit', compact('user_id', 'users', 'setup', 'food_package', 'function_p', 'venue_function', 'meeting', 'status', 'attendees_lead'))->with('start_date', $meeting->start_date)->with('end_date', $meeting->start_date);
        } else {
            return redirect()->back()->with('error', 'permission Denied');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Meeting $meeting
     *
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Meeting $meeting)
    {
        if (\Auth::user()->can('Edit Meeting')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:120',
                    'start_date' => 'required',
                    // 'end_date' => 'required',
                    'email' => 'required|email|max:120',
                    'lead_address' => 'required|max:120',
                    'type' => 'required',
                    'venue' => 'required|max:120',
                    'function' => 'required|max:120',
                    'guest_count' => 'required',
                    'start_time' => 'required',
                    'end_time' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first())
                ->withErrors($validator)
                ->withInput();
            }
            $start_date = $request->input('start_date');
            $end_date = $request->input('start_date');
            $start_time = $request->input('start_time');
            $end_time = $request->input('end_time');
            $venue_selected = $request->input('venue');

            $overlapping_event = Meeting::where('start_date', '<=', $end_date)
                ->where('end_date', '>=', $start_date)
                ->where(function ($query) use ($start_date, $end_date, $start_time, $end_time, $venue_selected) {
                    foreach ($venue_selected as $v) {
                        $query->orWhere(function ($q) use ($start_date, $end_date, $start_time, $end_time, $v) {
                            $q->where('venue_selection', 'LIKE', "%$v%")
                                ->where('end_time', '>', $start_time)
                                ->where('start_time', '<', $end_time)
                                ->where('start_date', '<=', $end_date)
                                ->where('end_date', '>=', $start_date);
                        });
                    }
                })->where('id', '<>', $meeting->id)->count();

            if ($overlapping_event > 0) {
                return redirect()->back()->with('error', 'Event with overlapping time and matching venue already exists!') 
                ->withInput();
            }

            $overlapping_event = Blockdate::where('start_date', '<=', $end_date)
                ->where('end_date', '>=', $start_date)
                ->where(function ($query) use ($start_date, $end_date,$venue_selected) {
                    foreach ($venue_selected as $v) {
                        $query->orWhere(function ($q) use ($start_date, $end_date,$v) {
                            $q->where('venue', 'LIKE', "%$v%")
                                // ->where('end_time', '>', $start_time)
                                // ->where('start_time', '<', $end_time)
                                ->where('start_date', '<=', $end_date)
                                ->where('end_date', '>=', $start_date);
                        });
                    }
                })->where('id', '<>', $meeting->id)->count();

            if ($overlapping_event > 0) {
                return redirect()->back()->with('error', 'Date Already Blocked for corresponding time and Venue');
            }

            if (isset($_REQUEST['venue'])) {
                $venue = implode(',', $_REQUEST['venue']);
            }
            if (isset($_REQUEST['function'])) {
                $function = implode(',', $_REQUEST['function']);
            }
            if (isset($_REQUEST['meal'])) {
                $meal = $_REQUEST['meal'];
            }

            $data = $request->all();
            $package = [];
            $additional = [];
            $bar_pack =[];
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

            $meeting['user_id']           = implode(',', $request->user);
            $meeting['name']              = $request->name;
            $meeting['start_date']        = $request->start_date;
            $meeting['end_date']          = $request->start_date;
            $meeting['relationship']       = $request->relationship;
            $meeting['type']               = $request->type;
            $meeting['venue_selection']    = $request->venue_selection;
            $meeting['email']              = $request->email;
            $meeting['lead_address']      = $request->lead_address;
            $meeting['function']           = $function;
            $meeting['venue_selection']    = $venue;
            $meeting['func_package']       = $package;
            $meeting['guest_count']        = $request->guest_count;
            $meeting['room']                = $request->rooms;
            $meeting['meal']                = $meal ??'';
            $meeting['bar']                 = $request->baropt;
            $meeting['bar_package']         = $bar_pack;
            $meeting['spcl_request']        = $request->spcl_request;
            $meeting['alter_name']          = $request->alter_name;
            $meeting['alter_email']         = $request->alter_email;
            $meeting['alter_relationship']  = $request->alter_relationship;
            $meeting['alter_lead_address']  = $request->alter_lead_address;
            $meeting['phone']               = $phone;
            $meeting['start_time']          = $request->start_time;
            $meeting['end_time']            = $request->end_time;
            $meeting['ad_opts']             = isset($additional) ? $additional : '';
            $meeting['floor_plan']          = $request->uploadedImage;
            $meeting['allergies']          = $request->allergies;
            $meeting['created_by']        = \Auth::user()->creatorId();
            $meeting->update();
            if (!empty($request->file('atttachment'))) {
                $file = $request->file('atttachment');
                $originalName = $file->getClientOriginalName();
                $filename =  Str::random(3).'_'.$originalName;
                $folder = 'Event/' .  $meeting->id; // Example: uploads/1
                try {
                    $path = $file->storeAs($folder, $filename, 'public');
                    $document = new EventDoc();
                    $document->event_id =  $meeting->id; // Assuming you have a lead_id field
                    $document->filename = $filename; // Store original file name
                    $document->filepath = $path; // Store file path
                    $document->save();
                } catch (\Exception $e) {
                    Log::error('File upload failed: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'File upload failed');
                }
               
            } 
            // if (!empty($request->file('attachment'))){
            //     $file =  $request->file('attachment');
            //     $filename = 'Event_'.Str::random(7) . '.' . $file->getClientOriginalExtension();
            //     $folder = 'Event/' . $id; // Example: uploads/1
            //     try {
            //         $path = $file->storeAs($folder, $filename, 'public');
            //     } catch (\Exception $e) {
            //         Log::error('File upload failed: ' . $e->getMessage());
            //         return redirect()->back()->with('error', 'File upload failed');
            //     }
            // }
            if (\Auth::user()->type == 'owner') {
                $meetings = Meeting::with('assign_user')->orderby('id','desc')->get();
            } else {
                $meetings = Meeting::with('assign_user')->where('user_id', \Auth::user()->id)->orderby('id','desc')->get();
            }
            return redirect()->route('meeting.index', compact('meetings'))->with('success', __('Event Updated!'));
        } else {
            return redirect()->back()->with('error', 'Permission Denied');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Meeting $meeting
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meeting $meeting)
    {
        if (\Auth::user()->can('Delete Meeting')) {
            $meeting->delete();
            Billing::where('event_id',$meeting->id)->delete();
            // Billingdetail::where('event_id', $meeting->id)->delete();
            Agreement::where('event_id', $meeting->id)->delete();
            return redirect()->back()->with('success', 'Event Deleted!');
        } else {
            return redirect()->back()->with('error', 'permission Denied');
        }
    }

    public function grid()
    {
        $meetings = Meeting::where('created_by', \Auth::user()->creatorId())->get();

        $defualtView         = new UserDefualtView();
        $defualtView->route  = \Request::route()->getName();
        $defualtView->module = 'meeting';
        $defualtView->view   = 'grid';
        User::userDefualtView($defualtView);
        return view('meeting.grid', compact('meetings'));
    }

    public function getparent(Request $request)
    {
        if ($request->parent == 'account') {
            $parent = Account::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id')->toArray();
        } elseif ($request->parent == 'lead') {
            $parent = Lead::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id')->toArray();
        } elseif ($request->parent == 'contact') {
            $parent = Contact::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id')->toArray();
        } elseif ($request->parent == 'opportunities') {
            $parent = Opportunities::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id')->toArray();
        } elseif ($request->parent == 'case') {
            $parent = CommonCase::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id')->toArray();
        } else {
            $parent = '';
        }

        return response()->json($parent);
    }

    public function get_meeting_data(Request $request)
    {
        $arrayJson = [];
        if ($request->get('calender_type') == 'goggle_calender') {
            $type = 'meeting';
            $arrayJson =  Utility::getCalendarData($type);
        } else {
            $data = Meeting::where('created_by', \Auth::user()->creatorId())->get();
            $blockeddate = Blockdate::where('created_by', \Auth::user()->creatorId())->get();
            foreach ($data as $val) {
                $end_date = date_create($val->end_date);
                date_add($end_date, date_interval_create_from_date_string("1 days"));
                $arrMeeting[] = [
                    "id" => $val->id,
                    "title" => $val->name,
                    "start" => $val->start_date,
                    "end" => date_format($end_date, "Y-m-d H:i:s"),
                    "className" => $val->color,
                    "url" => route('meeting.show', $val['id']),
                    "textColor" => '#FFF',
                    "allDay" => true,
                ];
            }
            foreach ($blockeddate as $val) {
                $blockingUser = $val->user ?? null;
                $blockingUserName = $blockingUser ? $blockingUser->name : 'Unknown User';

                $expireDate = date('Y-m-d', strtotime($val->end_date . ' + 1 days'));

                $uniqueId = $val->unique_id;

                $arrblock[] = [
                    "id" => $val->id,
                    "title" => $val->purpose,
                    "start" => $val->start_date,
                    "end" => $expireDate,
                    "className" => $val->color,
                    "textColor" => '#fff',
                    "allDay" => true,
                    // "display" => 'background',
                    "url" => url('/show-blocked-date-popup' . '/' . $val->id),
                    "backgroundColor" => "grey",
                    "blocked_by" => $blockingUserName, 
                    "unique_id" => $uniqueId,
                ];
            }
            $arrayJson = array_merge($arrMeeting, $arrblock);
        }

        return $arrayJson;
    }
    public function get_lead_data(Request $request)
    {
        $lead = Lead::where('id', $request->venue)->first();
        return $lead;
    }

    // 22-01-2024
    public function block_date(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d',
            // 'start_time' => 'required|date_format:H:i',
            // 'end_time' => 'required|date_format:H:i|after:start_time',
            'purpose' => 'required',
            'venue' => 'required|array',
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $venue_selected = $request->input('venue');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        // $start_time = $request->input('start_time');
        // $end_time = $request->input('end_time');

        $overlapping_meetings = Meeting::where('start_date', '<=', $end_date)
            ->where('end_date', '>=', $start_date)
            ->where(function ($query) use ($start_date, $end_date, $venue_selected) {
                foreach ($venue_selected as $v) {
                    $query->orWhere(function ($q) use ($start_date, $end_date, $v) {
                        $q->where('venue_selection', 'LIKE', "%$v%")
                            // ->where('end_time', '>', $start_time)
                            // ->where('start_time', '<', $end_time)
                            ->where('start_date', '<=', $end_date)
                            ->where('end_date', '>=', $start_date);
                    });
                }
            })->count();

        if ($overlapping_meetings > 0) {
            return redirect()->back()->with('error', 'Event is Already Booked For this date or time');
        }

        $overlapping_event = Blockdate::where('start_date', '<=', $end_date)
            ->where('end_date', '>=', $start_date)
            ->where(function ($query) use ($start_date, $end_date,$venue_selected) {
                foreach ($venue_selected as $v) {
                    $query->orWhere(function ($q) use ($start_date, $end_date, $v) {
                        $q->where('venue', 'LIKE', "%$v%")
                            // ->where('end_time', '>', $start_time)
                            // ->where('start_time', '<', $end_time)
                            ->where('start_date', '<=', $end_date)
                            ->where('end_date', '>=', $start_date);
                    });
                }
            })->count();

        if ($overlapping_event > 0) {
            return redirect()->back()->with('error', 'Date Already Blocked for corrosponding time and Venue');
        }

        $venue = implode(',', $_REQUEST['venue']);
        $block = new Blockdate();
        $block->start_date = $start_date;
        $block->end_date = $end_date;
        // $block->start_time = (new DateTime($start_time))->format('H:i:s');
        // $block->end_time = (new DateTime($end_time))->format('H:i:s');
        $block->purpose = $request->purpose;
        $block->venue = $venue;
        $block->unique_id = uniqid();
        $block->created_by = \Auth::user()->id;
        $block->save();
        // echo "<pre>";print_r($block);die;
        return redirect()->back()->with('success', __('Date Blocked'));
    }
    public function unblock_date(Request $request)
    {
        $unblock_date = $request->input('unblock_date');

        $existing_block = Blockdate::where('start_date', '<=', $unblock_date)
            ->where('end_date', '>=', $unblock_date)
            ->first();

        if ($existing_block) {
            if ($existing_block->start_date == $unblock_date && $existing_block->end_date == $unblock_date) {
                $existing_block->delete();
            } else {
                if ($existing_block->start_date == $unblock_date) {
                    $existing_block->start_date = date('Y-m-d', strtotime($unblock_date . ' + 1 day'));
                } elseif ($existing_block->end_date == $unblock_date) {
                    $existing_block->end_date = date('Y-m-d', strtotime($unblock_date . ' - 1 day'));
                } else {
                    $new_block = clone $existing_block;
                    $existing_block->end_date = date('Y-m-d', strtotime($unblock_date . ' - 1 day'));
                    $new_block->start_date = date('Y-m-d', strtotime($unblock_date . ' + 1 day'));
                    $new_block->save();
                }
                $existing_block->save();
            }

            return redirect()->back()->with('success', __('Date Successfully Unblocked'));
        } else {
            return redirect()->back()->with('error', __('Blockdate not found for the specified date'));
        }
    }

    public function share_event(Meeting $meeting)
    {
        return view('meeting.shareview', compact('meeting'));
    }
    public function get_event_info(Request $request, $id)
    {
        $settings = Utility::settings();
        $id = decrypt(urldecode($id));
        $meeting = Meeting::find($id);
        if (!empty($request->file('attachment'))){
            $file =  $request->file('attachment');
            $filename = Str::random(3).'_'. $file->getClientOriginalName();
            $folder = 'Agreement_attachments/' . $id; 
            try {
                $path = $file->storeAs($folder, $filename, 'public');
            } catch (\Exception $e) {
                Log::error('File upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'File upload failed');
            }
        }
        $agrementinfo = new AgreementInfo();
        $agrementinfo->event_id = $id;
        $agrementinfo->email = $request->email;
        $agrementinfo->subject = $request->subject;
        $agrementinfo->content = $request->emailbody;
        $agrementinfo->attachments = $filename ?? '';
        $agrementinfo->created_by = \Auth::user()->id;
        $agrementinfo->save();
        $subject = $request->subject;
        $content = $request->emailbody;
        
        // $file = $request->file('attachment');
        // if(!empty($tempFilePath)){
        //     $tempFilePath = $file->store('temp', 'local');
        //     // Get the full path to the temporary file
        //     $tempFilePath = storage_path('app/' . $tempFilePath);
        // }
       
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
            Mail::to($request->email)->send(new SendEventMail($meeting,$subject,$content,$agrementinfo));
            $meeting->update(['status' => 1]);
        } catch (\Exception $e) {
            // return response()->json(
            //     [
            //         'is_success' => false,
            //         'message' => $e->getMessage(),
            //     ]
            // );
            return redirect()->back()->with('error', 'Email Not Sent');
        }
        return redirect()->back()->with('success', 'Email Sent Successfully');
    }
    public function download_meeting($id)
    {
        $meeting = Meeting::findOrFail($id);
        $pdf = PDF::loadView('meeting.pdf.meeting', compact('meeting'));
        return $pdf->download('meeting-details.pdf');
    }
    public function agreement($id)
    {
        $decryptedId = decrypt(urldecode($id));
        $meeting = Meeting::find($decryptedId);
        $fixed_cost = Billing::where('event_id',$decryptedId)->first();
        $agreement = Agreement::where('event_id', $decryptedId)->first();
        $data = [
            'agreement' => $agreement,
            'meeting' => $meeting,
            'billing' => $fixed_cost,
            'billing_data' => unserialize($fixed_cost->data),
        ];
        $pdf = Pdf::loadView('meeting.agreement.view', $data);
        return $pdf->stream('agreement.pdf');
    }
    public function signedagreementview($id)
    {
        $id = decrypt(urldecode($id));
        $agreement = Agreement::where('event_id', $id)->exists();
        // if ($agreement) {
        //     return view('meeting.agreement_error', compact('id'));
        // } else {
            $meeting = Meeting::find($id);
            $settings = Utility::settings();
            $billing = Billing::where('event_id',$id)->first();
            $billing_data = unserialize($billing->data);
            $venue = explode(',', $settings['venue']);
            return view('meeting.agreement.signedagreement', compact('meeting', 'venue', 'billing', 'settings','billing_data'));
        // }
    }
    public function signedagreementresponse(Request $request, $id)
    {
        $id = decrypt(urldecode($id));
        if (!empty($request->imageData)) {
            $image = $this->uploadSignature($request->imageData);
        } else {
            return redirect()->back()->with('error', ('Please Sign agreement for confirmation'));
        }
        $meeting = Meeting::find($id);
        $settings = Utility::settings();
        $users = User::where('type','owner')->orwhere('type','Admin')->get();

        $fixed_cost = Billing::where('event_id',$id)->first();
        $agreement = Agreement::where('event_id', $id)->first();
        $data = [
            'agreement' => $agreement,
            'meeting' => $meeting,
            'billing' => $fixed_cost,
            'settings' => $settings,
            'billing_data' => unserialize($fixed_cost->data),
        ];
        $pdf = Pdf::loadView('meeting.agreement.view', $data);
        // $existagreement = Agreement::where('event_id', $id)->exists();
        // if ($existagreement == TRUE) {
        //     Agreement::where('event_id', $id)->update([
        //         'signature' => $image,
        //     ]);
        //     return redirect()->back()->with('error', ('Agreement is already confirmed'));
        //     return $pdf->stream('agreement.pdf');
        // }
        $agreements = new Agreement();
        $agreements['event_id'] = $id;
        $agreements['signature'] = $image;
        $agreements['notes'] = $request->comments;
        $agreements->save();
        try {
            $filename = 'agreement_' . time() . '.pdf'; // You can adjust the filename as needed
            $folder = 'Agreement_response/' . $id; 
            $path = Storage::disk('public')->put($folder . '/' . $filename, $pdf->output());
            $agreements->update(['agreement_response' => $filename]);
         
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
            Mail::to($meeting->email)->cc($user->email)
            ->send(new AgreementResponseMail($agreements,$meeting));
            }
            $meeting->update(['total' => $request->grandtotal, 'status' => 2]);

        } catch (\Exception $e) {
            //   return response()->json(
            //             [
            //                 'is_success' => false,
            //                 'message' => $e->getMessage(),
            //             ]
            //         );
          return redirect()->back()->with('success', 'Email Not Sent');
      
        }
        return $pdf->stream('agreement.pdf');
       
    }
    public function uploadSignature($signed)
    {
        $folderPath = public_path('agreement/');
        $image_parts = explode(";base64,", $signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . uniqid() . '.' . $image_type;
        file_put_contents($file, $image_base64);
        return $file;
    }
    public function review_agreement($id)
    {
        $id = decrypt(urldecode($id));
        $meeting = Meeting::where('id', $id)->first();
        $status            = Meeting::$status;
        $attendees_lead    = Lead::where('id', $meeting->attendees_lead)->where('lead_status',1)->get()->pluck('leadname')->first();
        $users  = User::where('created_by', \Auth::user()->creatorId())->get();
        $function_p = explode(',', $meeting->function);
        $venue_function = explode(',', $meeting->venue_selection);
        $food_package = json_decode($meeting->func_package, true);
        $user_id = explode(',', $meeting->user_id);
        $setup = Setup::all();
        $bar =  explode(',', $meeting->bar);
        return view('meeting.agreement.review_agreement', compact('user_id', 'users', 'setup', 'food_package', 'function_p', 'venue_function', 'meeting', 'status', 'attendees_lead'))->with('start_date', $meeting->start_date)->with('end_date', $meeting->start_date);
    }
    public function mail_testing()
    {
        /*$settings=Utility::settings();
          
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
            ); */

        $maildata = [
            'name' => 'name',
            'email' => 'email',
        ];
        $mail = Mail::to('testing.test3215@gmail.com')->send(new TestingMail($maildata));
        if ($mail) {
            echo 'Email has sent successfully.';
        } else {
            echo 'Email sending failed.';
        }

        // $to = 'testing.test3215@gmail.com'; 
        // $from = 'testing.test3215@gmail.com'; 
        // $fromName = 'Sender_Name';
        // $subject = "Send Text Email with PHP by CodexWorld";
        // $message = "First line of text\nSecond line of text";
        // $headers = 'From: '.$fromName.'<'.$from.'>';
        // if(mail($to, $subject, $message, $headers)){ 
        //   echo 'Email has sent successfully.'; 
        // }else{ 
        //   echo 'Email sending failed.'; 
        // }
    }
    public function review_agreement_data(Request $request, $id)
    {
        $meeting = Meeting::find($id);
        $settings = Utility::settings();
        if ($request->status == 'Approve') {
            $status = 3;
        } elseif ($request->status == 'Resend') {
            $status = 4;
        } elseif ($request->status == 'Withdraw') {
            // Lead::where('id',$)
            $status = 5;
        }
        $break_package = $lunch_package = $dinner_package = $wedding_package = '';
        if (isset($_REQUEST['venue'])) {
            $venue = implode(',', $_REQUEST['venue']);
        }
        if (isset($_REQUEST['function'])) {
            $function = implode(',', $_REQUEST['function']);
        }
        if (isset($_REQUEST['meal'])) {
            $meal = $_REQUEST['meal'];
        }

        if (isset($_REQUEST['break_package'])) {
            $break_package = implode(',', $_REQUEST['break_package']);
        }
        if (isset($_REQUEST['lunch_package'])) {
            $lunch_package = implode(',', $_REQUEST['lunch_package']);
        }
        if (isset($_REQUEST['dinner_package'])) {
            $dinner_package = implode(',', $_REQUEST['dinner_package']);
        }
        if (isset($_REQUEST['wedding_package'])) {
            $wedding_package = implode(',', $_REQUEST['wedding_package']);
        }

        $phone= preg_replace('/\D/', '', $request->input('phone'));
        $data = $request->all();
        $package = [];
            $additional = [];
            $bar_pack =[];
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

        $packagesArray = implode(',', array($break_package, $lunch_package, $dinner_package, $wedding_package));
        $meeting['user_id']           = implode(',', $request->user);
        $meeting['name']              = $request->name;
        $meeting['start_date']        = $request->start_date;
        $meeting['end_date']          = $request->start_date;
        $meeting['relationship']       = $request->relationship;
        $meeting['type']               = $request->type;
        $meeting['email']              = $request->email;
        $meeting['lead_address']      = $request->lead_address;
        $meeting['status']               = $status;
        $meeting['function']           = $function;
        $meeting['venue_selection']    = $venue;
        $meeting['func_package']       = $packagesArray;
        $meeting['guest_count']        = $request->guest_count;
        $meeting['room']                = $request->rooms;
        $meeting['meal']                = $meal??'';
        $meeting['bar']                 = $request->baropt;
        $meeting['spcl_request']        = $request->spcl_request;
        $meeting['alter_name']          = $request->alter_name;
        $meeting['alter_email']         = $request->alter_email;
        $meeting['alter_relationship']  = $request->alter_relationship;
        $meeting['alter_lead_address']  = $request->alter_lead_address;
        $meeting['bar_package']         = $bar_pack;
        $meeting['phone']               = $phone;
        $meeting['start_time']        = $request->start_time;
        $meeting['end_time']        = $request->end_time;
        $meeting['ad_opts']             = isset($additional) ? $additional : '';
        $meeting['floor_plan']          = $request->uploadedImage;
        $meeting['allergies']          = $request->allergies;
        $meeting['created_by']        = \Auth::user()->creatorId();
        $meeting->update();
        if (!empty($request->file('attachment'))){
            $file =  $request->file('attachment');
            $filename = 'Event_'.Str::random(7) . '.' . $file->getClientOriginalExtension();
            $folder = 'Event/' . $id; // Example: uploads/1
            try {
                $path = $file->storeAs($folder, $filename, 'public');
            } catch (\Exception $e) {
                Log::error('File upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'File upload failed');
            }
        }
        if ($status == 3) {
            if (\Auth::user()->type == 'owner') {
                $meetings = Meeting::with('assign_user')->orderby('id','desc')->get();
             
            } else {
                $meetings = Meeting::with('assign_user')->where('user_id', \Auth::user()->id)->orderby('id','desc')->get();
              
            }
            return redirect()->route('meeting.index', compact('meetings'))->with('success', __('Event Approved!'));
        } elseif ($status == 4) {
            Agreement::where('event_id', $id)->delete();
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

                Mail::to($meeting->email)->send(new SendEventMail($meeting));
            } catch (\Exception $e) {
                // \Log::error('Error sending email: ' . $e->getMessage());
                // return response()->json(
                //     [
                //         'is_success' => false,
                //         'message' => $e->getMessage(),
                //     ]
                // );
                return redirect()->back()->with('success', 'Email Not Sent');
            }
            if (\Auth::user()->type == 'owner') {
                $meetings = Meeting::with('assign_user')->orderby('id','desc')->get();
             
            } else {
                $meetings = Meeting::with('assign_user')->where('user_id', \Auth::user()->id)->orderby('id','desc')->get();
              
            }
            return redirect()->route('meeting.index', compact('meetings'))->with('success', __('Event Resent!'));
        } elseif ($status == 5) {
            if (\Auth::user()->type == 'owner') {
                $meetings = Meeting::with('assign_user')->orderby('id','desc')->get();
             
            } else {
                $meetings = Meeting::with('assign_user')->where('user_id', \Auth::user()->id)->orderby('id','desc')->get();
              
            }
            return redirect()->route('meeting.index', compact('meetings'))->with('success', __('Event Withdrawn!'));
        }
        if (\Auth::user()->type == 'owner') {
            $meetings = Meeting::with('assign_user')->orderby('id','desc')->get();
         
        } else {
            $meetings = Meeting::with('assign_user')->where('user_id', \Auth::user()->id)->orderby('id','desc')->get();
          
        }
        return redirect()->route('meeting.index', compact('meetings'))->with('success', __('Event Updated!'));

    }
    public function buffer_time(Request $request)
    {

        $startDate = $request->startdate;
        $endDate = date('Y-m-d', strtotime($request->enddate . ' -1 day'));
        $venue = $request->venue;
        $blockdate = Blockdate::where(function ($query) use ($startDate, $endDate, $venue) {
            $query->whereBetween('start_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate]);
        })
            ->where('venue', 'like', '%' . $venue . '%')
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();

        $meetings = Meeting::where(function ($query) use ($startDate, $endDate, $venue) {
            $query->whereBetween('start_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate]);
        })
            ->where('venue_selection', 'like', '%' . $venue . '%')
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();

        $data = array_merge($blockdate, $meetings);

        if (!empty($data)) {
            $settings = Utility::settings();
            $settings = explode(":", $settings['buffer_time']);

            $bufferedTime = date('H:i:s', strtotime("+{$settings[0]} hour +{$settings[1]} minutes", strtotime($data[0]['end_time'])));

            return response()->json(['data' => $data, 'bufferedTime' => $bufferedTime]);
        }

        return response()->json(['data' => []]);
    }
    public function getpackages(Request $request)
    {
        $settings = Utility::settings();
        $add_items = json_decode($settings['additional_items'], true);
        $selectedFunctions = $request->selectedFunctions;
        // print_r($add_items);
        // print_r($request->all());
        // Iterate over each selected function
        foreach ($selectedFunctions as $selectedFunction) {
            // Check if the selected function exists in the meal details
            if (isset($add_items[$selectedFunction])) {
                $selectedFunctionDetails = $add_items[$selectedFunction];
                // Iterate over each meal type within the selected function
                print_r($selectedFunctionDetails);

                foreach ($selectedFunctionDetails as $mealType => $items) {
                    return json_encode($mealType);
                    echo "$mealType\n";
                    // Iterate over each item within the meal type
                    // foreach ($items as $item => $quantity) {
                    //     echo "Item: $item, Quantity: $quantity\n";
                    // }
                }
            } else {
                echo "'$selectedFunction' meal type not found.\n";
            }
        }
    }
    public function detailed_info($id){
        $id= decrypt(urldecode($id));
        // echo "<pre>";print_r($id);die;
        // $event = Meeting::find($id);
        $event = Meeting::find($id);

        return view('meeting.detailed_view',compact('event'));
    }
    public function event_user_info($id){
        $id = decrypt(urldecode($id));
        $email = Meeting::withTrashed()->find($id)->email;
        $events = Meeting::withTrashed()->where('email',$email)->get();
        // $event = Meeting::withTrashed()->find($id);
        $notes = NotesEvents::where('event_id',$id)->orderby('id','desc')->get();
        $docs = EventDoc::where('event_id',$id)->get();
        return view('customer.eventuserview',compact('events','docs','notes'));
    }
    public function event_upload_doc(Request $request,$id){
        $file = $request->file('customerattachment');

        if ($file) {
            $originalName = $file->getClientOriginalName();
            $filename =  Str::random(3).'_'.$originalName;
            $folder = 'Event/' . $id; // Example: uploads/1
            try {
                $path = $file->storeAs($folder, $filename, 'public');
            } catch (\Exception $e) {
                Log::error('File upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'File upload failed');
            }
            $document = new EventDoc();
            $document->event_id = $id; // Assuming you have a lead_id field
            $document->filename = $filename; // Store original file name
            $document->filepath = $path; // Store file path
            $document->save();
            return redirect()->back()->with('success', 'Document Uploaded Successfully');
        } else {
            return redirect()->back()->with('error', 'No file uploaded');
        }
        
    }
    public function eventnotes(Request $request,$id){
        $notes = new NotesEvents();
        $notes->notes = $request->notes;
        $notes->created_by = $request->createrid;
        $notes->event_id = $id;
        $notes->save();
        return true;
    }
   
}