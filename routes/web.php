<?php

use App\Http\Controllers\AamarpayController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\AccountIndustryController;
use App\Http\Controllers\AiTemplateController;
use App\Http\Controllers\AuthorizeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CalenderNewController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerInformation;
use App\Http\Controllers\WebNotificationController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeadSourceController;
use App\Http\Controllers\OpportunitiesStageController;
use App\Http\Controllers\CommonCaseController;
use App\Http\Controllers\OpportunitiesController;
use App\Http\Controllers\NotificationSendController;
use App\Http\Controllers\CaseTypeController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\CallController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStageController;
use App\Http\Controllers\DocumentFolderController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\CampaignTypeController;
use App\Http\Controllers\TargetListController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentWallController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductBrandController;
use App\Http\Controllers\ProductTaxController;
use App\Http\Controllers\ShippingProviderController;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\FormBuilderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\clientPayWithPaypal;
use App\Http\Controllers\PaystackPaymentController;
use App\Http\Controllers\FlutterwavePaymentController;
use App\Http\Controllers\RazorpayPaymentController;
use App\Http\Controllers\PaytmPaymentController;
use App\Http\Controllers\MercadoPaymentController;
use App\Http\Controllers\MolliePaymentController;
use App\Http\Controllers\SkrillPaymentController;
use App\Http\Controllers\CoingatePaymentController;
use App\Http\Controllers\LandingPageSectionsController;
use App\Http\Controllers\PlanRequestController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\EmailTemplateLangController;
use App\Http\Controllers\ContractTypeController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\CustomController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BankTransferController;
use App\Http\Controllers\BenefitPaymentController;
use App\Http\Controllers\CashfreeController;
use App\Http\Controllers\IyziPayController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\ToyyibpayController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\PayfastController;
use App\Http\Controllers\UserlogController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\NotificationTemplatesController;
use App\Http\Controllers\PayHereController;
use App\Http\Controllers\PaytabController;
use App\Http\Controllers\PaytrController;
use App\Http\Controllers\SspayController;
use App\Http\Controllers\XenditPaymentController;
use App\Http\Controllers\YooKassaController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\DashboardTestingController;
use App\Models\Billing;
use Google\Service\ServiceConsumerManagement\BillingConfig;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {


//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware(['XSS']);

});

Route::any('/cookie-consent', [SettingController::class, 'CookieConsent'])->name('cookie-consent');

Route::any('/all-data', [DashboardController::class, 'get_data'])->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('payment-view/{id}',[BillingController::class,'payviamode'])->name('payviamode');
Route::get('/stripe/billing/payment/{meeting}',[BillingController::class,'stripe_payment_view'])->name('billing.payview');
Route::get('/paypal/billing/payment/{meeting}',[BillingController::class,'paypal_payment_view'])->name('billing.payview');

// UPCOMING EVENTS AND COMPLETED EVENTS ROUTES //   <

Route::get('/meeting-upcoming',[DashboardController::class,'upcomingevents']);    
Route::get('/meeting-completed',[DashboardController::class,'completedevents']);

// UPCOMING EVENTS AND COMPLETED EVENTS ROUTES //   >

Route::get('lead/proposal-signed/{id}',[LeadController::class,'proposalview'])->name('lead.signedproposal');
Route::get('billing/get-payment-link/{id}',[BillingController::class,'getpaymentlink'])->name('billing.getpaymentlink');
Route::post('billing/share-payment-link/{id}',[BillingController::class,'sharepaymentlink'])->name('billing.sharepaymentlink');

