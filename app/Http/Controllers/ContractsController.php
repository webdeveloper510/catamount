<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Contracts;
use App\Models\ContractType;
use App\Models\ContractAttechment;
use App\Models\ContractComment;
use App\Models\ContractNote;
use App\Models\ActivityLog;
use App\Models\Plan;
use App\Models\Utility;
use App\Models\User;
use Illuminate\Http\Request;
use Str;
use Http;
use Storage;

class ContractsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::user()->type == 'owner') {
            $contracts = Contracts::all();
            // $contracts   = Contract::with('contract_type')->where('created_by', '=', \Auth::user()->creatorId())->get();
            // $curr_month  = Contract::where('created_by', '=', \Auth::user()->creatorId())->whereMonth('start_date', '=', date('m'))->get();
            // $curr_week   = Contract::where('created_by', '=', \Auth::user()->creatorId())->whereBetween(
            //     'start_date',
            //     [
            //         \Carbon\Carbon::now()->startOfWeek(),
            //         \Carbon\Carbon::now()->endOfWeek(),
            //     ]
            // )->get();
            // $last_30days = Contract::where('created_by', '=', \Auth::user()->creatorId())->whereDate('start_date', '>', \Carbon\Carbon::now()->subDays(30))->get();

            // // Contracts Summary
            // $cnt_contract                = [];
            // $cnt_contract['total']       = \App\Models\Contract::getContractSummary($contracts);
            // $cnt_contract['this_month']  = \App\Models\Contract::getContractSummary($curr_month);
            // $cnt_contract['this_week']   = \App\Models\Contract::getContractSummary($curr_week);
            // $cnt_contract['last_30days'] = \App\Models\Contract::getContractSummary($last_30days);

