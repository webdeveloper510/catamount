<?php
$billing = App\Models\ProposalInfo::where('lead_id', $lead->id)->orderby('id', 'desc')->first();
if (isset($billing) && !empty($billing)) {
    $billing = json_decode($billing->proposal_info, true);
}
$selectedvenue = explode(',', $lead->venue_selection);
$settings = App\Models\Utility::settings();
$imagePath = public_path('upload/signature/autorised_signature.png');
$imageData = base64_encode(file_get_contents($imagePath));
$base64Image = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . $imageData;

$proposal_settings = json_decode($settings['proposal']);
$token = array(
    'USER_EMAIL'  => $users->email,
);
$pattern = '[%s]';
foreach ($token as $key => $val) {
    $varMap[sprintf($pattern, $key)] = $val;
}
@$proposal_settings->address = strtr($proposal_settings->address, $varMap);

// $proposal_info = isset($proposal_info->proposal_data) ? json_decode($proposal_info->proposal_data) : $proposal_settings;
$proposal_info = json_decode($proposal_info->proposal_data);


foreach ($proposal_info->settings as $ps_key => $ps_value) {
    $finalProposal[$ps_key] = isset($ps_value) ? $ps_value : $proposal_settings->$ps_key;
}

/* $data['proposal_settings'] = $proposal_settings;
$data['proposal_info'] = $proposal_info->settings;
$data['finalProposal'] = $finalProposal;
prx($data); */

// pr($lead->secondary_contact);
$secondary_contact = json_decode($lead->secondary_contact);



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
    .border-new {
        border: 1px solid #000 !important;
        padding: 25px 0;
    }

    /*  .border-new1 {
        padding: 40px 0 60px 0;
    } */

    .input-new:nth-child(2) {
        justify-content: center;
    }

    .center-new {
        display: block;
        margin: 3px auto;
        text-align: center;
    }

    .input-new {
        padding: 0 10px;
        display: flex;
        column-gap: 20px;
    }

    .input-new1 {
        display: flex;
        column-gap: 20px;
    }
</style>