Route::post('lead/proposal-signed/{id}',[LeadController::class,'proposal_resp'])->name('lead.proposalresponse');
Route::get('event/signed-agreement/{id}',[MeetingController::class,'signedagreementview'])->name('meeting.signedagreement');
Route::post('event/signed-agreement/{id}',[MeetingController::class,'signedagreementresponse'])->name('meeting.signedagreementresp');
Route::resource('plan', PlanController::class)->middleware(['XSS']);
Route::get('quote/pdf/{id}', [QuoteController::class, 'pdf'])->name('quote.pdf')->middleware(['XSS']);
Route::get('salesorder/pdf/{id}', [SalesOrderController::class, 'pdf'])->name('salesorder.pdf')->middleware(['XSS']);
Route::resource('form_builder', FormBuilderController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('/form/{code}', [FormBuilderController::class, 'formView'])->name('form.view')->middleware(['XSS']);
Route::post('/form_view_store', [FormBuilderController::class, 'formViewStore'])->name('form.view.store')->middleware(['XSS']);
Route::post('/form_field_store/{id}', [FormBuilderController::class, 'bindStore'])->name('form.bind.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
// language
Route::post('disable-language', [LanguageController::class, 'disableLang'])->name('disablelanguage')->middleware(['auth', 'XSS']);
//chatgpt
Route::post('chatgptkey', [SettingController::class, 'chatgptkey'])->name('settings.chatgptkey');
Route::get('generate/{template_name}', [AiTemplateController::class, 'create'])->name('generate');
Route::post('generate/keywords/{id}', [AiTemplateController::class, 'getKeywords'])->name('generate.keywords');
Route::post('generate/response', [AiTemplateController::class, 'AiGenerate'])->name('generate.response');

//gramer
Route::get('grammar/{template}', [AiTemplateController::class, 'grammar'])->name('grammar');
Route::post('grammar/response', [AiTemplateController::class, 'grammarProcess'])->name('grammar.response');


Route::get('invoice/pdf/{id}', [InvoiceController::class, 'pdf'])->name('invoice.pdf')->middleware(['XSS']);
Route::get('/invoice/pay/{invoice}', [InvoiceController::class, 'payinvoice'])->name('pay.invoice');
//================================= Invoice Payment Gateways  ====================================//
Route::any('/pay-with-bank', [BankTransferController::class, 'invoicePayWithbank'])->name('invoice.pay.with.bank');
Route::get('bankpayment/show/{id}', [BankTransferController::class, 'bankpaymentshow'])->name('bankpayment.show');


Route::post('/invoices/{id}/payment', [InvoiceController::class, 'addPayment'])->name('client.invoice.payment');
Route::post('/{id}/pay-with-paypal', [PaypalController::class, 'clientPayWithPaypal'])->name('client.pay.with.paypal');
Route::get('/{id}/{amount}/get-payment-status', [PaypalController::class, 'clientGetPaymentStatus'])->name('client.get.payment.status');

Route::get('/stripe-payment-status', [StripePaymentController::class, 'planGetStripePaymentStatus'])->name('stripe.payment.status');

Route::post('/invoice-pay-with-paystack', [PaystackPaymentController::class, 'invoicePayWithPaystack'])->name('invoice.pay.with.paystack');
Route::get('/invoice/paystack/{pay_id}/{invoice_id}', [PaystackPaymentController::class, 'getInvociePaymentStatus'])->name('invoice.paystack');

Route::post('/invoice-pay-with-flaterwave', [FlutterwavePaymentController::class, 'invoicePayWithFlutterwave'])->name('invoice.pay.with.flaterwave');
Route::get('/invoice/flaterwave/{txref}/{invoice_id}', [FlutterwavePaymentController::class, 'getInvociePaymentStatus'])->name('invoice.flaterwave');

Route::post('/invoice-pay-with-razorpay', [RazorpayPaymentController::class, 'invoicePayWithRazorpay'])->name('invoice.pay.with.razorpay');
Route::get('/invoice/razorpay/{txref}/{invoice_id}', [RazorpayPaymentController::class, 'getInvociePaymentStatus'])->name('invoice.razorpay');

Route::post('/invoice-pay-with-paytm', [PaytmPaymentController::class, 'invoicePayWithPaytm'])->name('invoice.pay.with.paytm');
Route::post('/invoice/paytm/{invoice}', [PaytmPaymentController::class, 'getInvociePaymentStatus'])->name('invoice.paytm');

Route::post('/invoice-pay-with-mercado', [MercadoPaymentController::class, 'invoicePayWithMercado'])->name('invoice.pay.with.mercado');
Route::get('/invoice/mercado/{invoice}', [MercadoPaymentController::class, 'getInvociePaymentStatus'])->name('invoice.mercado');

Route::post('/invoice-pay-with-mollie', [MolliePaymentController::class, 'invoicePayWithMollie'])->name('invoice.pay.with.mollie');
Route::get('/invoice/mollie/{invoice}', [MolliePaymentController::class, 'getInvociePaymentStatus'])->name('invoice.mollie');

Route::post('/invoice-pay-with-skrill', [SkrillPaymentController::class, 'invoicePayWithSkrill'])->name('invoice.pay.with.skrill');
Route::get('/invoice/skrill/{invoice}', [SkrillPaymentController::class, 'getInvociePaymentStatus'])->name('invoice.skrill');

Route::post('/invoice-pay-with-coingate', [CoingatePaymentController::class, 'invoicePayWithCoingate'])->name('invoice.pay.with.coingate');
Route::get('/invoice/coingate/{invoice}', [CoingatePaymentController::class, 'getInvociePaymentStatus'])->name('invoice.coingate');

Route::post('/invoice-pay-with-stripe', [StripePaymentController::class, 'invoicePayWithStripe'])->name('invoice.pay.with.stripe');
Route::get('/invoice/stripe/{invoice_id}', [StripePaymentController::class, 'getInvociePaymentStatus'])->name('invoice.stripe');

Route::post('/invoice-with-toyyibpay', [ToyyibpayController::class, 'invoicepaywithtoyyibpay'])->name('invoice.with.toyyibpay');
Route::get('/invoice-toyyibpay-status/{amount}/{invoice_id}', [ToyyibpayController::class, 'invoicetoyyibpaystatus'])->name('invoice.toyyibpay.status');

Route::post('/invoice-with-payfast', [PayfastController::class, 'invoicepaywithpayfast'])->name('invoice.with.payfast');
Route::get('/invoice-payfast-status/{invoice_id}', [PayfastController::class, 'invoicepayfaststatus'])->name('invoice.payfast.status');

Route::post('/invoice-with-iyzipay', [IyziPayController::class, 'invoicepaywithiyzipay'])->name('invoice.with.iyzipay');
Route::post('/invoice-iyzipay-status/{amount}/{invoice_id}', [IyziPayController::class, 'invoiceiyzipaystatus'])->name('invoice.iyzipay.status');

Route::get('/invoice/error/{flag}/{invoice_id}', [PaymentWallController::class, 'invoiceerror'])->name('error.invoice.show');
Route::post('/invoicepayment', [PaymentWallController::class, 'invoicepay'])->name('paymentwall.invoice');
Route::post('/invoice-pay-with-paymentwall/{invoice}', [PaymentWallController::class, 'invoicePayWithPaymentWall'])->name('invoice-pay-with-paymentwall');

Route::post('/customer-pay-with-sspay', [SspayController::class, 'invoicepaywithsspaypay'])->name('customer.pay.with.sspay');
Route::get('/customer/sspay/{invoice}/{amount}', [SspayController::class, 'getInvoicePaymentStatus'])->name('customer.sspay');

Route::post('invoice-with-paytab/', [PaytabController::class, 'invoicePayWithpaytab'])->name('pay.with.paytab');
Route::any('invoice-paytab-status/{invoice}/{amount}', [PaytabController::class, 'PaytabGetPaymentCallback'])->name('invoice.paytab.status');

Route::post('invoice-with-benefit/', [BenefitPaymentController::class, 'invoicePayWithbenefit'])->name('pay.with.benefit');
Route::any('invoice-benefit-status/{invoice_id}/{amount}', [BenefitPaymentController::class, 'getInvociePaymentStatus'])->name('invoice.benefit.status');

Route::post('invoice-with-cashfree/', [CashfreeController::class, 'invoicePayWithcashfree'])->name('invoice.with.cashfree');
Route::any('invoice-cashfree-status/', [CashfreeController::class, 'getInvociePaymentStatus'])->name('invoice.cashfree.status');

Route::post('invoice-with-aamarpay/', [AamarpayController::class, 'invoicePayWithaamarpay'])->name('pay.with.aamarpay');
Route::any('invoice-aamarpay-status/{data}', [AamarpayController::class, 'getInvociePaymentStatus'])->name('invoice.aamarpay.status');

Route::post('invoice-with-paytr/', [PaytrController::class, 'invoicePayWithpaytr'])->name('invoice.with.paytr');
Route::any('invoice-paytr-status/', [PaytrController::class, 'getInvociePaymentStatus'])->name('invoice.paytr.status');

Route::post('invoice-with-yookassa/', [YooKassaController::class, 'invoicePayWithYookassa'])->name('invoice.with.yookassa');
Route::any('invoice-yookassa-status/', [YooKassaController::class, 'getInvociePaymentStatus'])->name('invoice.yookassa.status');

Route::any('invoice-with-midtrans/', [MidtransController::class, 'invoicePayWithMidtrans'])->name('invoice.with.midtrans');
Route::any('invoice-midtrans-status/', [MidtransController::class, 'getInvociePaymentStatus'])->name('invoice.midtrans.status');

Route::any('/invoice-with-xendit', [XenditPaymentController::class, 'invoicePayWithXendit'])->name('invoice.with.xendit');
Route::any('/invoice-xendit-status', [XenditPaymentController::class, 'getInvociePaymentStatus'])->name('invoice.xendit.status');

// Route::post('invoice-payhere-payment', [PayHereController::class, 'invoicePayWithPayHere'])->name('invoice.with.payhere');
// Route::get('/invoice-payhere-status', [PayHereController::class, 'invoiceGetPayHereStatus'])->name('invoice.payhere.status');
//  *************************** end invoice payment ****************************


Route::get('/invoice/export', [InvoiceController::class, 'fileExport'])->name('invoice.export');

Route::get('/salesorder/pay/{salesorder}', [SalesOrderController::class, 'paysalesorder'])->name('pay.salesorder');
Route::get('/quote/pay/{quote}', [QuoteController::class, 'payquote'])->name('pay.quote');

Route::get('quote/export', [QuoteController::class, 'fileExport'])->name('quote.export');
Route::get('invoice/pay/pdf/{id}', [InvoiceController::class, 'pdffrominvoice'])->name('invoice.download.pdf');

Route::group(['middleware' => ['verified']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'XSS']);


    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function(){
            Route::get('change-language/{lang}', [LanguageController::class, 'changeLanquage'])->name('change.language')->middleware(['auth', 'XSS']);
            Route::get('manage-language/{lang}', [LanguageController::class, 'manageLanguage'])->name('manage.language')->middleware(['auth', 'XSS']);
            Route::post('store-language-data/{lang}', [LanguageController::class, 'storeLanguageData'])->name('store.language.data')->middleware(['auth', 'XSS']);
            Route::get('create-language', [LanguageController::class, 'createLanguage'])->name('create.language')->middleware(['auth', 'XSS']);
            Route::post('store-language', [LanguageController::class, 'storeLanguage'])->name('store.language')->middleware(['auth', 'XSS']);
            Route::delete('/lang/{lang}', [LanguageController::class, 'destroyLang'])->name('lang.destroy')->middleware(['auth', 'XSS']);
        }
    );
    
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::get('user/grid', [UserController::class, 'grid'])->name('user.grid');

            Route::resource('user', UserController::class);
        }
    );

    Route::resource('userlog', UserlogController::class);
    Route::delete('/userlog/{id}/', [UserlogController::class, 'destroy'])->name('userlog.destroy')->middleware(['auth', 'XSS']);
    Route::get('userlog-view/{id}/', [UserlogController::class, 'view'])->name('userlog.view')->middleware(['auth', 'XSS']);

    Route::resource('webhook', WebhookController::class);



    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::resource('permission', PermissionController::class);
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::resource('role', RoleController::class);
        }
    );

    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::get('account/grid', [AccountController::class, 'grid'])->name('account.grid');
            Route::resource('account', AccountController::class);

            Route::get('account/create/{type}/{id}', [AccountController::class, 'create'])->name('account.create');
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::resource('account_type', AccountTypeController::class);
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::resource('account_industry', AccountIndustryController::class);
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::get('contact/grid', [ContactController::class, 'grid'])->name('contact.grid');
            Route::resource('contact', ContactController::class);
            Route::get('contact/create/{type}/{id}', [ContactController::class, 'create'])->name('contact.create');
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::get('lead/grid', [LeadController::class, 'grid'])->name('lead.grid');
            Route::resource('lead', LeadController::class);
            Route::post('lead/change-order', [LeadController::class, 'changeorder'])->name('lead.change.order');
            Route::get('lead/create/{type}/{id}', [LeadController::class, 'create'])->name('lead.create');
            Route::get('lead/{id}/show_convert', [LeadController::class, 'showConvertToAccount'])->name('lead.convert.account');
            Route::post('lead/{id}/convert', [LeadController::class, 'convertToAccount'])->name('lead.convert.to.account');
            Route::get('lead/proposal/{id}', [LeadController::class, 'proposal'])->name('lead.proposal');
            Route::get('lead/view-proposal/{id}', [LeadController::class, 'view_proposal'])->name('lead.viewproposal');
            Route::get('lead/share_proposal/{id}', [LeadController::class, 'share_proposal_view'])->name('lead.shareproposal');
            Route::post('lead/share_proposal/{id}', [LeadController::class, 'proposalpdf'])->name('lead.pdf');
            Route::get('lead/review-proposal/{id}', [LeadController::class, 'review_proposal'])->name('lead.review');
            Route::post('lead/review-proposal/update/{id}', [LeadController::class, 'review_proposal_data'])->name('lead.review.update');
            Route::get('lead/approve_proposal/{id}',[LeadController::class,'approval'])->name('lead.approval');
            Route::get('lead/withdraw_proposal/{id}',[LeadController::class,'withdraw'])->name('lead.withdraw');
            Route::get('lead/resend_proposal/{id}',[LeadController::class,'resend'])->name('lead.resend');
            Route::get('lead/clone/{id}',[LeadController::class,'duplicate'])->name('lead.clone');
            Route::get('lead/information/{id}',[LeadController::class,'lead_info'])->name('lead.info');
            Route::get('lead/upload_attachment/{id}',[LeadController::class,'lead_upload'])->name('lead.uploads');
            Route::post('lead/upload_doc/{id}',[LeadController::class,'lead_upload_doc'])->name('lead.uploaddoc');
            Route::get('lead/billinfo/{id}',[LeadController::class,'lead_billinfo'])->name('lead.billinfo');
            Route::get('lead/uploaded_docs/{id}',[LeadController::class,'uploaded_docs'])->name('lead.uploaded_docs');
            Route::post('lead/change_status/',[LeadController::class,'status'])->name('lead.changeleadstat');
            Route::post('lead-notes/{id}',[LeadController::class,'leadnotes'])->name('addleadnotes');
            Route::get('lead/user-information/{id}',[LeadController::class,'lead_user_info'])->name('lead.userinfo');

        });

    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
          Route::resource('billing',BillingController::class);

          Route::get('billing/create/{type}/{id}',[BillingController::class,'create'])->name('billing.create');
          Route::post('billing/add-data/{id}',[BillingController::class,'store'])->name('billing.addbilling');
          Route::post('billing/event',[BillingController::class,'get_event_info'])->name('billing.eventdetail');
          Route::post('billing/payment',[BillingController::class,'billpaymenturl'])->name('billing.paymenturl');
          Route::get('billing/estimate-view/{id}',[BillingController::class,'estimationview'])->name('billing.estimateview');
          Route::get('billing/payment-info/{id}',[BillingController::class,'paymentinformation'])->name('billing.paymentinfo');
          Route::post('billing/payment-info/{id}',[BillingController::class,'paymentupdate'])->name('billing.paymentinfoupdate');
          Route::get('billing/payment-link/{id}',[BillingController::class,'paymentlink'])->name('billing.paylink');
          Route::get('billing/invoicpdf/{id}',[BillingController::class,'invoicepdf'])->name('billing.invoicepdf');
          Route::post('billing/addpaymentinfooncopy/{id}',[BillingController::class,'addpayinfooncopyurl'])->name('billing.addpayinfooncopyurl');


        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::resource('lead_source', LeadSourceController::class);
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::resource('opportunities_stage', OpportunitiesStageController::class);
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::get('commoncase/grid', [CommonCaseController::class, 'grid'])->name('commoncases.grid');
            Route::resource('commoncases', CommonCaseController::class);
            Route::get('commoncases/create/{type}/{id}', [CommonCaseController::class, 'create'])->name('commoncases.create');
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::get('opportunities/grid', [OpportunitiesController::class, 'grid'])->name('opportunities.grid');
            Route::resource('opportunities', OpportunitiesController::class);
            Route::post('opportunities/change-order', [OpportunitiesController::class, 'changeorder'])->name('opportunities.change.order');
            Route::get('opportunities/create/{type}/{id}', [OpportunitiesController::class, 'create'])->name('opportunities.create');
        }
    );

    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::resource('case_type', CaseTypeController::class);
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::get('event/grid', [MeetingController::class, 'grid'])->name('meeting.grid');
            Route::post('meeting/getparent', [MeetingController::class, 'getparent'])->name('meeting.getparent');
            Route::resource('meeting', MeetingController::class);
            Route::post('event/get_meeting_data', [MeetingController::class, 'get_meeting_data'])->name('meeting.get_meeting_data')->middleware(['auth', 'XSS']);
            Route::get('event/create/{type}/{id}', [MeetingController::class, 'create'])->name('meeting.create');
            Route::post('event/get_lead_data/',[MeetingController::class, 'get_lead_data'])->name('meeting.lead');
            Route::post('event/get_calender_date/',[MeetingController::class, 'get_calender_date'])->name('meeting.calender');
            Route::post('event/block-date/',[MeetingController::class,'block_date'])->name('meeting.blockdate');
            Route::post('event/unblock-date/',[MeetingController::class,'unblock_date'])->name('meeting.unblock');
            Route::get('event/shareevent/{meeting}', [MeetingController::class, 'share_event'])->name('meeting.share');
            Route::post('event/share_event_info/{id}', [MeetingController::class, 'get_event_info'])->name('meeting.event_info');
            Route::get('/meeting-download/{meeting}', [MeetingController::class, 'download_meeting']);
            Route::get('event/review-proposal/{id}', [MeetingController::class, 'review_agreement'])->name('meeting.review');
            Route::post('event/review-agreement/update/{id}', [MeetingController::class, 'review_agreement_data'])->name('meeting.review_agreement.update');
            Route::get('event/detailed-view/{id}', [MeetingController::class, 'detailed_info'])->name('meeting.detailview');
            Route::get('event/user-information/{id}',[MeetingController::class,'event_user_info'])->name('event.userinfo');
            Route::post('event/upload_doc/{id}',[MeetingController::class,'event_upload_doc'])->name('event.uploaddoc');
            Route::post('event-notes/{id}',[MeetingController::class,'eventnotes'])->name('addeventnotes');
            Route::get('/get-encoded-id/{id}', function ($id) {
                $encryptedId = Crypt::encrypt($id);
                $encodedId = urlencode($encryptedId);
                return response()->json(['encodedId' => $encodedId]);
            })->name('get.encoded.id');

        }
    );
  
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::get('call/grid', [CallController::class, 'grid'])->name('call.grid');
            Route::post('call/getparent', [CallController::class, 'getparent'])->name('call.getparent');
            Route::resource('call', CallController::class);
            Route::post('call/get_call_data', [CallController::class, 'get_call_data'])->name('call.get_call_data')->middleware(['auth', 'XSS']);
            Route::get('call/create/{type}/{id}', [CallController::class, 'create'])->name('call.create');
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::get('task/export', [TaskController::class, 'fileExport'])->name('task.export');
            Route::get('task/grid', [TaskController::class, 'grid'])->name('task.grid');
            Route::post('task/getparent', [TaskController::class, 'getparent'])->name('task.getparent');
            Route::get('task/gantt-chart/{duration?}', [TaskController::class, 'ganttChart'])->name('task.gantt.chart');
            Route::post('task/gantt-chart', [TaskController::class, 'ganttChart'])->name('task.gantt.chart.post')->middleware(
                [
                    'auth',
                    'XSS',
                ]
            );
            Route::resource('task', TaskController::class);
            Route::get('task/create/{type}/{id}', [TaskController::class, 'create'])->name('task.create');
            Route::post('task/get_task_data', [TaskController::class, 'get_task_data'])->name('task.get_task_data')->middleware(['auth', 'XSS']);
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::resource('task_stage', TaskStageController::class);
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::resource('document_folder', DocumentFolderController::class);
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::resource('document_type', DocumentTypeController::class);
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::resource('campaign_type', CampaignTypeController::class);
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::resource('target_list', TargetListController::class);
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::get('document/grid', [DocumentController::class, 'grid'])->name('document.grid');
            Route::resource('document', DocumentController::class);
            Route::get('document/create/{type}/{id}', [DocumentController::class, 'create'])->name('document.create');
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::get('campaign/grid', [CampaignController::class, 'grid'])->name('campaign.grid');
            Route::resource('campaign', CampaignController::class);
            Route::get('campaign/create/{type}/{id}', [CampaignController::class, 'create'])->name('campaign.create');
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {

            Route::get('quote/grid', [QuoteController::class, 'grid'])->name('quote.grid');
            Route::get('quote/{id}/convert', [QuoteController::class, 'convert'])->name('quote.convert');
            Route::get('quote/preview/{template}/{color}', [QuoteController::class, 'previewQuote'])->name('quote.preview');
            Route::post('quote/template/setting', [QuoteController::class, 'saveQuoteTemplateSettings'])->name('quote.template.setting');
            Route::post('quote/getaccount', [QuoteController::class, 'getaccount'])->name('quote.getaccount');
            Route::get('quote/quoteitem/{id}', [QuoteController::class, 'quoteitem'])->name('quote.quoteitem');
            Route::post('quote/storeitem/{id}', [QuoteController::class, 'storeitem'])->name('quote.storeitem');
            Route::get('quote/quoteitem/edit/{id}', [QuoteController::class, 'quoteitemEdit'])->name('quote.quoteitem.edit');
            Route::post('quote/storeitem/edit/{id}', [QuoteController::class, 'quoteitemUpdate'])->name('quote.quoteitem.update');
            Route::get('quote/items', [QuoteController::class, 'items'])->name('quote.items');
            Route::delete('quote/items/{id}/delete', [QuoteController::class, 'itemsDestroy'])->name('quote.items.delete');
            Route::resource('quote', QuoteController::class);
            Route::get('quote/create/{type}/{id}', [QuoteController::class, 'create'])->name('quote.create');
            Route::get('quote/{id}/duplicate', [QuoteController::class, 'duplicate'])->name('quote.duplicate');
        }
    );


    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::get('product/import/export', [ProductController::class, 'fileImportExport'])->name('product.file.import');
            Route::post('product/import', [ProductController::class, 'fileImport'])->name('product.import');
            Route::get('product/export', [ProductController::class, 'fileExport'])->name('product.export');
            Route::get('product/grid', [ProductController::class, 'grid'])->name('product.grid');
            Route::resource('product', ProductController::class);
        }
    );
    Route::get('/plan/error/{flag}', [PaymentWallController::class, 'planerror'])->name('error.plan.show');

    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
        }
    );
    Route::get('user/{id}/plan', [UserController::class, 'upgradePlan'])->name('plan.upgrade')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

    Route::get('user/{id}/plan/{pid}', [UserController::class, 'activePlan'])->name('plan.active')->middleware(
        [
            'auth',
            'XSS',
        ]
    );


    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::resource('product_category', ProductCategoryController::class);
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::resource('product_brand', ProductBrandController::class);
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::resource('product_tax', ProductTaxController::class);
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::resource('shipping_provider', ShippingProviderController::class);
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::post('streamstore/{type}/{id}/{title}', [StreamController::class, 'streamstore'])->name('streamstore');
            Route::resource('stream', StreamController::class);
        }
    );

    Route::any('calendar/{type?}', [CalenderController::class, 'index'])->name('calendar.index')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

    Route::any('/all-data', [CalenderController::class, 'get_data'])->middleware(
        [
            'auth',
            'XSS',
        ]
    );

    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::get('salesorder/grid', [SalesOrderController::class, 'grid'])->name('salesorder.grid');
            Route::get('salesorder/preview/{template}/{color}', [SalesOrderController::class, 'previewInvoice'])->name('salesorder.preview');
            Route::post('salesorder/template/setting', [SalesOrderController::class, 'saveSalesorderTemplateSettings'])->name('salesorder.template.setting');
            Route::post('salesorder/getaccount', [SalesOrderController::class, 'getaccount'])->name('salesorder.getaccount');
            Route::get('salesorder/salesorderitem/{id}', [SalesOrderController::class, 'salesorderitem'])->name('salesorder.salesorderitem');
            Route::post('salesorder/storeitem/{id}', [SalesOrderController::class, 'storeitem'])->name('salesorder.storeitem');
            Route::get('salesorder/items', [SalesOrderController::class, 'items'])->name('salesorder.items');
            Route::get('salesorder/item/edit/{id}', [SalesOrderController::class, 'salesorderItemEdit'])->name('salesorder.item.edit');
            Route::post('salesorder/item/edit/{id}', [SalesOrderController::class, 'salesorderItemUpdate'])->name('salesorder.item.update');
            Route::delete('salesorder/items/{id}/delete', [SalesOrderController::class, 'itemsDestroy'])->name('salesorder.items.delete');

            Route::resource('salesorder', SalesOrderController::class);

            Route::get('salesorder/create/{type}/{id}', [SalesOrderController::class, 'create'])->name('salesorder.create');
            Route::get('salesorder/{id}/duplicate', [SalesOrderController::class, 'duplicate'])->name('salesorder.duplicate');
        }
    );


    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::get('invoice/grid', [InvoiceController::class, 'grid'])->name('invoice.grid');
            Route::get('invoice/preview/{template}/{color}', [InvoiceController::class, 'previewInvoice'])->name('invoice.preview');
            Route::post('invoice/template/setting', [InvoiceController::class, 'saveInvoiceTemplateSettings'])->name('invoice.template.setting');



            Route::post('invoice/getaccount', [InvoiceController::class, 'getaccount'])->name('invoice.getaccount');
            Route::get('invoice/invoiceitem/{id}', [InvoiceController::class, 'invoiceitem'])->name('invoice.invoiceitem');
            Route::post('invoice/storeitem/{id}', [InvoiceController::class, 'storeitem'])->name('invoice.storeitem');
            Route::get('invoice/items', [InvoiceController::class, 'items'])->name('invoice.items');
            Route::get('invoice/item/edit/{id}', [InvoiceController::class, 'invoiceItemEdit'])->name('invoice.item.edit');
            Route::post('invoice/item/edit/{id}', [InvoiceController::class, 'invoiceItemUpdate'])->name('invoice.item.update');
            Route::delete('invoice/items/{id}/delete', [InvoiceController::class, 'itemsDestroy'])->name('invoice.items.delete');


            Route::resource('invoice', InvoiceController::class);
            Route::get('invoice/create/{type}/{id}', [InvoiceController::class, 'create'])->name('invoice.create');
            Route::get('invoice/{id}/duplicate', [InvoiceController::class, 'duplicate'])->name('invoice.duplicate');

            // **************** //
            Route::post('invoice/send/{id}', [InvoiceController::class, 'sendmail'])->name('invoice.sendmail');
            // Route::get('invoices-payments', 'InvoiceController@payments')->name('invoices.payments');

            Route::get('invoices-payments', [InvoiceController::class, 'payments'])->name('invoices.payments');
            Route::get('invoices/{id}/payments', [InvoiceController::class, 'paymentAdd'])->name('invoices.payments.create');
            Route::post('invoices/{id}/payments', [InvoiceController::class, 'paymentStore'])->name('invoices.payments.store');
        }
    );
    Route::post('cookie-setting', [SettingController::class, 'saveCookieSettings'])->name('cookie.setting');

    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            // Route::post('report/customreport', [ReportController::class, 'customreport'])->name('report.index');
            Route::get('report/export', [ReportController::class, 'fileexport'])->name('report.export');
            Route::get('report/leadsanalytic', [ReportController::class, 'leadsanalytic'])->name('report.leadsanalytic');
            Route::get('report/invoiceanalytic', [ReportController::class, 'invoiceanalytic'])->name('report.invoiceanalytic');
            Route::get('report/salesorderanalytic', [ReportController::class, 'salesorderanalytic'])->name('report.salesorderanalytic');
            Route::get('report/quoteanalytic', [ReportController::class, 'quoteanalytic'])->name('report.quoteanalytic');
            Route::get('report/eventanalytic', [ReportController::class, 'eventanalytic'])->name('report.eventanalytic');
            Route::get('report/customeranalytic', [ReportController::class, 'customersanalytic'])->name('report.customersanalytic');
            Route::get('report/billinganalytic', [ReportController::class, 'billinganalytic'])->name('report.billinganalytic');
            Route::post('report/usersrate', [ReportController::class, 'usersrate'])->name('report.usersrate');
            Route::post('report/getparent', [ReportController::class, 'getparent'])->name('report.getparent');
            Route::post('report/supportanalytic', [ReportController::class, 'supportanalytic'])->name('report.supportanalytic');
            Route::resource('report', ReportController::class);
        }
    );

    Route::get('invoice/link/{id}', [InvoiceController::class, 'invoicelink'])->name('invoice.link');




    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::post('business-setting', [SettingController::class, 'saveBusinessSettings'])->name('business.setting');
            Route::post('company-setting', [SettingController::class, 'saveCompanySettings'])->name('company.setting');
            Route::post('email-setting', [SettingController::class, 'saveEmailSettings'])->name('email.setting');
            Route::post('system-setting', [SettingController::class, 'saveSystemSettings'])->name('system.setting');
            Route::post('pusher-setting', [SettingController::class, 'savePusherSettings'])->name('pusher.setting');
            Route::post('test', [SettingController::class, 'testMail'])->name('test.mail');
            Route::get('test', [SettingController::class, 'testMail'])->name('test.mail');
            Route::post('test-mail', [SettingController::class, 'testSendMail'])->name('test.send.mail');
            Route::post('setting/google-calender', [SettingController::class, 'saveGoogleCalenderSettings'])->name('google.calender.settings');
            Route::post('setting/seo', [SettingController::class, 'saveSEOSettings'])->name('seo.settings');

            Route::get('/config-cache', function () {
                Artisan::call('cache:clear');
                Artisan::call('route:clear');
                Artisan::call('view:clear');
                Artisan::call('optimize:clear');
                https: //nimb.ws/akfTjR
                return redirect()->back()->with('success', 'Clear Cache successfully.');
            });

            Route::get('settings', [SettingController::class, 'index'])->name('settings');
            Route::post('payment-setting', [SettingController::class, 'savePaymentSettings'])->name('payment.setting');
            Route::post('owner-payment-setting', [SettingController::class, 'saveOwnerPaymentSettings'])->name('owner.payment.setting');
        }
    );
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::get('order', [StripePaymentController::class, 'index'])->name('order.index');
            Route::post('/stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');

            //Route::get('/stripe/{code}', 'StripePaymentController@stripe')->name('stripe');
        }
    );
    Route::get('notification_templates/{id?}/{lang?}/', [NotificationTemplatesController::class, 'index'])->name('notification_templates.index')->middleware('auth', 'XSS');

    Route::resource('notification-templates', NotificationTemplatesController::class)->middleware(
        [
            'auth',
            'XSS',
        ]
    );


    Route::get('profile', [UserController::class, 'profile'])->name('profile')->middleware(
        [
            'auth',
            'XSS',
        ]
    );
    Route::post('change-password', [UserController::class, 'updatePassword'])->name('update.password');
    Route::any('edit-profile', [UserController::class, 'editprofile'])->name('update.account')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

    Route::get('/apply-coupon', [CouponController::class, 'applyCoupon'])->name('apply.coupon')->middleware(
        [
            'auth',
            'XSS',
        ]
    );
    
    Route::group(
            [
                'middleware' => [
                    'auth',
                    'XSS',
                ],
            ],
            function(){

            Route::get('emails', [EmailController::class, 'index'])->name('email.index');
            Route::get('emails/details/{id}', [EmailController::class, 'details'])->name('email.details');
            Route::get('email/details/conversations/{id}', [EmailController::class, 'conversations'])->name('email.conversations');

        }
    );
    Route::get('create-contract',[ContractsController::class,'docs']);
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function(){
            Route::get('customer', [CustomerInformation::class, 'index'])->name('customer.index');
            Route::post('customer', [CustomerInformation::class, 'sendmail'])->name('customer.sendmail');
            Route::post('campaign-type',[CustomerInformation::class,'campaigntype'])->name('auto.campaign_type');
            Route::get('user-list',[CustomerInformation::class,'existinguserlist'])->name('campaign.existinguser'); 
            Route::get('added-user-list',[CustomerInformation::class,'addeduserlist'])->name('campaign.addeduser'); 
            Route::get('customer-list',[CustomerInformation::class,'addusers'])->name('userlist'); 
            Route::get('upload-user-list',[CustomerInformation::class,'uploaduserlist'])->name('uploadusersinfo');       
            Route::post('upload-user',[CustomerInformation::class,'importuser'])->name('importuser');       
            Route::get('html-mail',[CustomerInformation::class,'mailformatting'])->name('htmlmail');  
            Route::get('text-mail',[CustomerInformation::class,'textmailformatting'])->name('textmail');  
            Route::post('campaign-category',[CustomerInformation::class,'campaign_categories'])->name('campaign_categories');  
            Route::get('campaign-list',[CustomerInformation::class,'campaignlisting'])->name('campaign-list');  
            Route::post('contactinfo',[CustomerInformation::class,'contactinfo'])->name('getcontactinfo');  
            Route::post('resend-campaign',[CustomerInformation::class,'resendcampaign'])->name('resend-campaign');
            Route::get('export-user', [CustomerInformation::class, 'exportuser'])->name('exportuser');
            Route::get('all-customers', [CustomerInformation::class, 'siteusers'])->name('siteusers');
            Route::get('event-customers', [CustomerInformation::class, 'event_customers'])->name('event_customers');
            Route::get('lead-customers', [CustomerInformation::class, 'lead_customers'])->name('lead_customers');
            Route::get('import-customers/{id}', [CustomerInformation::class, 'import_customers_view'])->name('importcustomerview');
            Route::get('customer/information/{id}',[CustomerInformation::class,'customer_info'])->name('customer.info');
            Route::post('upload-external-customer-info/{id}',[CustomerInformation::class,'uploadcustomerattachment'])->name('upload-info');
            Route::post('user-notes/{id}',[CustomerInformation::class,'usernotes'])->name('addusernotes');
            Route::get('category/{category}', [CustomerInformation::class,'cate'])->name('categ');

            
        }
    );
    Route::get('/pay/{id}',[AuthorizeController::class,'pay'])->name('pay');
    Route::post('/dopay/online/{id}',[AuthorizeController::class,'handleonlinepay'])->name('dopay.online');
    Route::group(
        [
            'middleware' => [
                'auth',
                'XSS',
            ],
        ],
        function () {
            Route::resource('coupon', CouponController::class);
        }
    );
    Route::get('/apply-coupon', [CouponController::class, 'applyCoupon'])->name('apply.coupon')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

    Route::get('/change/mode', [UserController::class, 'changeMode'])->name('change.mode');
    Route::get('user/documents/{id}',[UserController::class,'view_docs'])->name('user.docs');
    Route::delete('user/documents/delete/{id}/{filename}',[UserController::class,'user_docs_delete'])->name('user.docs.delete');


    Route::post('plan-pay-with-paypal', [PaypalController::class, 'planPayWithPaypal'])->name('plan.pay.with.paypal')->middleware(
        [
            'auth',
            'XSS',
        ]
    );
    Route::post('plan-pay-with-bank', [BankTransferController::class, 'planPayWithbank'])->name('plan.pay.with.bank')->middleware(
        [
            'auth',
            'XSS',
        ]

    );
    Route::any('order_approve/{id}', [BankTransferController::class, 'orderapprove'])->name('order.approve')->middleware(
        [
            'auth',
            'XSS',
        ]
    );
    Route::any('order_reject/{id}', [BankTransferController::class, 'orderreject'])->name('order.reject')->middleware(
        [
            'auth',
            'XSS',
        ]
    );
    Route::get('orders/show/{id}', [BankTransferController::class, 'show'])->name('order.show');
    Route::delete('/bank_transfer/{order}/', [BankTransferController::class, 'destroy'])->name('bank_transfer.destroy')->middleware(['auth', 'XSS']);

    Route::delete('invoice/bankpayment/{id}/delete', [BankTransferController::class, 'invoicebankPaymentDestroy'])->name('invoice.bankpayment.delete');

    Route::delete('invoice/payment/{id}/delete', [InvoiceController::class, 'invoicePaymentDestroy'])->name('invoice.payment.delete');
    Route::post('/invoice/status/{id}', [BankTransferController::class, 'invoicebankstatus'])->name('invoice.status');

    Route::get('{id}/{amount}/plan-get-payment-status', [PaypalController::class, 'planGetPaymentStatus'])->name('plan.get.payment.status')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

    // Form Builder


    // Form link base view


    // Form Field
    Route::get('/form_builder/{id}/field', [FormBuilderController::class, 'fieldCreate'])->name('form.field.create')->middleware(
        [
            'auth',
            'XSS',
        ]
    );
    Route::post('/form_builder/{id}/field', [FormBuilderController::class, 'fieldStore'])->name('form.field.store')->middleware(
        [
            'auth',
            'XSS',
        ]
    );
    Route::get('/form_builder/{id}/field/{fid}/show', [FormBuilderController::class, 'fieldShow'])->name('form.field.show')->middleware(
        [
            'auth',
            'XSS',
        ]
    );
    Route::get('/form_builder/{id}/field/{fid}/edit', [FormBuilderController::class, 'fieldEdit'])->name('form.field.edit')->middleware(
        [
            'auth',
            'XSS',
        ]
    );
    Route::post('/form_builder/{id}/field/{fid}', [FormBuilderController::class, 'fieldUpdate'])->name('form.field.update')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

    Route::delete('/form_builder/{id}/field/{fid}', [FormBuilderController::class, 'fieldDestroy'])->name('form.field.destroy')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

    // Form Response
    Route::get('/form_response/{id}', [FormBuilderController::class, 'viewResponse'])->name('form.response')->middleware(
        [
            'auth',
            'XSS',
        ]
    );
    Route::get('/response/{id}', [FormBuilderController::class, 'responseDetail'])->name('response.detail')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

    // Form Field Bind
    Route::get('/form_field/{id}', [FormBuilderController::class, 'formFieldBind'])->name('form.field.bind')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

    // end Form Builder


    //****
    Route::resource('payments', PaymentController::class)->middleware(['auth', 'XSS',]);
    Route::get('/Plan/Payment/{code}', [PlanController::class, 'getpaymentgatway'])->name('plan.payment')->middleware(['auth', 'XSS',]);



    //================================= Plan Payment Gateways  ====================================//
    Route::post('/plan-pay-with-paystack', [PaystackPaymentController::class, 'planPayWithPaystack'])->name('plan.pay.with.paystack')->middleware(['auth', 'XSS']);
    Route::get('/plan/paystack/{pay_id}/{plan_id}', [PaystackPaymentController::class, 'getPaymentStatus'])->name('plan.paystack');

    Route::post('/plan-pay-with-flaterwave', [FlutterwavePaymentController::class, 'planPayWithFlutterwave'])->name('plan.pay.with.flaterwave')->middleware(['auth', 'XSS']);
    Route::get('/plan/flaterwave/{txref}/{plan_id}', [FlutterwavePaymentController::class, 'getPaymentStatus'])->name('plan.flaterwave');

    Route::post('/plan-pay-with-razorpay', [RazorpayPaymentController::class, 'planPayWithRazorpay'])->name('plan.pay.with.razorpay')->middleware(['auth', 'XSS']);
    Route::get('/plan/razorpay/{txref}/{plan_id}', [RazorpayPaymentController::class, 'getPaymentStatus'])->name('plan.razorpay');

    Route::post('/plan-pay-with-paytm', [PaytmPaymentController::class, 'planPayWithPaytm'])->name('plan.pay.with.paytm')->middleware(['auth', 'XSS']);
    Route::post('/plan/paytm/{plan}', [PaytmPaymentController::class, 'getPaymentStatus'])->name('plan.paytm');


    Route::post('/plan-pay-with-mercado', [MercadoPaymentController::class, 'planPayWithMercado'])->name('plan.pay.with.mercado')->middleware(['auth', 'XSS']);
    Route::get('/plan/mercado/{plan}', [MercadoPaymentController::class, 'getPaymentStatus'])->name('plan.mercado');

    Route::post('/plan-pay-with-mollie', [MolliePaymentController::class, 'planPayWithMollie'])->name('plan.pay.with.mollie')->middleware(['auth', 'XSS']);
    Route::get('/plan/mollie/{plan}', [MolliePaymentController::class, 'getPaymentStatus'])->name('plan.mollie');

    Route::post('/plan-pay-with-skrill', [SkrillPaymentController::class, 'planPayWithSkrill'])->name('plan.pay.with.skrill')->middleware(['auth', 'XSS']);
    Route::get('/plan/skrill/{plan}', [SkrillPaymentController::class, 'getPaymentStatus'])->name('plan.skrill');

    Route::post('/plan-pay-with-coingate', [CoingatePaymentController::class, 'planPayWithCoingate'])->name('plan.pay.with.coingate')->middleware(['auth', 'XSS']);
    Route::get('/plan/coingate/{plan}', [CoingatePaymentController::class, 'getPaymentStatus'])->name('plan.coingate');


    Route::post('/planpayment', [PaymentWallController::class, 'planpay'])->name('paymentwall')->middleware(['auth', 'XSS']);
    Route::post('/paymentwall-payment/{plan}', [PaymentWallController::class, 'planPayWithPaymentWall'])->name('paymentwall.payment')->middleware(['auth', 'XSS']);

    Route::post('/plan-pay-with-toyyibpay', [ToyyibpayController::class, 'planPayWithToyyibpay'])->name('plan.pay.with.toyyibpay');
    Route::get('/plan-pay-with-toyyibpay/{id}/{amount}/{couponCode?}', [ToyyibpayController::class, 'planGetPaymentStatus'])->name('plan.toyyibpay');

    // plan payfast
    Route::post('payfast-plan', [PayfastController::class, 'index'])->name('payfast.payment')->middleware(['auth']);
    Route::get('payfast-plan/{success}', [PayfastController::class, 'success'])->name('payfast.payment.success')->middleware(['auth']);

    //iyzipay
    Route::post('iyzipay/prepare', [IyziPayController::class, 'initiatePayment'])->name('iyzipay.payment.init');
    Route::post('iyzipay/callback/plan/{id}/{amount}/{coupan_code?}', [IyzipayController::class, 'iyzipayCallback'])->name('iyzipay.payment.callback');

    // SSPay
    Route::post('/sspay', [SspayController::class, 'SspayPaymentPrepare'])->name('plan.sspaypayment');
    Route::get('sspay-payment-plan/{plan_id}/{amount}/{couponCode}', [SspayController::class, 'SspayPlanGetPayment'])->middleware(['auth'])->name('plan.sspay.callback');

    // paytab
    Route::post('plan-pay-with-paytab', [PaytabController::class, 'planPayWithpaytab'])->middleware(['auth'])->name('plan.pay.with.paytab');
    Route::any('paytab-success/plan', [PaytabController::class, 'PaytabGetPayment'])->middleware(['auth'])->name('plan.paytab.success');

    // Benefit
    Route::any('/payment/initiate', [BenefitPaymentController::class, 'initiatePayment'])->name('benefit.initiate');
    Route::any('call_back', [BenefitPaymentController::class, 'call_back'])->name('benefit.call_back');

    // cashfree
    Route::post('cashfree/payments/', [CashfreeController::class, 'planPayWithcashfree'])->name('plan.pay.with.cashfree');
    Route::any('cashfree/payments/success', [CashfreeController::class, 'getPaymentStatus'])->name('plan.cashfree');

    // Aamarpay
    Route::post('/aamarpay/payment', [AamarpayController::class, 'planPayWithpay'])->name('plan.pay.with.aamarpay');
    Route::any('/aamarpay/success/{data}', [AamarpayController::class, 'getPaymentStatus'])->name('plan.aamarpay');

    // PayTR
    Route::post('/paytr/payment', [PaytrController::class, 'PlanpayWithPaytr'])->name('plan.pay.with.paytr');
    Route::any('/paytr/success/', [PaytrController::class, 'paytrsuccessCallback'])->name('pay.paytr.success');

    // Yookassa
    Route::post('/plan/yookassa/payment', [YooKassaController::class,'planPayWithYooKassa'])->name('plan.pay.with.yookassa');
    Route::get('/plan/yookassa/{plan}', [YooKassaController::class,'planGetYooKassaStatus'])->name('plan.yookassa.status');

    // midtrans
    Route::any('/midtrans', [MidtransController::class, 'planPayWithMidtrans'])->name('plan.pay.with.midtrans');
    Route::any('/midtrans/callback', [MidtransController::class, 'planGetMidtransStatus'])->name('plan.get.midtrans.status');

    // xendit
    Route::any('/xendit/payment', [XenditPaymentController::class, 'planPayWithXendit'])->name('plan.pay.with.xendit');
    Route::any('/xendit/payment/status', [XenditPaymentController::class, 'planGetXenditStatus'])->name('plan.xendit.status');

    // // payhere
    // Route::post('plan-payhere-payment', [PayHereController::class, 'planPayWithPayHere'])->name('plan.pay.with.payhere');
    // Route::get('/plan-payhere-status', [PayHereController::class, 'planGetPayHereStatus'])->name('plan.payhere.status');

    //================================= Custom Landing Page ====================================//
    Route::get('/landingpage', [LandingPageSectionsController::class, 'index'])->name('custom_landing_page.index')->middleware(['auth', 'XSS']);
    Route::get('/LandingPage/show/{id}', [LandingPageSectionsController::class, 'show']);
    Route::post('/LandingPage/setConetent', [LandingPageSectionsController::class, 'setConetent'])->middleware(['auth', 'XSS']);

    Route::get('/get_landing_page_section/{name}', function ($name) {
        $plans = DB::table('plans')->get();
        return view('custom_landing_page.' . $name, compact('plans'));
    });
    Route::post('/LandingPage/removeSection/{id}', [LandingPageSectionsController::class, 'removeSection'])->middleware(['auth', 'XSS']);
    Route::post('/LandingPage/setOrder', [LandingPageSectionsController::class, 'setOrder'])->middleware(['auth', 'XSS']);
    Route::post('/LandingPage/copySection', [LandingPageSectionsController::class, 'copySection'])->middleware(['auth', 'XSS']);



    //=================================Plan Request Module ====================================//
    Route::get('plan_request', [PlanRequestController::class, 'index'])->name('plan_request.index')->middleware(['auth', 'XSS']);
    Route::get('request_frequency/{id}', [PlanRequestController::class, 'requestView'])->name('request.index')->middleware(['auth', 'XSS']);
    Route::get('request_send/{id}', [PlanRequestController::class, 'userRequest'])->name('send.request')->middleware(['auth', 'XSS']);
    Route::get('request_response/{id}/{response}', [PlanRequestController::class, 'acceptRequest'])->name('response.request')->middleware(['auth', 'XSS']);
    Route::get('request_response/{id}', [PlanRequestController::class, 'cancelRequest'])->name('request.cancel')->middleware(['auth', 'XSS']);
    
    // ===============================================Import Export=======================================
    Route::get('salesOrder/export', [SalesOrderController::class, 'fileExport'])->name('salesorder.export');




    /*==================================Recaptcha====================================================*/
    Route::post('/recaptcha-settings', [SettingController::class, 'recaptchaSettingStore'])->name('recaptcha.settings.store')->middleware(['auth', 'XSS']);


    //=======================================Twilio==========================================//
    Route::post('setting/twilio', [SettingController::class, 'twilio'])->name('twilio.setting');


    //=======================================Event TYPE==========================================//
    Route::post('setting/event-type', [SettingController::class, 'event_type'])->name('event_type.setting');
    Route::post('setting/delete-eventtype',[SettingController::class,'delete_event_type'])->name('eventedit.setting');


    //=======================================Venue==========================================//
    Route::post('setting/venue', [SettingController::class, 'venue_select'])->name('venue.setting');
    Route::post('setting/delete-venue',[SettingController::class,'delete_venue'])->name('venueedit.setting');
    Route::post('setting/delete-additional-items',[SettingController::class,'delete_additional_items'])->name('additionaldelete.setting');
     //=======================================Function==========================================//
     Route::post('setting/function', [SettingController::class, 'addfunction'])->name('function.setting');
     Route::post('setting/bar', [SettingController::class, 'addbars'])->name('bar.setting');

     Route::post('setting/delete-package-function',[SettingController::class,'delete_function_package'])->name('functionedit.setting');
     Route::post('setting/delete-function',[SettingController::class,'delete_function'])->name('functionpackage.setting');
     Route::post('setting/delete-bars',[SettingController::class,'delete_bar'])->name('barpackage.setting');
     Route::post('setting/delete-bar-function',[SettingController::class,'delete_bar_package'])->name('baredit.setting');
     Route::post('setting/additional-items',[SettingController::class,'additional_items'])->name('additional.setting');

    
     
    //=======================================Floor Plans=======================//
    Route::post('/floor-images',[SettingController::class,'storeImage']);
    Route::post('/delete-image', [SettingController::class, 'deleteImage']);
    //=======================================Floor Plans=======================//
    Route::post('/setting/billing',[SettingController::class,'billing_cost'])->name('billing.setting');

    Route::post('setting/buffer', [SettingController::class, 'buffertime'])->name('buffer.setting');
    Route::post('setting/signature',[SettingController::class,'signature'])->name('authorised.signature');

   //=======================================Campaign=======================//
   Route::post('setting/campaign-type',[SettingController::class,'addcampaigntype'])->name('settings.campaign-type');
   Route::post('setting/delete-campaign-type', [SettingController::class, 'deletecampaigntype'])->name('settings.delete.campaign-type');
    //========================================================================================//
    Route::any('user-reset-password/{id}', [UserController::class, 'employeePassword'])->name('user.reset');
    Route::post('user-reset-password/{id}', [UserController::class, 'employeePasswordReset'])->name('user.password.update');



    //==========================================================================================//

    // Email Templates
    Route::get('email_template_lang/{id}/{lang?}', [EmailTemplateController::class, 'manageEmailLang'])->name('manage.email.language')->middleware(['auth', 'XSS']);
    Route::post('email_template_store/{pid}', [EmailTemplateController::class, 'storeEmailLang'])->name('store.email.language')->middleware(['auth']);
    Route::post('email_template_status', [EmailTemplateController::class, 'updateStatus'])->name('status.email.language')->middleware(['auth']);
    Route::get('email_template_view', [EmailTemplateController::class, 'email_templates'])->name('email.template.view')->middleware(['auth']);
    Route::get('email_template_create', [EmailTemplateController::class, 'email_template_create'])->name('email.template.create')->middleware(['auth']);
    Route::post('email_template_store', [EmailTemplateController::class, 'storeEmailtemplate'])->name('store.email.template')->middleware(['auth']);
    Route::get('email_template_edit/{id}', [EmailTemplateController::class, 'editEmailtemplate'])->name('edit.email.template')->middleware(['auth']);
    Route::put('email_template_update/{id}', [EmailTemplateController::class, 'updateEmailtemplate'])->name('update.email.template')->middleware(['auth']);
    Route::delete('email_template_delete/{id}', [EmailTemplateController::class, 'deleteEmailtemplate'])->name('delete.email.template')->middleware(['auth']);

    Route::resource('email_template', EmailTemplateController::class)->middleware(
        [
            'auth',
            // 'XSS',
        ]
    );
    Route::resource('email_template_lang', EmailTemplateLangController::class)->middleware(
        [
            'auth',
            // 'XSS',
        ]
    );



    //==========================================================================================================//

    //contract
    Route::resource('contract_type', ContractTypeController::class)->middleware(
        [
            'auth',
            'XSS',
        ]
    );
    Route::resource('contract', ContractController::class)->middleware(
        [
            'auth',
            'XSS',
        ]
    );
    Route::post('/contract_status_edit/{id}', [ContractController::class, 'contract_status_edit'])->name('contract.status')->middleware(['auth', 'XSS']);
    Route::post('/contract/{id}/file', [ContractController::class, 'fileUpload'])->name('contracts.file.upload')->middleware(['auth', 'XSS']);
    Route::get('/contract/{id}/file/{fid}', [ContractController::class, 'fileDownload'])->name('contracts.file.download')->middleware(['auth', 'XSS']);
    Route::delete('/contract/{id}/file/delete/{fid}', [ContractController::class, 'fileDelete'])->name('contracts.file.delete')->middleware(['auth', 'XSS']);
    Route::post('/contract/{id}/note', [ContractController::class, 'noteStore'])->name('contracts.note.store')->middleware(['auth']);
    Route::get('/contract/{id}/note', [ContractController::class, 'noteDestroy'])->name('contracts.note.destroy')->middleware(['auth']);
    Route::post('contract/{id}/description', [ContractController::class, 'descriptionStore'])->name('contracts.description.store')->middleware(['auth']);
    Route::get('/contract/copy/{id}', [ContractController::class, 'copycontract'])->name('contracts.copy')->middleware(['auth', 'XSS']);
    Route::post('/contract/copy/store', [ContractController::class, 'copycontractstore'])->name('contracts.copy.store')->middleware(['auth', 'XSS']);


    Route::get('contract/{id}/get_contract', [ContractController::class, 'printContract'])->name('get.contract');
    Route::get('contract/pay/pdf/{id}', [ContractController::class, 'pdffromcontract'])->name('contract.download.pdf');
    Route::get('contract/pay/pdf', [ContractController::class, 'signature'])->name('contract.signature');
    Route::get('/signature/{id}', [ContractController::class, 'signature'])->name('signature')->middleware(['auth', 'XSS']);
    Route::post('/signaturestore', [ContractController::class, 'signatureStore'])->name('signaturestore')->middleware(['auth', 'XSS']);

    Route::get('/contract/preview/{template}/{color}', [ContractController::class, 'previewContract'])->name('contract.preview');
    Route::get('/contract/{id}/mail', [ContractController::class, 'sendmailContract'])->name('send.mail.contract');

    // Route::post('/projects/{id}/comment/{tid}/file', ['as' => 'comment.store.file','uses' => 'ContractController@commentStoreFile',]);
    // Route::delete('/projects/{id}/comment/{tid}/file/{fid}', ['as' => 'comment.destroy.file',    'uses' => 'ContractController@commentDestroyFile',]);
    Route::post('/contract/{id}/comment', [ContractController::class, 'commentStore'])->name('comment.store');
    Route::get('/contract/{id}/comment', [ContractController::class, 'commentDestroy'])->name('comment.destroy');
    // Storage setting
    Route::post('storage-settings', [SettingController::class, 'storageSettingStore'])->name('storage.setting.store')->middleware(['auth', 'XSS']);
});
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::get('contracts',[ContractsController::class,'index'])->name('contracts.index');
        Route::get('contracts/create-new-contract',[ContractsController::class,'new_contract'])->name('contracts.new_contract');

        Route::get('contracts/create',[ContractsController::class,'create'])->name('contracts.create');

        Route::post('contracts/store',[ContractsController::class,'store'])->name('contracts.store');
        Route::get('contracts/detail/{id}',[ContractsController::class,'templatedetail'])->name('contracts.detail');
        Route::get('contracts/create-new-template',[ContractsController::class,'newtemplate'])->name('contracts.newtemplate');
    });

  
