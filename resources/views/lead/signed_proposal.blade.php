<?php
$billing = App\Models\ProposalInfo::where('lead_id', $lead->id)->orderby('id', 'desc')->first();
if (isset($billing) && !empty($billing)) {
    $billing = json_decode($billing->proposal_info, true);
}
$settings = App\Models\Utility::settings();
// @$proposalSettings = json_decode($proposal_info['proposal_data']);
@$proposal_settings = json_decode($settings['proposal']);

$selectedvenue = explode(',', $lead->venue_selection);
$imagePath = public_path('upload/signature/autorised_signature.png');
$imageData = base64_encode(file_get_contents($imagePath));
$base64Image = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . $imageData;
if (isset($proposal) && ($proposal['image'] != null)) {
    $signed = base64_encode(file_get_contents($proposal['image']));
    $sign = 'data:image/' . pathinfo($proposal['image'], PATHINFO_EXTENSION) . ';base64,' . $signed;
}

$proposalDataArg = json_decode($proposal_info->proposal_data);

$token = array(
    'USER_EMAIL'  => $usersDetail->email,
);
$pattern = '[%s]';
foreach ($token as $key => $val) {
    $varMap[sprintf($pattern, $key)] = $val;
}
@$proposal_settings->address = strtr($proposal_settings->address, $varMap);


foreach ($proposalDataArg->settings as $ps_key => $ps_value) {
    $finalProposal[$ps_key] = isset($ps_value) ? $ps_value : $proposal_settings->$ps_key;
}
/*$data['proposal_settings'] = $proposal_settings;
 $data['proposalSettings'] = $proposalDataArg->settings;
$data['finalProposal'] = $finalProposal;
prx($data); */

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal</title>
</head>
<style>
    body {
        font-family: "Open Sans", sans-serif !important;
    }

    .border-new {
        border: 1px solid #000 !important;
        /* padding: 15px 0; */
    }

    /* .border-new1 {
        padding: 10px 0 40px 0;
    }
 */
    .input-new:nth-child(2) {
        justify-content: center;
    }

    .center-new {
        display: block;
        margin: 3px auto;
        text-align: center;
        align-items: center;
    }

    .input-new {
        padding: 0 10px;
        display: flex;
    }

    .input-new1 {
        display: flex;
    }

    .textarea {
        padding: 0 10px;
    }

    .row {
        --bs-gutter-x: -9rem;
    }


    /* WebKit-specific properties for PDF rendering */
    @media print {
        .row {
            -webkit-print-color-adjust: exact;
        }

        h5 {
            -webkit-margin-before: 0;
            -webkit-margin-after: 0;
            color: #333;
        }

        p {
            -webkit-margin-before: 1em;
            -webkit-margin-after: 1em;
        }

        .sidebyside {
            display: flex !important;
            width: 100% !important;
        }

        .col-sm-6 {
            width: 50% !important;
            float: left;
        }
    }

    .sidebyside {
        display: flex !important;
        width: 100% !important;
    }

    .col-sm-6 {
        width: 50% !important;
        float: left;
    }
    .col-sm-4 {
        width: 40% !important;
        float: left;
    }
    .col-sm-8 {
        width: 60% !important;
        float: left;
    }