<body>
    <div class="container mt-5">
        <div class="row card">
            <div class="col-md-12">
                <form method="POST" action="{{route('lead.proposalresponse',urlencode(encrypt($lead->id)))}}" id='formdata'>
                    @csrf
                    <input type="hidden" name="proposal" value="<?= isset($_GET['prop']) ? $_GET['prop'] : '' ?>">
                    <div class="row">
                        <div class="col-sm-12 mt-4 border-new">
                            <div class="img-section">
                                <img class="logo-img center-new" src="{{ url('storage/uploads/logo/3_logo-light.png')}}" style="width: auto;">
                            </div>
                        </div>
                        <div class="col-sm-12 border-new">
                            <h4 class="center-new">{!!__(@$proposal_settings->title)!!}</h4>
                        </div>
                        <div class="col-sm-12 border-new">
                            <h5 class="center-new">{!!__(@$proposal_settings->address)!!}</h5>
                            <!-- <h5 class="center-new">PLEASE RETURN TO: Catamount Consulting, PO Box 442, Warrensburg NY 12885</br>Or</h5>
                            <h5 class="center-new input-new">
                                <label for="email">{{__('Email')}}: </label>{{__($users->email)}}
                            </h5>
                            <h5 class="center-new">Feel free to call our office at (518) 623-2352 with any questions</h5> -->
                        </div>
                        <div class="col-sm-12 border-new">
                            <h5 class="input-new">
                                <label for="client">{{__('Client')}}:</label>{{__($proposal_info->client->name)}}
                            </h5>
                        </div>
                        <div class="col-sm-6 border-new">
                            <h5 class="input-new">
                                <!-- <label for="phone">{{__('Phone')}}:</label>{{__($proposal_info->client->phone)}} -->
                                <label for="phone">{{__('Phone')}}:</label>{{ phoneFormat($proposal_info->client->phone) }}
                            </h5>
                        </div>
                        <div class="col-sm-6 border-new">
                            <h5 class="input-new">
                                <label for="email2">{{__('Email')}}:</label>{{__($proposal_info->client->email)}}
                            </h5>
                        </div>
                        <div class="col-sm-12 border-new">
                            <h5 class="input-new">
                                <label for="servicesDate">{{__('Date of service')}}:</label>{{dateFormat_blade($proposal_info->client->dateOfService)}}
                            </h5>
                        </div>
                        <div class="col-sm-12 border-new">
                            <h5 class="input-new">
                                <label for="services">{{__('Services')}}:</label>{{__(nl2br($proposal_info->client->services))}}
                            </h5>
                        </div>
                        <div class="col-sm-12 border-new border-new1">
                            <h5 class="input-new">
                                <label for="agreement">{{__('Agreement')}}:</label>
                            </h5>
                            {!!nl2br(@$finalProposal['agreement'])!!}
                            <!-- <textarea name="agreement" id="agreement" class="agreement"></textarea> -->
                        </div>
                        <div class="col-sm-12 border-new" style="display: flex;">
                            <div id="sig">
                                <h5 class="input-new">
                                    <label for="signature">{{__('Signature')}}:</label>
                                    <canvas id="signatureCanvas" width="300" class="signature-canvas"></canvas>
                                    <input type="hidden" name="imageData" id="imageData">
                                </h5>
                                <button type="button" id="clearButton" class="btn btn-danger btn-sm mt-1">Clear Signature</button>
                            </div>

                            <div class="table">
                                <table style="width: 100%; border-collapse: collapse; margin: 20px 0; font-family: Arial, sans-serif; background-color: #f9f9f9;">
                                    <tr style="border-bottom: 1px solid #ddd;">
                                        <td style="padding: 8px;">Name</td>
                                        <!-- <td style="padding: 8px;"><input type="text" name="to[name]" id="name" value="{{isset($proposal_info->to->name) ? $proposal_info->to->name : '' }}"></td> -->
                                        <td style="padding: 8px;"><input type="text" name="to[name]" id="name" value="{{ @$proposal_info->to->name}}" required></td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #ddd;">
                                        <td style="padding: 8px;">Title</td>
                                        <!-- <td style="padding: 8px;"><input type="text" name="to[designation]" id="designation" value="{{isset($proposal_info->to->name) ? $proposal_info->to->designation : '' }}"></td> -->
                                        <td style="padding: 8px;"><input type="text" name="to[designation]" id="designation" value="{{ @$proposal_info->to->designation}}" required></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px;">Date</td>
                                        <td style="padding: 8px;"><input type="text" name="to[date]" class="dateChangeFormat" id="date" value="{{ @$proposal_info->to->date ?? date('Y-m-d')}}" required></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 border-new border-new1">
                            <h5 class="input-new">
                                <label for="remarks">{{__('Remarks')}}:</label>
                            </h5>
                            {!!nl2br(@$finalProposal['remarks'])!!}
                            <!-- <textarea name="remarks" id="remarks" class="remarks"></textarea> -->
                        </div>
                        <div class="col-sm-12 mt-5">
                            <h5 class="input-new">
                                <label for="date">{{__('Date')}}: {{dateFormat_blade($lead->start_date)}}</label>
                            </h5>
                        </div>
                        <div class="col-sm-12  mt-5">
                            <p class="input-new">
                                {{$lead->company_name}}<br><br>
                                {{$lead->name}}</br>
                                {{$lead->lead_address}}</br><br>
                                Dear {{$lead->name}},</br></br>
                                Catamount Consulting is pleased to provide you with this proposal for {{$lead->type}} for {{$lead->company_name}}.</br>
                                The following proposal provides the scope of service, schedule, cost and business terms.
                            </p>
                            <!-- <h5 class="input-new">
                                Sark-Wise Corporation<br>
                                Akif Uskuplu</br>
                                120 Industrial Park</br>
                                Albany, NY 12206</br></br>
                                Dear Akif,</br></br>
                                Catamount Consulting is pleased to provide you with this proposal for safety services for Sark-Wire Corporation.</br>
                                The following proposal provide the scope of service, schedule, cost and business terms.
                            </h5> -->
                        </div>
                        <div class="col-sm-12  mt-5">
                            <h5 class="input-new"><label for="scopeServices">{{__('Scope of Services')}}:</label></h5>
                            <p>{!!nl2br(@$finalProposal['scopeOfService'])!!}</p>
                        </div>
                        <div class="col-sm-12 mt-5">
                            <h5 class="input-new"><label for="schedule">{{__('Schedule')}}:</label></h5>
                            <p>{!!nl2br(@$proposal_settings->schedule)!!}</p>
                        </div>
                        <div class="col-sm-12 mt-5">
                            <h5 class="input-new"><label for="costBusinessTerms">{{__('Cost and Business Terms')}}:</label></h5>
                            <p>{!!nl2br(@$finalProposal['costBusiness'])!!}</p>
                        </div>
                        <div class="col-sm-12 mt-5">
                            <h5 class="input-new"><label for="cencellation">{{__('CANCELLATION')}}:</label></h5>
                            <div class="textarea">
                                <p>{!!nl2br(@$finalProposal['cancenllation'])!!}</p>
                            </div>
                        </div>
                        <!-- <div class="col-sm-12 mt-5">
                            <h5 class="input-new">{!!@$proposal_settings->cancenllation!!}</h5>
                        </div> -->

                        <div class="table">
                            <table style="width: 100%; border-collapse: collapse; margin: 20px 0; font-family: Arial, sans-serif; background-color: #f9f9f9;">
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 8px;">Name</td>
                                    <td style="padding: 8px;">{{__($proposal_info->from->name)}}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 8px;">Title</td>
                                    <td style="padding: 8px;">{{__($proposal_info->from->designation)}}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 8px;">Date</td>
                                    <td style="padding: 8px;">{{dateFormat_blade($proposal_info->from->date)}}</td>
                                </tr>
                                <!-- <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 8px;" colspan="2" style="text-align: center; background-color: #f2f2f2; font-weight: bold;">For {{ __($lead->company_name) }}</td>
                                </tr> -->
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-4 mb-3">
                            <button class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<style>
    canvas#signatureCanvas {
        border: 1px solid black;
        width: auto;
        height: auto;
        border-radius: 8px;
    }

    #clearButton,
    #signatureCanvas {
        margin: 10px auto;
        display: -webkit-box;
    }

    .mt-3.auuthsig {
        border: 1px solid black;
        width: 100%;
        height: 165px;
        border-radius: 8px;
    }

    .row {
        --bs-gutter-x: -9rem;
    }
</style>
@include('partials.admin.head')
@include('partials.admin.footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var canvas = document.getElementById('signatureCanvas');
        canvas.width = 400;
        canvas.height = 200;
        var signaturePad = new SignaturePad(canvas);

        function clearCanvas() {
            signaturePad.clear();
        }
        document.getElementById('clearButton').addEventListener('click', function(e) {
            e.preventDefault();
            clearCanvas();
        });
        document.querySelector('form').addEventListener('submit', function() {
            if (signaturePad.points.length != 0) {
                document.getElementById('imageData').value = signaturePad.toDataURL();
            } else {
                document.getElementById('imageData').value = '';
            }
        });
    });
</script>