            return view('contract.index', compact('contracts'));
        }
        else{
            $contracts = Contracts::all();
            // $contracts   = Contract::with('contract_type')->where('client_name', '=', \Auth::user()->id)->get();
            // $curr_month  = Contract::where('client_name', '=', \Auth::user()->id)->whereMonth('start_date', '=', date('m'))->get();
            // $curr_week   = Contract::where('client_name', '=', \Auth::user()->id)->whereBetween(
            //     'start_date',
            //     [
            //         \Carbon\Carbon::now()->startOfWeek(),
            //         \Carbon\Carbon::now()->endOfWeek(),
            //     ]
            // )->get();
            // $last_30days = Contract::where('client_name', '=', \Auth::user()->id)->whereDate('start_date', '>', \Carbon\Carbon::now()->subDays(30))->get();

            // // Contracts Summary
            // $cnt_contract                = [];
            // $cnt_contract['total']       = \App\Models\Contract::getContractSummary($contracts);
            // $cnt_contract['this_month']  = \App\Models\Contract::getContractSummary($curr_month);
            // $cnt_contract['this_week']   = \App\Models\Contract::getContractSummary($curr_week);
            // $cnt_contract['last_30days'] = \App\Models\Contract::getContractSummary($last_30days);

            return view('contract.index', compact('contracts'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Auth::user()->can('Create Contract')) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.pandadoc.com/public/v1/documents",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPGET => true, // Specify that it's a GET request
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: API-Key a9450fe8468cbf168f3eae8ced825d020e84408d",
                ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
            
                return response()->json(['status' => 'error', 'message' => $err], 500);
            } else {

                $results = json_decode($response,true);
                $client    = User::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                return view('contract.create',compact('results','client'));
                // return response()->json(['status' => 'success', 'data' => json_decode($response)], 200);
            }
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
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
        if (\Auth::user()->can('Create Contract')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:20',
                    'subject' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->route('contracts.index')->with('error', $messages->first());
            }

            $date = explode(' to ', $request->date);

            $contract              = new Contracts();
            $contract->name        = $request->name;
            $contract->user_id     = $request->client_name;
            $contract->subject     = $request->subject;
            $contract->created_by  = \Auth::user()->creatorId();
            $contract->save();
            if (!empty($request->file('atttachment'))) {
                $file = $request->file('atttachment');
                $originalName = $file->getClientOriginalName();
                $filename =  Str::random(3).'_'.$originalName;
                $folder = 'Contracts/' .  $contract->id; // Example: uploads/1
                try {
                    $path = $file->storeAs($folder, $filename, 'public');
                  
                } catch (\Exception $e) {
                    Log::error('File upload failed: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'File upload failed');
                }
            }                 
           

                $contract->update(['attachment'=> $filename]);
                $name =  $request->name;
                $url = "https://cdn2.hubspot.net/hubfs/2127247/public-templates/SamplePandaDocPdf_FormFields.pdf";
                // $url = Storage::url('app/public/Contracts/'.$contract->id.'/'. $filename);
                // Assuming $filename is the name of the file stored in Laravel's storage
                $recipientEmail = 'sonali@codenomad.net';
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.pandadoc.com/public/v1/documents",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => json_encode([
                        "name" => $name,
                        "url" => $url,
                        "recipients" => [
                            [
                                "email" => $recipientEmail,
                                "role" => "user",
                            ],
                        ],
                        "parse_form_fields" => false,
                    ]),
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/json",
                        "Authorization: API-Key a9450fe8468cbf168f3eae8ced825d020e84408d",
                    ),
                ));
                // echo"<pre>";print_r($curl);die;
                // Replace 'YOUR_PANDADOC_API_KEY' with your actual PandaDoc API key
                $response = curl_exec($curl);
              
                $err = curl_error($curl);
                curl_close($curl);
                if ($err) {
                    return response()->json(['status' => 'error', 'message' => $err], 500);
                } else {
                    $data = json_decode($response, true);
                   
                    $documentId = $data['id'];
                   
                    sleep(2);
                        $curl2 = curl_init();
                        // Your code for the second cURL request...
                        curl_setopt_array($curl2, array(
                            CURLOPT_URL => "https://api.pandadoc.com/public/v1/documents/".$documentId, // Replace with the actual GET endpoint
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_HTTPGET => true, // Specify that it's a GET request
                            CURLOPT_HTTPHEADER => array(
                                "Content-Type: application/json",
                                "Authorization: API-Key a9450fe8468cbf168f3eae8ced825d020e84408d",
                            ),
                        ));
                        $response2 = curl_exec($curl2);
                        $err2 = curl_error($curl2);
                        curl_close($curl2);
                        if ($err2) {
                            return response()->json(['status' => 'error', 'message' => $err2], 500);
                        } else {
                            $res= json_decode($response2, true);
                            return view('pandadoc',compact('res'));
                            // header('Location: https://app.pandadoc.com/a/#/documents/'. $res['id']);
                            // exit();
                            // return response()->json(['status' => 'success', 'data' => json_decode($response2)], 200);
                            // Process the response of the second cURL request as needed
                        
                    }
                }
               
            
            // return view('contract.edit-contract',compact('contract'));
            // $objUser = \Auth::user();
            // if($contract)
            // {
            //     $user = User::where('id',$objUser->created_by)->first();
            //     $plan = Plan::where('id',$user->plan)->first();
            // }
            // $settings  = \Utility::settings(\Auth::user()->creatorId());

            // if (isset($settings['contract_notification']) && $settings['contract_notification'] == 1) {
            //     $msg = 'New Invoice ' . \Auth::user()->contractNumberFormat($this->contractNumber()) . '  created by  ' . \Auth::user()->name . '.';

            //     \Utility::send_slack_msg($msg);
            // }
            // if (isset($settings['telegram_contract_notification']) && $settings['telegram_contract_notification'] == 1) {
            //     $resp = 'New  Invoice ' . \Auth::user()->contractNumberFormat($this->contractNumber()) . '  created by  ' . \Auth::user()->name . '.';
            //     \Utility::send_telegram_msg($resp);
            // }

            // return redirect()->route('contract.index')->with('success', __('Contract successfully created!'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function new_contract(){
        return view('pandadoc');
    }
    public function templatedetail($id){
        // $url = "https://api.pandadoc.com/public/v1/documents/".$id."/download";
       
        // $curl = curl_init();
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => $url,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_HTTPGET => true, // Specify that it's a GET request
        //     CURLOPT_HTTPHEADER => array(
        //         "Content-Type: application/json",
        //         "Authorization: API-Key a9450fe8468cbf168f3eae8ced825d020e84408d",
        //     ),
        // ));
        // $response = curl_exec($curl);
        // $err = curl_error($curl);
        // curl_close($curl);
        // if ($err) {
        //     return response()->json(['status' => 'error', 'message' => $err], 500);
        // } else {
        //     return $response;
        // }

        header('Location: https://app.pandadoc.com/a/#/documents/'. $id);
        exit();
    }
    public function newtemplate(){
        $client    = User::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

        return view('contract.newtemplate',compact('client'));
    }

    public function contract_status_edit(Request $request, $id)
    {
        $contract = Contract::find($id);
        $contract->status   = $request->status;
        $contract->save();
    }

    function contractNumber()
    {
        $latest = Contract::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if (!$latest) {
            return 1;
        }

        return $latest->id + 1;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Contract $contract
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if (\Auth::user()->can('Show Contract')) {
            $contract = Contract::find($id);
            $client   = $contract->client;

            return view('contracts.show', compact('contract', 'client'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Contract $contract
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract)
    {
        if (\Auth::user()->can('Edit Contract')) {
            if ($contract->created_by == \Auth::user()->creatorId()) {
                $client    = User::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

                // $client       = User::where('type', '=', 'Client')->get()->pluck('name', 'id');
                $contractType = ContractType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $date         = $contract->start_date . ' to ' . $contract->end_date;
                unset($contract->start_date);
                unset($contract->end_date);
                $contract->setAttribute('date', $date);

                return view('contracts.edit', compact('contract', 'contractType', 'client'));
            } else {
                return response()->json(['error' => __('Permission Denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Contract $contract
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contract $contract)
    {
        // return redirect()->back()->with('error', __('This operation is not perform due to demo mode.'));

        if (\Auth::user()->can('Edit Contract')) {
            if ($contract->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'name' => 'required|max:20',
                        'subject' => 'required',
                        'value' => 'required',
                        'type' => 'required',
                        'date' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('contract.index')->with('error', $messages->first());
                }

                $date = explode(' to ', $request->date);

                $contract->name        = $request->name;
                $contract->client_name = $request->client_name;
                $contract->subject     = $request->subject;
                $contract->value       = $request->value;
                $contract->type        = $request->type;
                $contract->start_date  = $date[0];
                $contract->end_date    = $date[1];
                $contract->notes       = $request->notes;
                $contract->save();

                return redirect()->route('contract.index')->with('success', __('Contract successfully updated!'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Contract $contract
     *
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        if (\Auth::user()->can('Delete Contract')) {
            $contract        = Contract::find($id);
            if ($contract->created_by == \Auth::user()->creatorId()) {

                $contract = Contract::find($id);
                $attechments = $contract->ContractAttechment()->get()->each;

                foreach ($attechments->items as $attechment) {
                    if (\Storage::exists('contract_attechment/' . $attechment->files)) {
                        unlink('storage/contract_attechment/' . $attechment->files);
                    }
                    $attechment->delete();
                }

                $contract->ContractComment()->get()->each->delete();
                $contract->ContractNote()->get()->each->delete();
                $contract->delete();

                return redirect()->route('contract.index')->with('success', __('Contract successfully deleted!'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }




    public function descriptionStore($id, Request $request)
    {
        if (\Auth::user()->type == 'owner') {
            $contract        = Contract::find($id);
            $contract->description = $request->description;
            $contract->save();
            return redirect()->back()->with('success', __('Note successfully saved.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied'));
        }
    }


    public function fileUpload($id, Request $request)
    {
        $contract = Contract::find($id);
        if ($contract->status == 'approve' || \Auth::user()->can('Manage Contract')) {

            $contract = Contract::find($id);
            if ($contract->created_by == \Auth::user()->creatorId()) {

                $request->validate(['file' => 'required']);

                $image_size = $request->file('file')->getSize();
                $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
                if ($result == 1) {
                    $dir = 'contract_attechment/';
                    $files = $request->file->getClientOriginalName();
                    $path = Utility::upload_file($request, 'file', $files, $dir, []);

                    if ($path['flag'] == 1) {
                        $file = $path['url'];
                    } else {
                        return redirect()->back()->with('error', __($path['msg']) . ((isset($result) && $result != 1) ? '<br> <span class="text-danger">' . $result . '</span>' : ''));
                    }

                    $file                 = ContractAttechment::create(
                        [
                            'contract_id' => $request->contract_id,
                            'user_id' => \Auth::user()->id,
                            'files' => $files,
                        ]
                    );

                    $return               = [];
                    $return['is_success'] = true;
                    $return['download']   = route(
                        'contracts.file.download',
                        [
                            $contract->id,
                            $file->id,
                        ]
                    );
                    $return['delete']     = route(
                        'contracts.file.delete',
                        [
                            $contract->id,
                            $file->id,
                        ]
                    );
                }
            else{
                $return               = [];
                $return['is_success'] = true;
                $return['status'] =1;
                $return['success_msg'] = ((isset($result) && $result!=1) ? '<br> <span class="text-danger">' . $result . '</span>' : '');
            }
                    return response()->json($return);

            } else {
                return response()->json(
                    [
                        'is_success' => false,
                        'error' => __('Permission Denied.'),
                    ],
                    401
                );
            }


        } else {
            return response()->json(
                [
                    'is_success' => false,
                    'error' => __('Contract Close'),
                ],
                401
            );
        }
    }
    public function fileDownload($id, $file_id)
    {
        if (\Auth::user()->can('Edit Deal')) {
            $contract = Contract::find($id);
            if ($contract->created_by == \Auth::user()->creatorId()) {
                $file = ContractAttechment::find($file_id);
                if ($file) {
                    $file_path = storage_path('contract_attechment/' . $file->files);

                    // $files = $file->files;

                    return \Response::download(
                        $file_path,
                        $file->files,
                        [
                            'Content-Length: ' . filesize($file_path),
                        ]
                    );
                } else {
                    return redirect()->back()->with('error', __('File is not exist.'));
                }
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function fileDelete($id, $file_id)
    {
        if (\Auth::user()->type == 'owner' || \Auth::user()->type == 'Manager') {
            $contract = Contract::find($id);
            $file = ContractAttechment::find($file_id);
            $file_path = 'contract_attechment/' . $file->files;
            $result = Utility::changeStorageLimit(\Auth::user()->creatorId(), $file_path);
            if ($file) {

                $path = storage_path('contract_attechment/' . $file->files);

                if (file_exists($path)) {
                    \File::delete($path);
                }
                $file->delete();

                return redirect()->back()->with('success', __('Attechment successfully delete.'));
            } else {
                return response()->json(
                    [
                        'is_success' => false,
                        'error' => __('File is not exist.'),
                    ],
                    200
                );
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    public function commentStore(Request $request, $id)
    {

        if (\Auth::user()->type == 'owner' ||  \Auth::user()->type == 'Manager') {
            $contract              = new ContractComment();
            $contract->comment     = $request->comment;
            $contract->contract_id = $id;
            $contract->user_id     = \Auth::user()->id;
            $contract->created_by     = \Auth::user()->id;
            $contract->save();


            return redirect()->back()->with('success', __('comments successfully created!') . ((isset($smtp_error)) ? '<br> <span class="text-danger">' . $smtp_error . '</span>' : ''))->with('status', 'comments');
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    public function commentDestroy($id)
    {
        $contract = ContractComment::find($id);
        $contract->delete();
        return redirect()->back()->with('success', __('Comment successfully deleted!'));
    }

    public function noteStore($id, Request $request)
    {

        // if(\Auth::user()->type == 'Owner')
        // {
        $contract              = Contract::find($id);
        $notes                 = new ContractNote();
        $notes->contract_id    = $contract->id;
        $notes->note           = $request->note;
        $notes->user_id        = \Auth::user()->id;
        $notes->created_by     = \Auth::user()->creatorId();
        $notes->save();
        return redirect()->back()->with('success', __('Note successfully saved.'));
        // }
        // else
        // {
        //     return redirect()->back()->with('error', __('Permission denied'));
        // }

    }


    public function noteDestroy($id)
    {
        $contract = ContractNote::find($id);

        $contract->delete();

        return redirect()->back()->with('success', __('Note successfully deleted!'));
    }

    public function sendmailContract($id, Request $request)
    {
        $contract              = Contract::find($id);
        $contractArr = [
            'contract_id' => $contract->id,
        ];
        $client = User::find($contract->client_name);

        $estArr = [
            'email' => $client->email,
            'contract_subject' => $contract->subject,
            'contract_client' => $client->name,
            'contract_start_date' => $contract->start_date,
            'contract_end_date' => $contract->end_date,
        ];

        // Send Email
        $resp = Utility::sendEmailTemplate('new_contract', [$client->id => $client->email], $estArr);
        return redirect()->route('contract.show', $contract->id)->with('success', __('Send successfully!') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
    }

    public function pdffromcontract($contract_id)
    {
        $id = \Illuminate\Support\Facades\Crypt::decrypt($contract_id);
        //Set your logo
        $logo = \App\Models\Utility::get_file('uploads/logo/');
        $dark_logo    = Utility::getValByName('dark_logo');
        $img = asset($logo . '/' . (isset($dark_logo) && !empty($dark_logo) ? $dark_logo : 'logo-dark.png'));
        $contract  = Contract::findOrFail($id);


        if (\Auth::check()) {
            $usr = \Auth::user();
        } else {

            $usr = User::where('id', $contract->created_by)->first();
        }


        return view('contracts.template', compact('contract', 'usr', 'img'));
    }


    public function printContract($id)
    {
        // if(\Auth::user()->can('Manage Invoices'))
        // {
        $contract  = Contract::findOrFail($id);
        $settings = Utility::settings();
        $client   = $contract->client_name;
        //Set your logo
        $logo = \App\Models\Utility::get_file('uploads/logo/');
        $dark_logo    = Utility::getValByName('dark_logo');
        $img = asset($logo . '/' . (isset($dark_logo) && !empty($dark_logo) ? $dark_logo : 'logo-dark.png'));

        return view('contracts.contract_view', compact('contract', 'client', 'img', 'settings'));

        // }
        // else
        // {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }
    }
    public function copycontract($id)
    {
        $contract = Contract::find($id);
        if (\Auth::user()->can('Create Contract')) {
            $client    = User::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $contractType = ContractType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $date         = $contract->start_date . ' to ' . $contract->end_date;
            unset($contract->start_date);
            unset($contract->end_date);
            $contract->setAttribute('date', $date);

            return view('contracts.copy', compact('contract', 'contractType', 'client'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    public function copycontractstore(Request $request)
    {
        if (\Auth::user()->can('Create Contract')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:20',
                    'subject' => 'required',
                    'value' => 'required',
                    'type' => 'required',
                    'date' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->route('contract.index')->with('error', $messages->first());
            }

            $date = explode(' to ', $request->date);

            $contract              = new Contract();
            $contract->name        = $request->name;
            $contract->client_name = $request->client_name;
            $contract->subject     = $request->subject;
            $contract->value       = $request->value;
            $contract->type        = $request->type;
            $contract->start_date  = $date[0];
            $contract->end_date    = $date[1];
            $contract->notes       = $request->notes;
            $contract->created_by  = \Auth::user()->creatorId();
            $contract->save();

            $settings  = \Utility::settings(\Auth::user()->creatorId());

            if (isset($settings['contract_notification']) && $settings['contract_notification'] == 1) {
                $msg = 'New Invoice ' . Auth::user()->contractNumberFormat($this->contractNumber()) . '  created by  ' . \Auth::user()->name . '.';

                \Utility::send_slack_msg($msg);
            }
            if (isset($settings['telegram_contract_notification']) && $settings['telegram_contract_notification'] == 1) {
                $resp = 'New  Invoice ' . Auth::user()->contractNumberFormat($this->contractNumber()) . '  created by  ' . \Auth::user()->name . '.';
                \Utility::send_telegram_msg($resp);
            }

            return redirect()->route('contract.index')->with('success', __('Contract successfully created!'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    public function signature($id)
    {
        $contract = Contract::find($id);


        return view('contracts.signature', compact('contract'));
    }

    public function signatureStore(Request $request)
    {
        $contract              = Contract::find($request->contract_id);

        if (\Auth::user()->type == 'owner') {
            $contract->owner_signature       = $request->owner_signature;
        }
        if (\Auth::user()->type == 'Manager') {
            $contract->client_signature       = $request->client_signature;
        }

        $contract->save();

        return response()->json(
            [
                'success' => true,
                'message' => __('Contract Signed successfully'),
            ],
            200
        );
    }
}