</style>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 mt-4 border-new">
                <div class="img-section">
                    <img class="logo-img center-new" src="{{ url('storage/uploads/logo/3_logo-light.png')}}" style="width: 300px;margin:0 200px;padding: 10px 15px;">
                </div>
            </div>
            <div class="col-sm-12 border-new">
                <h4 class="center-new">{!!__(@$proposal_settings->title)!!}</h4>
            </div>
            <div class="col-sm-12 border-new">
                <h4 class="center-new">{!!__(@$proposal_settings->address)!!}</h4>
            </div>
            <div class="col-sm-12 border-new">
                <h3 class="input-new">
                    <label for="client">{{__('Client')}}: </label><span>{{__(@$proposalDataArg->client->name)}}</span>
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="sidebyside">
                <div class="col-sm-4 border-new">
                    <h3 class="input-new">
                        <label for="phone">{{__('Phone')}}: </label><span>{{ phoneFormat(@$proposalDataArg->client->phone)}}</span>
                    </h3>
                </div>
                <div class="col-sm-8 border-new">
                    <h3 class="input-new">
                        <label for="email2">{{__('Email')}}: </label><span>{{__(@$lead->email)}}</span>
                    </h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 border-new">
                <h3 class="input-new">
                    <label for="servicesDate">{{__('Date of service')}}: </label><span>{{\Auth::user()->dateFormat($proposalDataArg->client->dateOfService)}}</span>
                </h3>
            </div>
            <div class="col-sm-12 border-new">
                <h3 class="input-new">
                    <label for="services">{{__('Services')}}: </label><span>{{__(@$proposalDataArg->client->services)}}</span>
                </h3>
            </div>
            <div class="col-sm-12 border-new border-new1">
                <h3 class="input-new">
                    <label for="agreement">{{__('Agreement')}}: </label>
                </h3>
                <div class="textarea">
                    <p style="font-family: 'Open Sans', sans-serif;">{!!@$finalProposal['agreement']!!}</p>
                </div>
            </div>
            <div class="col-sm-12 border-new border-new1 mt-5" style="display: flex;">
                <div class="col-sm-6 signature-div">
                    <h3 class="input-new">
                        <label for="signature">{{__('Signature')}}: </label>
                        <img src="{{__($sign)}}" alt="" srcset="" style="width: 150px;height: 100px;">
                        <!-- <span style="font-family: 'Open Sans', sans-serif;text-decoration: underline;position: relative;left: -18%;">{{ @$_REQUEST['to']['name'] ?? ''}}</span> -->
                    </h3>
                </div>
                <div class="col-sm-6 cleant-div">
                    <div class="table">
                        <table style="width: 100%; border-collapse: collapse; margin: 20px 0; font-family: Arial, sans-serif; background-color: #f9f9f9;">
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 8px;">Name</td>
                                <td style="padding: 8px;">{{ @$_REQUEST['to']['name'] ?? ''}}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 8px;">Title</td>
                                <td style="padding: 8px;">{{ @$_REQUEST['to']['designation'] ?? ''}}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px;">Date</td>
                                <td style="padding: 8px;">{{ \Auth::user()->dateFormat(@$_REQUEST['to']['date']) ?? ''}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 border-new border-new1 mt-8">
                <h3 class="input-new">
                    <label for="remarks">{{__('Remarks')}}:</label>
                </h3>
                <div class="textarea">
                    <p style="font-family: 'Open Sans', sans-serif;">{!!@$finalProposal['remarks']!!}</p>
                </div>
            </div>
            <div class="col-sm-12">
                <h3 class="input-new">
                    <label for="date">{{__('Date')}}: </label> <span>{{\Auth::user()->dateFormat(@$lead->start_date)}}</span>
                </h3>
            </div>
            <div class="col-sm-12  mt-5">
                <p class="input-new">
                    {{$lead->company_name}}<br><br>
                    {{$lead->name}}</br>
                    {{$lead->lead_address}}</br><br>
                    Dear {{$lead->name}},</br></br>
                    Catamount Consulting is pleased to provide you with this proposal for {{$lead->type}} for {{$lead->company_name}}.</br>
                    The following proposal provide the scope of service, schedule, cost and business terms.
                </p>
            </div>
            <div class="col-sm-12  mt-5">
                <h3 class="input-new">
                    <label for="scopeServices">{{__('Scope of Services')}}:</label>
                </h3>
                <div class="textarea">
                    <p style="font-family: 'Open Sans', sans-serif;">{!!@$finalProposal['scopeOfService']!!}</p>
                </div>
            </div>
            <div class="col-sm-12 mt-5">
                <h3 class="input-new">
                    <label for="schedule">{{__('Schedule')}}:</label>
                </h3>
                <div class="textarea">
                    <p style="font-family: 'Open Sans', sans-serif;">{!!@$proposal_settings->schedule!!}</p>
                </div>
            </div>
            <div class="col-sm-12 mt-5">
                <h3 class="input-new">
                    <label for="costBusinessTerms">{{__('Cost and Business Terms')}}:</label>
                </h3>
                <div class="textarea">
                    <p style="font-family: 'Open Sans', sans-serif;">{!!@$finalProposal['costBusiness']!!}</p>
                </div>
            </div>
            <div class="col-sm-12 mt-5">
                <h3 class="input-new">
                    <label for="cencellation">{{__('CANCELLATION')}}:</label>
                </h3>
                <div class="textarea">
                    <p style="font-family: 'Open Sans', sans-serif;">{!!@$finalProposal['cancenllation']!!}</p>
                </div>
            </div>
            <!-- <div class="col-sm-12 border-new1">
                <h3 class="input-new">
                    <label for="scopeServices">{{__('Scope of Services')}}: </label>
                </h3>
            </div>
            <div class="col-sm-12">
                <h3 class="input-new">
                    <label for="schedule">{{__('Schedule')}}: </label>
                    <p style="font-family: 'Open Sans', sans-serif;">Catamount Consulting is prepared to proceed upon receiving the Proposal Acceptance Agreement</p>
                </h3>
            </div>
            <div class="col-sm-12">
                <h3 class="input-new">
                    <label for="costBusinessTerms">{{__('Cost and Business Terms')}}: </label>
                    <p style="font-family: 'Open Sans', sans-serif;">The Proposal shall remain valid for the period of 60 days from the date of the proposal origination. </p>
                </h3>
            </div>
            <div class="col-sm-12">
                <h3 class="input-new">
                    <label for="cencellation">{{__('CANCELLATION')}}: </label>
                    <p style="font-family: 'Open Sans', sans-serif;">Should the above testing be cancelled within 2 weeks of the testing date, there will be a cancellation fee of $ . If testing is rescheduled within 1 month, the cancellation fee will be</br>negotiated and mitigated.
                    </p>
                </h3>
            </div>
            <div class="col-sm-12">
                <h3 class="input-new">We look forward to work with you. Please feel free to contact our office with any questions or concerns.</br>Respectfully,</h3>
            </div> -->
            <div class="table">
                <table style="width: 100%; border-collapse: collapse; margin: 20px 0; font-family: Arial, sans-serif; background-color: #f9f9f9;">
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 8px;">Name</td>
                        <td style="padding: 8px;">{{__(@$proposalDataArg->from->name)}}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 8px;">Title</td>
                        <td style="padding: 8px;">{{__(@$proposalDataArg->from->designation)}}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 8px;">Date</td>
                        <td style="padding: 8px;">{{\Auth::user()->dateFormat(@$proposalDataArg->from->date)}}</td>
                    </tr>
                    <!-- <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 8px;" colspan="2" style="text-align: center; background-color: #f2f2f2; font-weight: bold;">For {{ __($lead->company_name) }}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 8px;">Name</td>
                        <td style="padding: 8px;">{{ @$_REQUEST['to']['name'] ?? ''}}</td>
                        <td style="padding: 8px;">{{__(@$proposalDataArg->to->name)}}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 8px;">Title</td>
                        <td style="padding: 8px;">{{@$_REQUEST['to']['designation'] ?? ''}}</td>
                        <td style="padding: 8px;">{{__(@$proposalDataArg->to->designation)}}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Date</td>
                        <td style="padding: 8px;">{{@$_REQUEST['to']['date'] ?? date('Y-m-d')}}</td>
                        <td style="padding: 8px;">{{__(@$proposalDataArg->to->date)}}</td>
                    </tr> -->
                </table>
            </div>
            <!-- <div class="details">
                <h5 class="input-new1">
                    <label for="name">{{__('Name')}}: </label>{{__($proposal->name)}}
                </h3>
                <h5 class="input-new1">
                    <label for="designation">{{__('Designation')}}: </label>{{__($proposal->designation)}}
                </h3>
                <h5 class="input-new1">
                    <label for="date">{{__('Date')}}: </label>{{__($proposal->date)}}
                </h3>
                <h5 class="input-new1">
                    <label for="to">{{__('To')}}</label>
                </h3>
                <h5 class="input-new1">
                    <label for="name">{{__('Name')}}: </label>{{__($proposal->to_name)}}
                </h3>
                <h5 class="input-new1">
                    <label for="designation">{{__('Designation')}}: {{__($proposal->to_designation)}}</label>
                </h3>
                <h5 class="input-new1">
                    <label for="date">{{__('Date')}}: </label>{{__($proposal->to_date)}}
                </h3>
            </div> -->
        </div>
    </div>
</body>

</html>