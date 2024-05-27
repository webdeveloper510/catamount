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

// $data['lead'] = $lead->toArray();
// $data['users'] = $users->toArray();
// $data['venue'] = $venue;
// $data['settings'] = $settings;
// $data['fixed_cost'] = $fixed_cost;
// $data['additional_items'] = $additional_items;

/* echo '<pre>';
print_r($proposal);
echo '</pre>'; */
$proposal = unserialize($settings['proposal']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal</title>
    <link rel="stylesheet" href="https://www.jqueryscript.net/demo/Rich-Text-Editor-jQuery-RichText/richtext.min.css">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style>
    .border-new {
        border: 1px solid #000 !important;
        padding: 25px 0;
    }

    .border-new1 {
        padding: 40px 0 60px 0;
    }

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
                                <img class="logo-img center-new" src="{{ URL::asset('storage/uploads/logo/3_logo-light.png')}}" style="width: auto;">
                            </div>
                        </div>
                        <div class="col-sm-12 border-new">
                            <h4 class="center-new">{{__('Proposal Acceptance Agreement')}}</h4>
                        </div>
                        <div class="col-sm-12 border-new">
                            <h5 class="center-new">PLEASE RETURN TO: Catamount Consulting, PO Box 442, Warrensburg NY 12885</br>Or</h5>
                            <h5 class="center-new input-new">
                                <label for="email">{{__('Email')}}: </label>{{__($users->email)}}
                            </h5>
                            <h5 class="center-new">Feel free to call our office at (518) 623-2352 with any questions</h5>
                        </div>
                        <div class="col-sm-12 border-new">
                            <h5 class="input-new">
                                <label for="client">{{__('Client')}}:</label>{{__($lead->name)}}
                            </h5>
                        </div>
                        <div class="col-sm-6 border-new">
                            <h5 class="input-new">
                                <label for="phone">{{__('Phone')}}:</label>{{__($lead->primary_contact)}}
                            </h5>
                        </div>
                        <div class="col-sm-6 border-new">
                            <h5 class="input-new">
                                <label for="email2">{{__('Email')}}</label>{{__($lead->email)}}
                            </h5>
                        </div>
                        <div class="col-sm-12 border-new">
                            <h5 class="input-new">
                                <label for="servicesDate">{{__('Date of service')}}:</label>{{__($lead->start_date)}}
                            </h5>
                        </div>
                        <div class="col-sm-12 border-new">
                            <h5 class="input-new">
                                <label for="services">{{__('Services')}}:</label>{{__($lead->type)}}
                            </h5>
                        </div>
                        <div class="col-sm-12 border-new border-new1" style="min-height: 250px;">
                            <h5 class="input-new">
                                <label for="agreement">{{__('Agreement')}}:</label>
                            </h5>
                            {!!@$proposal['agreement']!!}
                            <!-- <textarea name="agreement" id="agreement" class="agreement"></textarea> -->
                        </div>
                        <div class="col-sm-12 border-new">
                            <div id="sig">
                                <h5 class="input-new">
                                    <label for="signature">{{__('Signature')}}:</label>
                                    <canvas id="signatureCanvas" width="300" class="signature-canvas"></canvas>
                                    <input type="hidden" name="imageData" id="imageData">
                                </h5>
                            </div>
                            <button type="button" id="clearButton" class="btn btn-danger btn-sm mt-1">Clear Signature</button>
                        </div>
                        <div class="col-sm-12 border-new border-new1" style="min-height: 250px;">
                            <h5 class="input-new">
                                <label for="remarks">{{__('Remarks')}}:</label>
                            </h5>
                            {!!@$proposal['remarks']!!}
                            <!-- <textarea name="remarks" id="remarks" class="remarks"></textarea> -->

                        </div>
                        <div class="col-sm-12 mt-5">
                            <h5 class="input-new">
                                <label for="date">{{__('Date')}}: {{__($lead->start_date)}}</label>
                            </h5>
                        </div>
                        <div class="col-sm-12 border-new1">
                            <h5 class="input-new">
                                <label for="scopeServices">{{__('Scope of Services')}}:</label>
                            </h5>
                        </div>
                        <div class="col-sm-12 mt-5">
                            <h5 class="input-new">
                                <label for="schedule">{{__('Schedule')}}:</label>
                                <p>Catamount Consulting is prepared to proceed upon receiving the Proposal Acceptance Agreement</p>
                            </h5>
                        </div>
                        <div class="col-sm-12 mt-5">
                            <h5 class="input-new">
                                <label for="costBusinessTerms">{{__('Cost and Business Terms')}}:</label>
                                <p>The Proposal shall remain valid for the period of 60 days from the date of the proposal origination. </p>
                            </h5>
                        </div>
                        <div class="col-sm-12 mt-5">
                            <h5 class="input-new">
                                <label for="cencellation">{{__('CANCELLATION')}}:</label>
                                <p>Should the above testing be cancelled within 2 weeks of the testing date, there will be a cancellation fee of $ . If testing is rescheduled within 1 month, the cancellation fee will be</br>negotiated and mitigated.
                                </p>
                            </h5>
                        </div>
                        <div class="col-sm-12 mt-5">
                            <h5 class="input-new">We look forward to work with you. Please feel free to contact our office with any questions or concerns.</br>Respectfully,</h5>
                        </div>
                        <!-- <div class="col-sm-12 mt-5 details">
                            <h5 class="input-new1"><label for="name">{{__('Name')}}: </label><input type="text" name="name" id="name" value="" /></h5>
                            <h5 class="input-new1"><label for="designation">{{__('Designation')}}: </label><input type="text" name="designation" id="designation" value="" /></h5>
                            <h5 class="input-new1"><label for="date">{{__('Date')}}: </label><input type="date" name="date" id="date" value="{{__(date('Y-m-d'))}}" /></h5>
                            <h5 class="input-new1"><label for="to">{{__('To')}}</label></h5>
                            <h5 class="input-new1"><label for="name">{{__('Name')}}: </label><input type="text" name="to_name" id="to_name" value="" /></h5>
                            <h5 class="input-new1"><label for="designation">{{__('Designation')}}: </label><input type="text" name="to_designation" id="to_designation" value="" /></h5>
                            <h5 class="input-new1"><label for="date">{{__('Date')}}: </label><input type="date" name="to_date" id="to_date" value="" /></h5>
                        </div> -->
                        <div class="table">
                            <table style="width: 100%; border-collapse: collapse; margin: 20px 0; font-family: Arial, sans-serif; background-color: #f9f9f9;">
                                <tr style="color: #000; text-align: left;">
                                    <th style="padding: 12px;">Label</th>
                                    <th style="padding: 12px;">Details</th>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 8px;">Name</td>
                                    <td style="padding: 8px;">{{__($users->name)}}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 8px;">Designation</td>
                                    <td style="padding: 8px;">{{__($users->type)}}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 8px;">Date</td>
                                    <td style="padding: 8px;">{{__(date('Y-m-d'))}}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 8px;" colspan="2" style="text-align: center; background-color: #f2f2f2; font-weight: bold;">To</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 8px;">Name</td>
                                    <td style="padding: 8px;"><input type="text" name="to_name" id="to_name" value="" /></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 8px;">Designation</td>
                                    <td style="padding: 8px;"><input type="text" name="to_designation" id="to_designation" value="" /></td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px;">Date</td>
                                    <td style="padding: 8px;"><input type="date" name="to_date" id="to_date" value="" /></td>
                                </tr>
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

<!-- <div class="row mt-5">
                        <div class="col-md-6">
                            <strong>The Bond 1786</strong><br>
                            <div class="mt-3 auuthsig">
                                <img src="{{$base64Image}}" style="margin-left: 100px;width: 40%;">
                            </div>
                            <h5 class="mt-2">Authorised Signature</h5>
                        </div>
                        <div class="col-md-6">
                            <strong> Signature:</strong>
                            <br>
                            <div id="sig" class="mt-3">
                                <canvas id="signatureCanvas" width="300" class="signature-canvas"></canvas>
                                <input type="hidden" name="imageData" id="imageData">
                            </div>
                            <button type="button" id="clearButton" class="btn btn-danger btn-sm mt-1">Clear Signature</button>
                        </div>
                    </div> -->

</html>

<style>
    canvas#signatureCanvas {
        border: 1px solid black;
        width: auto;
        height: auto;
        border-radius: 8px;
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
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
<!-- <script src="https://www.jqueryscript.net/demo/Rich-Text-Editor-jQuery-RichText/jquery.richtext.js" type="text/javascript"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
<script>
    //jQuery('#agreement').richText();
    //jQuery('#remarks').richText();
    document.addEventListener('DOMContentLoaded', function() {
        var canvas = document.getElementById('signatureCanvas');
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