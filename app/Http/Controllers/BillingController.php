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
            return view('billing.create', compact('type', 'id', 'event'));
        }
    }
    public function store(Request $request, $id)
    {
        $items = $request->billing;
        /* $totalCost = 0;
         foreach ($items as $item) {
            $totalCost += $item['cost'] * $item['quantity'];
        } 
        $totalCost = $totalCost + 7 * ($totalCost) / 100 + 20 * ($totalCost) / 100;
        */
        $billing = new Billing();
        $billing['event_id'] = $id;
        $billing['data'] = serialize($items);
        $billing['status'] = 1;
        $billing['salesTax'] = $request->salesTax ?? 0;
        $billing['totalAmount'] = $request->totalAmount ?? 0;
        $billing['paymentCredit'] = $request->paymentCredit ?? 0;
        $billing['purchaseOrder'] = $request->purchaseOrder ?? 0;
        $billing['terms'] = $request->terms ?? 0;
        $billing['deposits'] = $request->deposits ?? 0;
        $billing['invoiceID'] = rand(1000, 9999);
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
}
