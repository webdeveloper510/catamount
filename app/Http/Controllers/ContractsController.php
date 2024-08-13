<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Meeting;
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
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Crypt;

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
        } else {
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

                $results = json_decode($response, true);
                $client    = User::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                return view('contract.create', compact('results', 'client'));
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
                $filename =  Str::random(3) . '_' . $originalName;
                $folder = 'Contracts/' .  $contract->id; // Example: uploads/1
                try {
                    $path = $file->storeAs($folder, $filename, 'public');
                } catch (\Exception $e) {
                    Log::error('File upload failed: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'File upload failed');
                }
            }


            $contract->update(['attachment' => $filename]);
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
                    CURLOPT_URL => "https://api.pandadoc.com/public/v1/documents/" . $documentId, // Replace with the actual GET endpoint
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
                    $res = json_decode($response2, true);
                    return view('pandadoc', compact('res'));
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

    public function new_contract()
    {
        return view('pandadoc');
    }
    public function templatedetail($id)
    {
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

        header('Location: https://app.pandadoc.com/a/#/documents/' . $id);
        exit();
    }
    public function newtemplate()
    {
        $client    = User::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

        return view('contract.newtemplate', compact('client'));
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
                } else {
                    $return               = [];
                    $return['is_success'] = true;
                    $return['status'] = 1;
                    $return['success_msg'] = ((isset($result) && $result != 1) ? '<br> <span class="text-danger">' . $result . '</span>' : '');
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

    public function sendContract(Request $request)
    {


        $all_status = Meeting::$status;

        $approvedIndexes = array_keys($all_status, "Approved");
        $approved_meetings = Meeting::where('status', $approvedIndexes[0])->orderby('id', 'desc')->get()->toArray();

        // echo "<pre>"; print_r($approved_meetings);die;

        return view('contracts.send-contract', compact('approved_meetings'));
    }

    public function getAirSlateToken()
    {

        $url = 'https://oauth.airslate.com/public/oauth/token';

        // Data to be sent in the POST request
        $data = array(
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiI5YjY5YTAzNy0zN2Q1LTQ2MzgtODM0Mi1jMGJhZjkzNGM1YWMiLCJzdWIiOiJjYzllZDA0Ni0yMzBkLTRjNjctOTAwYi04NzkzMmQzNGM5YWIiLCJpc3MiOiJvYXV0aC5haXJzbGF0ZS5jb20iLCJpYXQiOjE3MjEwMzkzODIsImV4cCI6NDg3NjcxMjkzMCwic2NvcGUiOiJlbWFpbCJ9.LpEPTjeSA_TGNTvkTZsk4cnBKKEZbfIShxSmWxhER5HZ7c_1ebMpVQwB-00gzU-mX_FdV6Vd4bAhn5IuX0TCo6cuqm5Uw7wbgMIiLU8hq8DYma3tV6Oikpv1UUPJR1gtVk8BfUGtSMMf23ZkPNDLkDxY2Gvf35llH5W7RWQwrMcF4w2ux9ZcitwTZ2Du6iaJryrY41IPeHhJHPNbVEphQTBAjDUGQdfUoHrhkDS4Fiu7VYHuSITCsk9C2wglMiBTgC3-LwSz3t43PwDqXKkK952L4XO3Nmfr1w29x9tRjB4co_R3wGEy1HpVPjUJ6loYEA_jrLt4_TIQW9I7nnIJEw'
        );

        // Initialize cURL  and Get the API Token
        $ch = curl_init();

        // Set the URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded'
        ));

        $response = curl_exec($ch);

        if ($response === FALSE) {
            die(curl_error($ch));
        }

        curl_close($ch);
        $token_data = json_decode($response, true);

        return $token_data;
    }

    public function uploadDocToS3Bucket($fileUrl, $token_data)
    {

        // Upload PDF on S3 bucket
        $curl = curl_init();

        // $fileUrl = 'https://kts-group.co.uk/wp-content/uploads/pdf-uploaded/vj.pdf';

        // Temporary file path to save the downloaded file
        $tempFilePath = tempnam(sys_get_temp_dir(), 'upload_');

        // Download the file
        file_put_contents($tempFilePath, file_get_contents($fileUrl));

        $data = new \CURLFile($tempFilePath); // Replace with the actual file path

        $postFields =   [
            'document' => $data,
            'documentName' => 'documentName' // Replace with the actual document name
        ];

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://pdf.airslate.io/v1/documents',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Authorization: Bearer ' . $token_data['access_token']
            ],
            CURLOPT_SAFE_UPLOAD => true,
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $document_id = "";
        // $document_id = "8c8e472e-4e53-11ef-bf4d-025ece3b97b7";
        if ($err) {
            // echo 'cURL Error #:' . $err;

            return 0;
        } else {

            $response = json_decode($response);
            $document_id =  $response->data->id;

            return $document_id;
        }
    }



    public function createSharebleLink($document_id, $token_data, $is_edit, $user)
    {

        list($event_id, $email) = explode('~', $user);

        $url = "https://pdf.airslate.io/v1/documents/" . $document_id . "/link";

        $call_back_url = $is_edit == "yes" ? "https://thesectoreight.com/empty" : "https://thesectoreight.com/get-contract/" . urlencode(Crypt::encrypt($event_id)) . "/" . $document_id;

        $data = [
            "callbackUri" => $call_back_url,
            "redirectUri" => $call_back_url,
            "expirationInSeconds" => 86400,
            "foreignUserId" => "vsingh@codenomad.net",
            "editorAppearanceConfig" => [
                "doneButton" => [
                    "visible" => true,
                    "label" => "Save"
                ],
                "logo" => [
                    "visible" => true,
                    "url" => "https://thesectoreight.com/storage/uploads/logo/logo-light.png"
                ],
                "tools" => [
                    ["signature" => true, "options" => ["type" => true, "draw" => true, "upload" => true]],
                    ["text" => true],
                    ["initials" => true, "options" => ["type" => true, "draw" => true, "upload" => true]],
                    ["date" => true],
                    ["x" => true],
                    ["v" => true],
                    ["o" => true],
                    ["erase" => true],
                    ["highlight" => true],
                    ["blackout" => true],
                    ["textbox" => true],
                    ["arrow" => true],
                    ["line" => true],
                    ["pen" => true],
                    ["rearrange" => true],
                    ["sticky" => true],
                    ["replaceText" => true],
                    ["image" => true]
                ],
                "options" => [
                    ["wizard" => true],
                    ["search" => true],
                    ["pagesPanel" => true]
                ],
                "advancedOptions" => [
                    ["addFillableFields" => true],
                    ["addWatermark" => true]
                ]
            ]
        ];

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer ' . $token_data['access_token']
        ];

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        curl_close($ch);
        if (curl_errno($ch)) {
            // echo 'Error:' . curl_error($ch);
            return "";
        } else {
            $link_data = json_decode($response);

            //   echo json_encode(["code" => 200 , "link" => $link_data->data->link ,"document_id" => $document_id]);
            return $link_data->data->link;
        }
    }

    public function getContractUrl(Request $request)
    {

        // echo "<pre>";

        // print_r($_POST);
        // die;


        $image = $request->file('file');
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('floor_images'), $imageName);

        $fileUrl = url('') . "/public/floor_images/" . $imageName;

        $token_data     =   $this->getAirSlateToken(); // Get Token

        if (@$token_data['access_token'] == '') {

            echo  json_encode(["code" => 201, "data" => "No Token found From Air Slate side"]);
            die;
        }
        $document_id    =   $this->uploadDocToS3Bucket($fileUrl, $token_data); // Upload To S3 Bucket

        if ($document_id == 0) {

            echo  json_encode(["code" => 201, "data" => "File not uploaded. Error occering on server side"]);
            die;
        }

        $is_edit = @$_POST['is_edit'] ? "yes" : "no";
        $user   =   @$_POST['user'] ? $_POST['user'] : '';


        $sharable_link = $this->createSharebleLink($document_id, $token_data, $is_edit, $user);

        $response = [];
        if ($sharable_link == "") {

            $response = [
                "code"  => 201,
                "data"  => "Something happedn wrong on server side"
            ];
        } else {
            $response = [
                "code"          => 200,
                "link"          => "$sharable_link",
                "document_id"   => $document_id
            ];
        }

        if (@$_POST['is_edit']) {

            echo  json_encode($response);
        } else {

            $this->sendContractEmail($user, $sharable_link);
        }
    }


    public function sendContractDoc()
    {
        $token_data     =   $this->getAirSlateToken(); // Get Token

        if (@$token_data['access_token'] == '') {

            echo  json_encode(["code" => 201, "data" => "No Token found From Air Slate side"]);
            die;
        }


        $is_edit = "no";
        $user = @$_POST['user'] ? $_POST['user'] : '';
        $document_id  = @$_POST['document_id'];

        $sharable_link = $this->createSharebleLink($document_id, $token_data, $is_edit, $user);

        $response = [];
        if ($sharable_link == "") {

            $response = [
                "code"  => 201,
                "data"  => "Something happedn wrong on server side"
            ];
        } else {
            $response = [
                "code"          => 200,
                "link"          => "$sharable_link",
                "document_id"   => $document_id
            ];
        }

        if (@$_POST['is_edit']) {

            echo  json_encode($response);
        } else {

            $this->sendContractEmail($user, $sharable_link);
        }
    }

    public function approveContract($id)
    {

        echo "<pre>";

        $token_data     =   $this->getAirSlateToken(); // Get Token
        $meeting_model = Meeting::find($id);

        $template_id = $meeting_model->template_id;
        $flow_id     = $meeting_model->flow_id;
        $organization_id = "82391828-2300-0000-0000D981";

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.airslate.io/v1/organizations/$organization_id/templates/$template_id/flows/$flow_id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Authorization: Bearer " . $token_data['access_token']
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {

            $result = json_decode($response);
            print_r($result);

            if ($result->signing_status == "COMPLETED") {


                $meeting_model->is_contract_accepted = 1;
                $meeting_model->update();
                echo "updated";
            }


            print_r($meeting_model);
        }
    }

    public function cronGetContract()
    {

        $token_data     =   $this->getAirSlateToken(); // Get Token
        $incomplete_contract = Meeting::where(['is_contract_accepted' => 0])->get()->toArray();
        echo "<pre>";
        // print_r($incomplete_contract);

        foreach ($incomplete_contract as $key => $value) {

            $template_id = $value['template_id'];
            $flow_id     = $value['flow_id'];
            $organization_id = "82391828-2300-0000-0000D981";

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.airslate.io/v1/organizations/$organization_id/templates/$template_id/flows/$flow_id",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "Accept: application/json",
                    "Authorization: Bearer " . $token_data['access_token']
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {

                $result = json_decode($response);
                print_r($result);
                $meeting_model = Meeting::find($value['id']);
                if (@$result->signing_status == "COMPLETED") {


                    $meeting_model->is_contract_accepted = 1;
                    $meeting_model->update();
                }


                print_r($meeting_model);
            }
        }
    }

    public function getTemplateSharableLink($token_data, $template_id)
    {

        $organization_id = '82391828-2300-0000-0000D981';

        $access_token = $token_data['access_token'];

        $url = "https://api.airslate.io/v1/organizations/$organization_id/templates/$template_id/flows";

        $data = [
            'documents' => [],
            'invites' => [],
            'share_links' => [
                [
                    'auth_method' => 'none',
                    'signer_identity' => 'vsingh@codenomad.net',
                    'expire' => 43100,
                    'step_name' => 'Role 1'
                ]
            ],
            'webhooks' => [
                [
                    'event_name' => 'flow.completed',
                    'callback' => [
                        'url' => 'https://thesectoreight.com/testing'
                    ]
                ]
            ]
        ];

        $headers = [
            "Authorization: Bearer $access_token",
            "Content-Type: application/json"
        ];

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } else {

            return json_decode($response);
        }

        curl_close($ch);
    }


    public function shareContract(Request $request)
    {
        $template_id = $request->template_id;
        $template_name = $request->template_name;
        $user = $request->user;
        $token_data     =   $this->getAirSlateToken(); // Get Token

        $work_flow_data = $this->getTemplateSharableLink($token_data, $template_id); // Get Template Sharble Link

        $link = $work_flow_data->share_links[0]->url;
        $flow_id = $work_flow_data->id;

        $this->sendContractEmail($user, $link, $template_name, $template_id, $flow_id);
    }

    public function sendEventContract()
    {
        $meeting_model = Meeting::find($_POST['event_id_number']);
        $template_id = $_POST['template_id'];
        if (!$meeting_model) {

            echo json_encode(["code" =>  200, "data" => "No event found"]);
            die;
        }

        $token_data     =   $this->getAirSlateToken(); // Get Token
        $settings = Utility::settings();

        $organization_id = @$settings['organization_id'];
        $fillable_fields = ['name', 'email', 'eventname', 'lead_address', 'relationship', 'phone', 'alter_name', 'alter_phone', 'alter_email', 'alter_relationship', 'alter_lead_address', 'company_name', 'start_date', 'end_date', 'start_time', 'end_time', 'description', 'guest_count', 'function', 'floor_plan', 'func_package', 'bar_package', 'venue_selection', 'spcl_request', 'room', 'meal', 'bar', 'type', 'ad_opts', 'total', 'allergies', 'start_time', 'food_description', 'bar_description', 'setup_description'];

        $template_documents = $this->getTemplateDocuments($token_data, $template_id, $organization_id);
        $documents__variable_data = $this->getTemplateDocumentsVariables($token_data, $template_id, $organization_id, $template_documents);


        $fillable_values = [];
        foreach ($documents__variable_data as $key => $value) {

            $document_field_data = [
                "id"    => $value->id
            ];

            foreach ($value->fields as $field_key => $field_data) {

                if (in_array($field_data->name, $fillable_fields)) {
                    $field_name = $field_data->name;

                    $document_field_data['fields'][] =  [
                        'name'  =>  $field_data->name,
                        'value' =>  @$meeting_model->$field_name
                    ];
                }
            }

            $fillable_values[] = $document_field_data;
        }
        $work_flow_data = $this->runWorkFlow($token_data, $template_id, $organization_id, $fillable_values,  $meeting_model->email);
        $flow_id = $work_flow_data['id'];
        $link = $work_flow_data['share_links'][0]['url'];

        // print_r($work_flow_data);
        $user = $_POST['event_id_number'] . "~" . $meeting_model->email;
        $template_name = "";

        // print_r([$user , $link, $template_name , $template_id , $flow_id]);

        $this->sendContractEmail($user, $link, $template_name, $template_id, $flow_id);
    }

    public function getTemplateDocuments($token_data, $template_id, $organization_id)
    {

        $token_value = $token_data['access_token'];
        $url = "https://api.airslate.io/v1/organizations/$organization_id/templates/$template_id/documents";

        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token_value,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            echo 'Error: ' . curl_error($curl);
        } else {
            // echo 'Response: ' . $response;
            // return json_decode($response);
        }

        curl_close($curl);
        return json_decode($response);
    }

    public function getTemplateDocumentsVariables($token_data, $template_id, $organization_id, $template_documents)
    {
        $document_variable_data = [];
        $token_value = $token_data['access_token'];
        foreach ($template_documents->data as $key => $value) {
            $document_id = $value->id;
            $url = "https://api.airslate.io/v1/organizations/$organization_id/templates/$template_id/documents/$document_id";

            $headers = [
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token_value,
            ];

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
            ]);

            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                echo 'Error: ' . curl_error($curl);
            } else {
                // echo 'Response: ' . $response;
                $document_variable_data[] = json_decode($response);
            }

            curl_close($curl);
        }

        return $document_variable_data;
    }

    public function runWorkFlow($token_data, $template_id, $organization_id, $fillable_data, $signer_email)
    {

        $token_value = $token_data['access_token'];
        $url = "https://api.airslate.io/v1/organizations/$organization_id/templates/$template_id/flows";
        $data = [
            "documents" => $fillable_data,
            "invites" => [],
            "share_links" => [
                [
                    "auth_method" => "none",
                    "signer_identity" => $signer_email,
                    "expire" => 43100,
                    "step_name" => "Role 1"
                ]
            ],
            "webhooks" => [
                [
                    "event_name" => "flow.completed",
                    "callback" => [
                        "url" => "https://thesectoreight.com/testing"
                    ]
                ]
            ]
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token_value,
            'Content-Type: application/json'
        ]);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } else {
            $response_data = json_decode($response, true);
        }

        curl_close($ch);

        return $response_data;
    }

    public function testContract()
    {
        $settings = Utility::settings();
        config([
            'mail.driver'       => $settings['mail_driver'],
            'mail.host'         => $settings['mail_host'],
            'mail.port'         => $settings['mail_port'],
            'mail.username'     => $settings['mail_username'],
            'mail.password'     => $settings['mail_password'],
            'mail.from.address' => $settings['mail_from_address'],
            'mail.from.name'    => $settings['mail_from_name'],
        ]);
        // Define the HTML content
        $htmlContent =  "
                            <!DOCTYPE html>
                            <html lang='en'>
                            <head>
                                <meta charset='UTF-8'>
                                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                                <title>Contract Response</title>
                            </head>
                            <body>
                               self hit
                                <p>Please check your <a href='#'>contract.</a></p>
                                <br>
                                <p>Best regards,</p>
                                <p><b>Catamount Consulting</b></p>
                                <div>
                                    <img src='{{ url('storage/uploads/logo/3_logo-light.png')}}'  height='50'>
                                </div>
                                <span style='font-size:x-small'>Supported by The Sector Eight</span>
                            </body>
                            </html>
                        ";

        $response =  [];
        $email = "vsingh@codenomad.net";
        $adminEmails = ["vsingh@codenomad.net"];
        // Send the email
        try {
            Mail::html($htmlContent, function ($message) use ($email, $adminEmails) {
                $message->to($email)
                    ->cc($adminEmails)
                    ->subject('Contract');
            });
            // echo "Email sent successfully!";

            $response =  [
                "code"          => 200,
                "data"          => "Email sent successfully",
                "email"         => $email
            ];
        } catch (\Exception $e) {
            echo "Error sending email: " . $e->getMessage();
            $response =  [
                "code"          => 201,
                "data"          => "Email not sent successfully. something happened wrong on server side",
                "email"         => $email
            ];
        }
        echo json_encode($response);
    }

    public function sendContractEmail($user, $link, $template_name, $template_id, $flow_id)
    {

        list($event_id, $email) = explode('~', $user);
        $settings = Utility::settings();
        config([
            'mail.driver'       => $settings['mail_driver'],
            'mail.host'         => $settings['mail_host'],
            'mail.port'         => $settings['mail_port'],
            'mail.username'     => $settings['mail_username'],
            'mail.password'     => $settings['mail_password'],
            'mail.from.address' => $settings['mail_from_address'],
            'mail.from.name'    => $settings['mail_from_name'],
        ]);


        // Define the recipient and admin emails
        $users = User::where('type', 'owner')->orwhere('type', 'Admin')->get();
        $adminEmails = $users->pluck('email')->toArray();

        // Define the HTML content
        $htmlContent =  "
                            <!DOCTYPE html>
                            <html lang='en'>
                            <head>
                                <meta charset='UTF-8'>
                                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                                <title>Contract Response</title>
                            </head>
                            <body>
                                <h1>Contract</h1>
                                <p>Dear User,</p>
                                <p>Please check your <a href='" . $link . "'>contract.</p>
                                <br>
                                <p>Best regards,</p>
                                <p><b>The Bond 1786</b></p>
                                <div>
                                    <img src='https://thesectoreight.com/storage/uploads/logo/logo-light.png'  height='50'>
                                </div>
                                <span style='font-size:x-small'>Supported by The Sector Eight</span>
                            </body>
                            </html>
                        ";

        $response =  [];
        // Send the email
        $email = 'harjot@codenomad.net';
        try {
            Mail::html($htmlContent, function ($message) use ($email, $adminEmails) {
                $message->to($email)
                    ->cc($adminEmails)
                    ->subject('Contract');
            });

            $response =  [
                "code"  => 200,
                "data"  => "Email sent successfully",
                "email" => $email,
                "link"  => $link
            ];

            $meeting_model = Meeting::find($event_id);
            $meeting_model->is_contract_accepted = 0;
            $meeting_model->template_name = $template_name;
            $meeting_model->template_id = $template_id;
            $meeting_model->flow_id = $flow_id;
            $meeting_model->update();
        } catch (\Exception $e) {
            echo "Error sending email: " . $e->getMessage();
            $response =  [
                "code"          => 201,
                "data"          => "Email not sent successfully. something happened wrong on server side",
                "email"         => $email
            ];
        }
        echo json_encode($response);
    }

    public function getContract($id, $document_id)
    {
        $event_id = Crypt::decrypt(urldecode($id));
        $meeting_model = Meeting::find($event_id);
        if (!$meeting_model) {
            echo "Unauthorized user";
            die;
        }
        $already_accepted = true;
        if ($meeting_model->is_contract_accepted == 0) {
            $already_accepted = false;
            $meeting_model->is_contract_accepted = 1;
            $meeting_model->contract_documment_id = $document_id;
            $meeting_model->update();
        }
        return view('auth.contract-welcome', compact('already_accepted'));
    }

    public function downloadContract($id)
    {
        $meeting_model = Meeting::where(['flow_id' => $id])->get()->first();
        if (!$meeting_model) {
            return redirect()->back()->with('error', __('No data found.'));
        }
        $organization_id = "82391828-2300-0000-0000D981";
        $flow_id = $id;
        $template_id = $meeting_model->template_id;
        $token_data     =   $this->getAirSlateToken();

        return view('contracts.download-contract', compact('organization_id', 'template_id', 'token_data', 'flow_id'));
    }
}
