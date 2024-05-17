<?php
$billing = App\Models\ProposalInfo::where('lead_id',$lead->id)->orderby('id','desc')->first();
if(isset($billing) && !empty($billing)){
    $billing= json_decode($billing->proposal_info,true);
}
$selectedvenue = explode(',', $lead->venue_selection);
$settings = App\Models\Utility::settings();
$imagePath = public_path('upload/signature/autorised_signature.png');
$imageData = base64_encode(file_get_contents($imagePath));
$base64Image = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . $imageData;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal</title>
</head>

<body>
    <div class="container mt-5">
        <div class="row card">
            <div class="col-md-12 ">
                <form method="POST" action="{{route('lead.proposalresponse',urlencode(encrypt($lead->id)))}}"
                    id='formdata'>
                    @csrf
                    <input type="hidden" name="proposal" value="<?php if(isset($_GET['prop'])){ echo $_GET['prop']; } ?>">
                    <div class="row">
                        <div class="col-md-4 mt-4">
                            <div class="img-section">
                                <img class="logo-img" src="{{ URL::asset('storage/uploads/logo/3_logo-light.png')}}"
                                    style="width:25%;">
                            </div>
                        </div>
                        <div class="col-md-8 mt-5">
                            <h4>The Bond 1786 - Proposal</h4>
                            <!-- <h4>Proposal</h4> -->
                            <h5>Venue Rental & Banquet Event - Estimate</h5>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <dl>
                                <span>{{__('Name')}}: {{ $lead->name }}</span><br>
                                <span>{{__('Phone & Email')}}: {{ $lead->phone }} , {{ $lead->email }}</span><br>
                                <span>{{__('Address')}}: {{ $lead->lead_address }}</span><br>
                                <span>{{__('Event Date')}}:{{ \Carbon\Carbon::parse($lead->start_date)->format('d M, Y') }}</span>
                            </dl>
                        </div>

                        <div class="col-md-6" style="text-align: end;">
                            <dl>
                                <span>{{__('Primary Contact')}}: {{ $lead->name }}</span><br>
                                <span>{{__('Phone')}}: {{ $lead->phone }}</span><br>
                                <span>{{__('Email')}}: {{ $lead->email }}</span><br>
                            </dl>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr style="background-color:#d3ead3; text-align:center">
                                        <th>Event Date</th>
                                        <th>Time</th>
                                        <th>Venue</th>
                                        <th>Event</th>
                                        <th>Function</th>
                                        <th>Guest Count</th>
                                        <th>Room</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="text-align:center">

                                        <td>
                                            {{ \Carbon\Carbon::parse($lead->start_date)->format('d M, Y')}}
                                        </td>

                                        <td>
                                            @if($lead->start_time == $lead->end_time)
                                            --
                                            @else
                                            {{date('h:i A', strtotime($lead->start_time))}} -
                                            {{date('h:i A', strtotime($lead->end_time))}}
                                            @endif</td>
                                        <td>{{$lead->venue_selection}}</td>
                                        <td>{{$lead->type}}</td>
                                        <td>{{$lead->function}}</td>
                                        <td>{{$lead->guest_count}}</td>
                                        <td>{{$lead->rooms}}</td>
                                        <!-- <td>Exp</td>
                                        <td>GTD</td>
                                        <td>Set</td>
                                        <td>RENTAL</td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-12">
                            <h5 class="headings"><b>Billing Summary - ESTIMATE</b></h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th
                                            style="text-align:left; font-size:13px;text-align:left; padding:5px 5px; margin-left:5px;">
                                            Name : {{ucfirst($lead->name)}}</th>
                                        <th colspan="2" style="padding:5px 0px;margin-left: 5px;font-size:13px"></th>
                                        <th colspan="3"
                                            style="text-align:left;text-align:left; padding:5px 5px; margin-left:5px;">
                                            Date:<?php echo date("d/m/Y"); ?> </th>
                                        <th style="text-align:left; font-size:13px;padding:5px 5px; margin-left:5px;">
                                            Event: {{ucfirst($lead->type)}}</th>
                                    </tr>
                                    <tr style="background-color:#063806;">
                                        <th>Description</th>
                                        <th colspan="2"> Additional</th>
                                        <th>Cost</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Venue Rental</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>

                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{$billing['venue_rental']['cost'] ?? 0}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">{{$billing['venue_rental']['quantity'] ?? 1}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{$total[] = ($billing['venue_rental']['cost'] ?? 0)  * ($billing['venue_rental']['quantity'] ?? 1)}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            {{$lead->venue_selection}}</td>
                                    </tr>

                                    <tr>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Brunch / Lunch /
                                            Dinner Package</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{$billing['food_package']['cost'] ?? 0 }}</td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            {{$billing['food_package']['quantity'] ?? 1}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{$total[] =($billing['food_package']['cost'] ?? 0) * ($billing['food_package']['quantity'] ?? 1)}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            {{$lead->function}}</td>

                                    </tr>

                                    <tr>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Hotel Rooms</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{$billing['hotel_rooms']['cost'] ?? 0}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            {{$billing['hotel_rooms']['quantity'] ?? 1}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">

                                            ${{$total[] = ($billing['hotel_rooms']['cost'] ?? 0) *  ($billing['hotel_rooms']['quantity'] ?? 1)}}


                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Bar Package</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{$billing['bar_package']['cost'] ?? 0 }}</td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            {{$billing['bar_package']['quantity'] ?? 1}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{$total[] =($billing['bar_package']['cost'] ?? 0) * ($billing['bar_package']['quantity'] ?? 1)}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            {{$lead->bar}}</td>

                                    </tr>

                                    <tr>
                                        <td>-</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td colspan="3" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>

                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Total</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{array_sum($total)}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Sales, Occupancy
                                            Tax</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"> </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{ 7* array_sum($total)/100 }}
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="text-align:left;text-align:left; padding:5px 5px; margin-left:5px;font-size:13px;">
                                            Service Charges & Gratuity</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{ 20 * array_sum($total)/100 }}
                                        </td>

                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>-</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;"> </td>

                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="background-color:#ffff00; padding:5px 5px; margin-left:5px;font-size:13px;">
                                            Grand Total / Estimated Total</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{$grandtotal= array_sum($total) + 20* array_sum($total)/100 + 7* array_sum($total)/100}}
                                        </td>

                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="background-color:#d7e7d7; padding:5px 5px; margin-left:5px;font-size:13px;">
                                            Deposits on file</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td colspan="3"
                                            style="background-color:#d7e7d7;padding:5px 5px; margin-left:5px;font-size:13px;">
                                            No Deposits yet
                                        </td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="background-color:#ffff00;text-align:left; padding:5px 5px; margin-left:5px;font-size:13px;">
                                            balance due</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td colspan="3"
                                            style="padding:5px 5px; margin-left:5px;font-size:13px;background-color:#9fdb9f;">
                                            ${{$grandtotal= array_sum($total) + 20* array_sum($total)/100 + 7* array_sum($total)/100}}

                                        </td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                    </tr>
                                </tbody>

                            </table>

                            <p class="text mt-2">
                                Please return the signed proposal no later than
                                <b>{{ \Carbon\Carbon::parse($lead->start_date)->subDays($settings['buffer_day'])->format('d M, Y') }}</b>
                                or this proposal is no longer valid.<br>
                            </p>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="comments" class="form-label">Comments</label>
                            <textarea name="comments" id="comments" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-6">
                        <strong>The Bond 1786</strong> <br>

                            <div  class="mt-3 auuthsig">
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
                            <button type="button" id="clearButton" class="btn btn-danger btn-sm mt-1">Clear
                                Signature</button>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <button class="btn btn-success" style="float:right;margin-top:-40px">Submit</button>
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
    width: 80%;
    height: 165px;
    border-radius: 8px;
}
.mt-3.auuthsig {
    border: 1px solid black;
    width: 80%;
    height: 165px;
    border-radius: 8px;
}

</style>
@include('partials.admin.head')
@include('partials.admin.footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
<script>
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
<style>
.row {
    --bs-gutter-x: -11.5rem;
}

/* .table{
            border-collapse: unset;
        } */
</style>