Route::get('/meeting-download/{meeting}', [MeetingController::class, 'download_meeting']);
Route::get('event/agreement/{id}', [MeetingController::class, 'agreement'])->name('meeting.agreement');
Route::get('/push-notificaiton', [WebNotificationController::class, 'index'])->name('push-notificaiton');

Route::group(['middleware' => 'auth'],function(){
    Route::post('/store-token', [WebNotificationController::class, 'updateDeviceToken'])->name('store.token');
    Route::post('/send-web-notification', [WebNotificationController::class, 'sendNotification'])->name('send.web-notification');
});
// Route::post('/store-token', [WebNotificationController::class, 'storeToken'])->name('store.token');
// Route::post('/send-web-notification', [WebNotificationController::class, 'sendWebNotification'])->name('send.web-notification');
// 22-01

Route::get('/show-blocked-date-popup/{id}',[CalenderController::class,'show_blocked_date_popup']);

Route::get('/unblock-date/{id}',[CalenderController::class,'unblock_this_date']);
Route::post('/buffer-time', [MeetingController::class, 'buffer_time']);
Route::get('/debug-buffer-time', [MeetingController::class, 'buffer_time']);
// 24-01
Route::get('/payment-success',[BillingController::class,'welcome']);

Route::get('/payment-failed',function(){
    return view('calendar.paymentfailed');
});

