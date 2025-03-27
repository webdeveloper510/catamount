<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Billing;
use App\Models\Meeting;
use App\Models\Lead;
use App\Models\Payment;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Checkout\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PaymentInfo;
use App\Models\PaymentLogs;
use App\Models\Utility;
use App\Mail\PaymentLink;
use Mail;
use Spatie\Permission\Models\Role;
use stdClass;

class BillingController extends Controller
{
    public $paypalClient;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = Billing::$status;
        @$user_roles = \Auth::user()->user_roles;
        @$useRole = Role::find($user_roles)->roleType;
        $useType = \Auth::user()->type;
        $useType = $useRole == 'company' ? 'owner' : $useType;
        if ($useType == 'owner') {
            $billing = Billing::all();
            $events = Meeting::where('status', '!=', 5)->orderby('id', 'desc')->get();
            return view('billing.index', compact('billing', 'events'));
        } else {
            $billing = Billing::where('created_by', \Auth::user()->creatorId())->get();
            $events = Meeting::where('status', '!=', 4)->where('created_by', \Auth::user()->id)->orderby('id', 'desc')->get();
            return view('billing.index', compact('billing', 'events'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($type, $id)
    {
        if (\Auth::user()->can('Create Payment')) {
            $event = Meeting::find($id);
            $company_name = Meeting::all()->pluck('company_name')->unique();
            $primaryData = [
                "name" => $event->name,
                "other_contact" => $event->phone,
                "email" => $event->email,
                "lead_address" => $event->lead_address,
                "relationship" => $event->relationship,
            ];
            $quick_contact['primary'] = $primaryData;
            $quick_contact['secondary'] = json_decode($event->secondary_contact, true);
            $quick_contact['secondary']['other_contact'] = $quick_contact['secondary']['secondary_contact'];
            $quick_contact['other'] = [];
            $payable = \App\Models\Billing::pluck('other_contact', 'id');
            $payableArray = [];
            foreach ($payable as $key => $value) {
                $quick_contact["payable_{$key}"] = json_decode($value, true);
            }
            return view('billing.create', compact('type', 'id', 'event', 'quick_contact', 'payable', 'company_name'));
        }
    }
    public function store(Request $request, $id)
    {
        $secondary_contact = preg_replace('/\D/', '', $_REQUEST['other']['other_contact']);
        $_REQUEST['other']['other_contact'] = $secondary_contact;
        $scondData = json_encode($_REQUEST['other']);
        $id = $id ?? null;
        $other_contact = $scondData ?? null;
        $organization_name = $request->organization_name ?? null;
        if (isset($request->quick_contact) && strpos($request->quick_contact, 'primary') !== 0 && strpos($request->quick_contact, 'secondary') !== 0) {
            $type = 'other';
        } else {
            $type = 'lead';
        }
        $items = $request->billing;
        /* $totalCost = 0;
         foreach ($items as $item) {
            $totalCost += $item['cost'] * $item['quantity'];
        } 
        $totalCost = $totalCost + 7 * ($totalCost) / 100 + 20 * ($totalCost) / 100;
        */
        $billing = new Billing();
        $billing['event_id'] = $id;
        $billing['invoice_type'] = $type;
        $billing['organization_name'] = $organization_name;
        $billing['other_contact'] = $other_contact;
        $billing['data'] = serialize($items);
        $billing['status'] = 1;
        $billing['salesTax'] = $request->salesTax ?? 0;
        $billing['totalAmount'] = $request->totalAmount ?? 0;
        $billing['paymentCredit'] = $request->paymentCredit ?? 0;
        $billing['purchaseOrder'] = $request->purchaseOrder ?? 0;
        $billing['terms'] = $request->terms ?? 0;
        $billing['deposits'] = $request->deposits ?? 0;
        $billing['invoiceID'] = rand(1000, 9999);
        $billing['created_by'] = 3;
        $billing->save();
        Meeting::where('id', $id)->update(['total' => $request->totalAmount]);
        return redirect()->back()->with('success', __('Estimated Invoice Created Successfully'));
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $billing = Billing::where('event_id', $id)->first();
        $event = Meeting::where('id', $id)->first();
        return view('billing.view', compact('billing', 'event'));
    }

    public function destroy(string $id)
    {
        if (\Auth::user()->can('Delete Payment')) {
            $billing = Billing::where('event_id', $id)->first();
            $billing->delete();
            return redirect()->back()->with('success', 'Bill Deleted!');
        } else {
            return redirect()->back()->with('error', 'permission Denied');
        }
    }
    public function get_event_info(Request $request)
    {
        $event_info = Meeting::where('id', $request->id)->get();
        return $event_info;
    }
    public function payviamode($id)
    {
        $new_id = decrypt(urldecode($id));
        return view('billing.paymentview', compact('new_id'));
    }
    public function paymentinformation($id)
    {
        $id = decrypt(urldecode($id));
        $event = Meeting::find($id);
        $payment = PaymentInfo::where('event_id', $id)->orderBy('id', 'DESC')->first();
        return view('billing.pay-info', compact('event', 'payment'));
    }

    public function paymentupdate(Request $request, $id)
    {
        $id = decrypt(urldecode($id));
        $payment = new PaymentInfo();
        $payment->event_id = $id;
        $payment->bill_amount = $request->amount;
        $payment->deposits = $request->deposits;
        $payment->paymentCredit = $request->paymentCredit;
        $payment->adjustments = $request->adjustments;
        $payment->latefee = $request->latefee;
        $payment->collect_amount = $request->amountcollect;
        $payment->paymentref = $request->reference;
        $payment->modeofpayment = $request->mode;
        $payment->notes = $request->notes;
        $payment->save();
        $balance = $request->amountcollect;
        $event = Meeting::find($id);

        $paid = PaymentInfo::where('event_id', $id)->get();
        if ($request->mode == 'credit') {
            return view('payments.pay', compact('balance', 'event'));
        } else {
            PaymentLogs::create([
                'amount' => $request->amountcollect,
                'transaction_id' => $request->paymentref,
                'name_of_card' => $event->name,
                'event_id' => $id
            ]);
        }
        return redirect()->back()->with('success', 'Payment Information Updated Sucessfully');
    }

    public function estimationview($id)
    {
        $id =  decrypt(urldecode($id));
        $billing = Billing::where('event_id', $id)->first();
        $event = Meeting::find($id);
        $data = [
            'event' => $event,
            'billing_data' => unserialize($billing->data),
            'billing' => $billing
        ];
        $pdf = Pdf::loadView('billing.estimateview', $data);
        return $pdf->stream('estimate.pdf');
    }
    public function paymentlink($id)
    {
        return view('billing.paylink', compact('id'));
    }
    public function getpaymentlink($id)
    {
        $id = decrypt(urldecode($id));
        $event = Meeting::where('id', $id)->first();
        $collectpayment = PaymentInfo::where('event_id', $id)->orderby('id', 'desc')->first();
        return view('payments.pay', compact('event', 'collectpayment'));
    }
    public function sharepaymentlink(Request $request, $id)
    {
        $settings = Utility::settings();
        $id = decrypt(urldecode($id));
        $balance = $request->balance;
        $payment = new PaymentInfo();
        $payment->event_id = $id;
        $payment->bill_amount = $request->amount;
        $payment->paymentCredit = $request->paymentCredit;
        $payment->collect_amount = $request->amountcollect;
        $payment->adjustments = $request->adjustment ?? 0;
        $payment->latefee = $request->latefee ?? 0;
        $payment->paymentref = '';
        $payment->modeofpayment = 'credit';
        $payment->notes = $request->notes;
        $payment->save();
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
            Mail::to($request->email)->send(new PaymentLink($id, $balance));
        } catch (\Exception $e) {
            //   return response()->json(
            //             [
            //                 'is_success' => false,
            //                 'message' => $e->getMessage(),
            //             ]
            //         );
            return redirect()->back()->with('success', 'Email Not Sent');
        }
        return redirect()->back()->with('success', 'Payment Link shared Sucessfully');
    }

    public function invoicepdf(Request $request, $id)
    {
        $paymentinfo = PaymentInfo::where('event_id', $id)->orderby('id', 'desc')->first();
        $paymentlog = PaymentLogs::where('event_id', $id)->orderby('id', 'desc')->first();
        $data = [
            'paymentinfo' => $paymentinfo,
            'paymentlog' => $paymentlog
        ];
        // return view('billing.mail.inv', $data);
        $pdf = PDF::loadView('billing.mail.inv', $data);
        return $pdf->stream('invoice.pdf');
    }
    public function addpayinfooncopyurl(Request $request, $id)
    {
        $payment = new PaymentInfo();
        $payment->event_id = $id;
        $payment->bill_amount = $request->amount;
        $payment->deposits = $request->deposit;
        $payment->paymentCredit = $request->paymentCredit;
        $payment->adjustments = $request->adjustment ?? 0;
        $payment->latefee = $request->latefee ?? 0;
        // $payment->collect_amount = $request->balance;
        $payment->collect_amount = $request->amountcollect;
        $payment->paymentref = '';
        $payment->modeofpayment = 'credit';
        $payment->notes = $request->notes;
        $payment->save();
        return true;
    }
    public function edit($id)
    {
        if (\Auth::user()->can('Edit Payment')) {
            $id = decrypt(urldecode($id));
            $billing = Billing::where('event_id', $id)->first();
            return view('billing.edit', compact('billing'));
        } else {
            return redirect()->back()->with('error', 'permission Denied');
        }
    }
    public function edit_invoice(Request $request, $id)
    {
        if (\Auth::user()->can('Edit Payment')) {
            $items = $request->billing;
            $billing = Billing::find($id);
            $billing->data = serialize($items);
            $billing->deposits = $request->deposits ?? 0;
            $billing->update();
            $totalCost = 0;
            foreach ($items as $item) {
                $totalCost += ($item['cost'] * $item['quantity']);
            }
            $totalCost = $totalCost + (7 * ($totalCost) / 100) + (20 * ($totalCost) / 100);
            Meeting::where('id', $billing->event_id)->update(['total' => $totalCost]);
            return redirect()->back()->with('success', __(' Invoice Updated Successfully'));
        } else {
            return redirect()->back()->with('error', 'permission Denied');
        }
    }

    public function quick_create_invoice()
    {
        if (\Auth::user()->can('Create Payment')) {

            $event = Meeting::all();
            $company_name = Meeting::all()->pluck('company_name')->unique();
            foreach ($event as $key => $item) {
                $primaryData = [
                    "name" => $item->name,
                    "other_contact" => $item->phone,
                    "email" => $item->email,
                    "lead_address" => $item->lead_address,
                    "relationship" => $item->relationship,
                    "eventname" => $item->eventname,
                ];
                $quick_contact["primary_{$key}"] = $primaryData;
                $quick_contact["secondary_{$key}"] = json_decode($item->secondary_contact, true);
                $quick_contact["secondary_{$key}"]['eventname'] = $item->eventname;
                $quick_contact["secondary_{$key}"]['other_contact'] = $quick_contact["secondary_{$key}"]['secondary_contact'];
            }
            $quick_contact['other'] = [];
            $payable = \App\Models\Billing::pluck('other_contact', 'id');
            $payableArray = [];
            foreach ($payable as $key => $value) {
                $decodedValue = json_decode($value, true);
                if (!empty($decodedValue)) {
                    $quick_contact["payable_{$key}"] = $decodedValue;
                }
            }


            foreach ($quick_contact as $key => $value) {
                // Check if the key is "primary_X" or "secondary_X"
                if (strpos($key, 'primary_') === 0) {
                    // Extract index (0 or 1)
                    $index = substr($key, -1);

                    // Find the corresponding secondary key (e.g., "secondary_X")
                    $secondaryKey = 'secondary_' . $index;

                    // If the secondary key exists, merge it with the primary
                    if (isset($quick_contact[$secondaryKey])) {
                        // Get the lead name for the primary key
                        $leadName = $quick_contact[$key]['eventname'];

                        $selectResult[$leadName] = [ // Use the lead name as the new key
                            0 => $quick_contact[$key], // primary data
                            1 => $quick_contact[$secondaryKey], // secondary data
                        ];
                    }
                }
                // For keys that are not primary or secondary, copy them as is
                /* elseif ($key === 'other') {
                    $selectResult[$key] = $value;
                } */
            }


            return view('billing.quickcreate', compact('quick_contact', 'payable', 'company_name', 'selectResult'));
        }
    }

    public function get_groupby_company(Request $request)
    {
        $companyName = $request->companyName;
        $groupedData = Meeting::select('company_name', 'name', 'email', 'lead_address', 'eventname', 'relationship', 'phone', 'secondary_contact')->where('company_name', $companyName)->get()->groupBy('company_name');

        $quick_contact = [];

        foreach ($groupedData as $key => $item) {
            foreach ($item as $key1 => $item1) {
                $primaryData = [
                    "name" => $item1->name,
                    "other_contact" => $item1->phone,
                    "email" => $item1->email,
                    "lead_address" => $item1->lead_address,
                    "relationship" => $item1->relationship,
                    "eventname" => $item1->eventname,
                ];
                $quick_contact[$item1->company_name]["primary_{$key1}"] = $primaryData;
                $secondaryData = json_decode($item1->secondary_contact, true);
                $secondaryData['eventname'] = $item1->eventname;
                $secondaryData['other_contact'] = $secondaryData['secondary_contact'];

                $quick_contact[$item1->company_name]["secondary_{$key1}"] = $secondaryData;
            }
        }
        $chunked_contact = [];

        foreach ($quick_contact as $companyName => $companyData) {
            $pairs = [];
            foreach ($companyData as $key => $contactData) {
                if (strpos($key, 'primary') === 0) {
                    $secondaryKey = str_replace('primary', 'secondary', $key);
                    if (isset($companyData[$secondaryKey])) {
                        $pair = [
                            'primary' => $companyData[$key],
                            'secondary' => $companyData[$secondaryKey],
                            /* 'eventname' => [
                                'primary_event' => $companyData[$key]['eventname'],
                                'secondary_event' => $companyData[$secondaryKey]['eventname']
                            ] */
                        ];
                        $pairs[] = $pair;
                    }
                }
            }
            $chunked_contact[$companyName] = $pairs;
        }

        return $chunked_contact;
    }
}