Route::get('/mail-testing',[MeetingController::class,'mail_testing']);
Route::get('/testview', function(){
 return view('test');
});

Route::get('/paypal-payment-success',[BillingController::class,'paypalpaymentsuccess']);
// Dashboard Testing route
Route::get('/dashboard-testing',[DashboardTestingController::class,'index']);
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::post('/calender-meeting-data', [CalenderNewController::class, 'get_event_data']);
        Route::get('/calender-new', [CalenderNewController::class, 'index'])->name('calendernew.index');
        Route::post('/edit-addittional-items',[SettingController::class,'editadditionalcost'])->name('additionalitems.edit');
        Route::post('/function-packages', [MeetingController::class, 'getpackages'])->name('function.packages');
        Route::get('/event-info',[CalenderNewController::class,'eventinfo'])->name('eventinformation');
        Route::get('/blocked-data-info',[CalenderNewController::class,'blockeddateinfo'])->name('blockedDatesInformation');
        Route::post('calender-data',[CalenderNewController::class,'monthbaseddata'])->name('monthbaseddata');
        Route::post('week-calender-data',[CalenderNewController::class,'weekbaseddata'])->name('weekbaseddata');
        Route::post('day-calender-data',[CalenderNewController::class,'daybaseddata'])->name('daybaseddata');

        
});