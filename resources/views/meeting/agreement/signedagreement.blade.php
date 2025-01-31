<?php
$selectedvenue = explode(',', $meeting->venue_selection);
$imagePath = public_path('upload/signature/autorised_signature.png');
$imageData = base64_encode(file_get_contents($imagePath));
$base64Image = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . $imageData;
$bar_pck = json_decode($meeting['bar_package'], true);

$billing_invoice_data = $billing_data;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agreement</title>
</head>

<body>
    <div class="container mt-5">
        <div class="row card">
            <div class="col-md-12">
                <form method="POST" action="{{route('meeting.signedagreementresp',urlencode(encrypt($meeting->id)))}}" id='formdata'>
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mt-4">
                            <div class="img-section">
                                <img class="logo-img" src="{{ url('storage/uploads/logo/3_logo-light.png')}}" style="width:50%;">
                            </div>
                        </div>
                        <div class="col-md-8 mt-5">
                            <h4>Catamount Consulting - Agreement</h4>
                            <!-- <h4>Proposal</h4> -->
                            <!-- <h5>Location Rental & Banquet Training - Estimate</h5> -->
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <dl>
                                <span>{{__('Name')}}: {{ $meeting->name }}</span><br>
                                <span>{{__('Phone & Email')}}: {{ $meeting->phone }} , {{ $meeting->email }}</span><br>
                                <span>{{__('Address')}}: {{ $meeting->lead_address }}</span><br>
                                <span>{{__('Training Start Date')}}:{{ \Carbon\Carbon::parse($meeting->start_date)->format('d M, Y') }}</span>
                            </dl>
                        </div>
                        <div class="col-md-6" style="text-align: end;">
                            <dl>
                                <span>{{__('Primary Contact')}}: {{ $meeting->name }}</span><br>
                                <span>{{__('Phone')}}: {{ $meeting->phone }}</span><br>
                                <span>{{__('Email')}}: {{ $meeting->email }}</span><br>
                            </dl>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <table class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr style="background-color:#d3ead3; text-align:center">
                                        <th>Training Date</th>
                                        <th>Time</th>
                                        <th>Traingin location</th>
                                        <th>Training</th>
                                        {{--<th>Function</th>
                                            <th>Room</th>--}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="text-align:center">
                                        <td>Start Date:
                                            {{\Carbon\Carbon::parse($meeting->start_date)->format('d M, Y')}} <br>
                                            End Date: {{\Carbon\Carbon::parse($meeting->start_date)->format('d M, Y')}}
                                        </td>
                                        <td>Start
                                            Time:{{date('h:i A', strtotime($meeting->start_time))}} <br>
                                            End time:{{date('h:i A', strtotime($meeting->end_time))}}</td>
                                        <td>
                                            {{$meeting->venue_selection}}
                                        </td>
                                        <td>{{$meeting->type}}
                                        </td>
                                        {{--<td>
                                            {{$meeting->function}}
                                        </td>
                                        <td>{{$meeting->rooms}}
                                        </td>--}}
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{--<div class="row mt-3">
                        <div class="col-md-12">
                            <p class="text"><b>This contract defines the terms and conditions under which Lotus Estate,
                                    LLC
                                    dba Catamount Consulting, (hereinafter referred to as The Bond or The
                                    Bond 1786), and <b>{{$meeting->name}}</b>(hereafter referred to as the Customer)
                                    agree
                                    to the Customer’s use of Catamount Consulting facilities on
                                    <b>{{ \Carbon\Carbon::parse($meeting->start_date)->format('d M, Y') }}</b>
                                    (reception/Training date). This contract constitutes the entire agreement between the
                                    parties and becomes binding upon the signature of
                                    both parties. The contract may not be amended or changed unless executed in writing
                                    and
                                    signed by Catamount Consulting and the Customer.</b>
                            </p>
                        </div>
                    </div>--}}
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="headings">Training location</h6>
                            <!-- <h6>Location Selected</h6> -->
                            <p>{{$meeting->venue_selection}}</p><br>
                            {{--<h6 class="headings"> No. of Hotel Rooms (Booked)</h6>
                            <p>{{$meeting->room}}</p><br>
                            <!-- <input type= "number" name ="rooms"min = "0" value = "{{$meeting->room}}" disabled> -->
                            <p class="text">
                                The Location/s described above has been reserved for you for the date and time stipulated.
                                Please note that the hours assigned to your Training include all set-up and
                                all clean-up, including the set-up and clean-up of all subcontractors that you may
                                utilize. It is understood you will adhere to and follow the terms of this Agreement,
                                and you will be responsible for any damage to the premises and site, including the
                                behavior of your guests, invitees, agents, or sub-contractors resulting from your
                                use of Location/s.
                            </p>
                            <h6 class="headings">Rental Deposit and Payment Agreement</h6>
                            <p class="text">
                                The total cost for use of Catamount Consulting and its facilities described in this contract is
                                listed above. To reserve services on the
                                date/s requested, Catamount Consulting requires this contract be signed by Customer and an <b>
                                    initial payment of $3,000</b> be deposited.
                                The balance is due prior to the Training date. Deposits and payments will be made at the
                                time of signing of the Contract. Payments
                                can be made by cash, Bank checks (made payable to <b>Catamount Consulting</b>), on the schedule
                                noted below. A receipt from The Bond
                                1786 will be provided for each.
                            </p>--}}
                            <h6 class="headings">Billing Summary</h6>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align:left; font-size:13px;text-align:left; padding:5px 5px; margin-left:5px;">
                                            Name : {{$meeting->name}}</th>
                                        <th colspan="3" style="text-align:left;text-align:left; padding:5px 5px; margin-left:5px;">
                                            Date:<?php echo date("d/m/Y"); ?> </th>
                                        <th style="text-align:left; font-size:13px;padding:5px 5px; margin-left:5px;">
                                            Training: {{$meeting->type}}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="text-align:left; font-size:13px;text-align:left; padding:5px 5px; margin-left:5px;">P.O. No. : {{$billing->purchaseOrder}}</th>
                                        <th colspan="3" style="text-align:left;text-align:left; padding:5px 5px; margin-left:5px;">Terms: {{ $billing->terms }} </th>
                                    </tr>
                                    <tr style="background-color:#063806;">
                                        <th>Description</th>
                                        <!-- <th colspan="2">Additional</th> -->
                                        <th>Cost</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($billing_invoice_data as $billing_invoice_key => $billing_invoice_value)
                                    <tr>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">{{ $billing_invoice_value['description'] }}</td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">{{ $billing_invoice_value['cost'] }}</td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">{{ $billing_invoice_value['quantity'] }}</td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">{{ $billing_invoice_value['total'] }}</td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">{{ $billing_invoice_value['note'] }}</td>
                                    </tr>
                                    @endforeach

                                    <tr>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Subtotal</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{ $billing->total }}</td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Sales, Occupancy
                                            Tax</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"> </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            {{ $billing->salesTax }}%</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left;text-align:left; padding:5px 5px; margin-left:5px;font-size:13px;">Total</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{ $billing->totalAmount}}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:#ffff00; padding:5px 5px; margin-left:5px;font-size:13px;">Payments/Credits</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{$billing->paymentCredit + $billing->deposits }}
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:#ffff00; padding:5px 5px; margin-left:5px;font-size:13px;">Balance Due </td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{ $billing->totalAmount - $billing->paymentCredit - $billing->deposits}}
                                        </td>
                                        <td></td>
                                    </tr>


                                    {{--<tr>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Training location</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{@$billing_data['venue_rental']['cost']}}</td>
                                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                        {{@$billing_data['venue_rental']['quantity']}}
                                    </td>
                                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                        ${{$total[] = @$billing_data['venue_rental']['cost'] * @$billing_data['venue_rental']['quantity']}}
                                    </td>
                                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                        {{$meeting['venue_selection']}}
                                    </td>
                                    </tr>

                                    <tr>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Brunch / Lunch /
                                            Dinner Package</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{@$billing_data['food_package']['cost']}}</td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            {{@$billing_data['food_package']['quantity']}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{$total[] =@$billing_data['food_package']['cost'] * @$billing_data['food_package']['quantity']}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            {{$meeting['function']}}
                                        </td>

                                    </tr>
                                    <tr>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Bar Package</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{@$billing_data['bar_package']['cost']}}</td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            {{@$billing_data['bar_package']['quantity']}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{$total[] = @$billing_data['bar_package']['cost']* @$billing_data['bar_package']['quantity']}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            {{implode(',',$bar_pck)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Hotel Rooms</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{@$billing_data['hotel_rooms']['cost']}}</td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            {{@$billing_data['hotel_rooms']['quantity']}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{$total[] = @$billing_data['hotel_rooms']['cost'] * @$billing_data['hotel_rooms']['quantity']}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Tent, Tables,
                                            Chairs, AV Equipment</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{@$billing_data['equipment']['cost']}}</td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            {{@$billing_data['equipment']['quantity']}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{$total[] = @$billing_data['equipment']['cost'] * @$billing_data['equipment']['quantity']}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                    </tr>

                                    @if(!@$billing_data['setup']['cost'] == '')
                                    <tr>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Welcome / Rehearsal
                                            / Special Setup</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{@$billing_data['setup']['cost']}}</td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            {{@$billing_data['setup']['quantity']}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{$total[] =@$billing_data['setup']['cost'] * @$billing_data['setup']['quantity']}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Special Requests /
                                            Others</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{@$billing_data['special_req']['cost']}}</td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            {{@$billing_data['special_req']['quantity']}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{$total[] =@$billing_data['special_req']['cost'] * @$billing_data['special_req']['quantity']}}
                                        </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                    </tr>
                                    <tr>
                                        <td>-</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td colspan="3" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                    </tr>--}}




                                    {{--<tr>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Total</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{array_sum($total)}}</td>
                                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Sales, Occupancy
                                            Tax</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"> </td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{ 7* array_sum($total)/100 }}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left;text-align:left; padding:5px 5px; margin-left:5px;font-size:13px;">
                                            Service Charges & Gratuity</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{ 20 * array_sum($total)/100 }}</td>

                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>-</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>

                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:#ffff00; padding:5px 5px; margin-left:5px;font-size:13px;">
                                            Grand Total / Estimated Total</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{$grandtotal= array_sum($total) + 20* array_sum($total)/100 + 7* array_sum($total)/100}}
                                        </td>

                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:#d7e7d7; padding:5px 5px; margin-left:5px;font-size:13px;">
                                            Deposits on file</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td colspan="3" style="background-color:#d7e7d7;padding:5px 5px; margin-left:5px;font-size:13px;">
                                            ${{$deposit= $billing->deposits}}</td>
                                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:#ffff00;text-align:left; padding:5px 5px; margin-left:5px;font-size:13px;">
                                            balance due</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                        <td colspan="3" style="padding:5px 5px; margin-left:5px;font-size:13px;background-color:#9fdb9f;">
                                            ${{$grandtotal - $deposit}}</td>
                                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                                    </tr>--}}
                                </tbody>
                            </table>
                            <input type="hidden" value="{{@$grandtotal}}" name="grandtotal">
                            {{--<h3 class=" mt-5" style="text-align:center ">TERMS AND CONDITIONS</h3>
                            <h6 class="headings">FOOD AND ALCOHOLIC BEVERAGES and 3RD PARTY / ON-SITE VENDORS</h6>
                            <p class="text">
                                The Client and their guests agree to not bring in any unauthorized food or beverage into
                                Catamount Consulting. The Establishment does not allow outside alcoholic beverages, unless
                                agreed with the Terms. Catering service is available at a cost; please see your
                                Coordinator for menu selections. The Coordinator / Owner reserves the right to approve
                                all vendors providing services to the Training to include food,
                                audio/visual, and merchandise.
                            </p>
                            <p class="text">It is understood and agreed that the Customer may serve beverages containing
                                alcohol (including but not limit to beer, wine, champagne, mixed drinks
                                with liquor, etc., by way of example) hereinafter call “Alcohol”, upon the following
                                terms and conditions:
                            </p>
                            <ul>
                                <li> A copy of Liquor License/Permit must be on records at the Establishment before any
                                    alcohol can be served at your Training, by a 3 rd Party Vendor.</li>
                                <li>A food waiver must be on file for all outside food brought to the Establishment.
                                </li>
                                <li>Under NO circumstances shall Client(s) sell or attempt to sell any Alcohol to
                                    anyone.</li>
                                <li>Customer shall not permit any person under the age of twenty-one (21) to consume
                                    alcohol regardless of whether the person is accompanied by a parent or guardian.
                                </li>
                                <li>Customer hereby agrees to use their best efforts to ensure that Alcohol will not be
                                    served to anyone who is intoxicated or appears to be intoxicated.</li>
                                <li>Customer hereby expressly grants to Catamount Consulting, at The Bond’s sole discretion and
                                    option, to instruct the security officer(s) to remove any person(s) from the Location,
                                    if in the opinion of Catamount Consulting representative in charge, the licensed
                                    and bonded Bartender and/or the security officer(s) the person(s) is intoxicated,
                                    unruly or could present a danger to themselves or others, and/or the Location.</li>
                                <li>Customer hereby agrees to be liable and responsible for all act(s) and actions of
                                    every kind and nature for each person in attendance at Customer’s function or Training.
                                </li>
                                <li>Caterers: No caterer can be used without prior approval of Catamount Consulting. Each
                                    caterer approved should be familiar with Catamount Consulting Locations, rules, and
                                    regulations.</li>
                                <li>Each one of these caterers will have to carry required liability insurance for The
                                    Bond.</li>
                                <li>If Customer requests a different food service company, they must be pre-approved by
                                    Catamount Consulting and meet their rules and regulations.</li>
                                <li>Your catering company is responsible for the set-up, break-down and clean-up of the
                                    catered site. Please allow appropriate time for break-down and clean-up to meet the
                                    contracted timelines.</li>
                                <li>All Training trash must be disposed of in the designated areas at the conclusion of the
                                Training.</li>
                                <li>ALL vendors must adhere to the terms of our guidelines, and it is the Customer’s
                                    responsibility to share these guidelines with them.</li>
                                <li>Usage of cooking equipment such as fryers are allowed, with proper safety
                                    precautions, DOH certifications and requirements fully satisfied. The areas these
                                    can be used should be pre-evaluated and approved, along with the provisions for oil
                                    disposal.</li>
                                <li>All food brought into the Establishment must be prepared and ready for reheat with
                                    chafing dish and sterno / Gas fuel.</li>
                                <li>Food and beverage must be contained in your contracted Training space only and should
                                    not be brought into the lobby or other Establishment public space.</li>
                            </ul>
                            <h6 class="headings">CANCELLATION POLICY & DATE CHANGES:</h6>
                            <p class="text"><b>Small & Private Trainings -</b> A written cancellation request must be
                                received by The Bond sales office no later than 30 days prior to contracted Training date
                                to avoid
                                forfeit of deposit or payment toward expected revenue. Cancellations received after this
                                time will incur a charge in the amount of the contracted revenue.
                                100% of expected revenue is not refundable if cancellation is made between 1-29 days
                                prior to Training date. Company or individual contracting the Training will be
                                assessed this charge through either a deduction from the prepayment or charge credit
                                card on file, whichever applies. If cash payment, you will be invoiced for
                                any cancellation fees. Trainings that are booked within the 29-day period cannot be
                                cancelled and are non-refundable, unless agreed upon and approved during the
                                booking of the Training.</p>

                            <b>Large Trainings & Weddings -</b>
                            <p>
                                1. Changes: In the unlikely Training the Customer is required to change the date of the
                                Training or Wedding, every effort will be made by Catamount Consulting to transfer reservations to
                                support the new date. The Customer agrees that in the Training of a date change, any
                                expenses including, but not limited to, deposits, and fees that are non-refundable, and
                                non-transferable are the sole responsibility of Customer. The Customer further
                                understands that last minute changes can impact the quality of the Training, and that The
                                Bond 1786 is not responsible for these compromises in quality.

                                2. Cancellation: In the Training customer cancels the Training, customer shall notify The Bond
                                1786 immediately in writing or by email. Once cancelled, the Customer shall be
                                responsible for agreed liquidated damages as follows. The parties agree that the
                                liquidated damages are reasonable.
                            </p>
                            <ul>
                                <li> In the Training Customer cancels the Training more than one year prior to the Training,
                                    Customer shall forfeit to Catamount Consulting as liquidated damages one-half (1/2) of
                                    deposit.</li>
                                <li>In the Training customer cancels the Training less than one year but not more than six
                                    months prior to the Training, Customer shall forfeit to Catamount Consulting as liquidated
                                    damages the entire deposit. </li>
                                <li> In the Training Customer cancels the Training less than six (6) months but more than
                                    three (3) months prior to the Training, Customer shall forfeit to Catamount Consulting as
                                    liquidated damages fifty percent (50 %) of the rental fee. </li>
                                <li> In the Training customer cancels the Training less than three (3) months prior to the
                                Training, Customer shall forfeit to Catamount Consulting as liquidated damages the entire
                                    rental fee. </li>
                            </ul>
                            <h6 class="headings"> GUARANTEE NUMBER OF GUESTS: </h6>
                            <p class="text">The (GTD) guaranteed count will be the assumed as the minimum billable
                                count, however the final guaranteed number of guests is due (7) seven working days prior
                                to
                                the start of your Training. Should the final guarantee not be received (7) seven working
                                days prior to the above Training(s), the basis for the final billing calculation will
                                be the above contracted GTD (guaranteed) number of guests, or the actual number of
                                guests attending the Training, whichever is higher. </p>

                            <h6 class="headings">SET-UP & Training SET-UP LIMITATIONS:</h6>
                            <p>Any space / room set up changes made on the day of the Training will be charged a $500 fee.
                                Additional time required above
                                the contracted time will be charged a $250 per hour fee. Client may bring their own
                                linen, decorations, and equipment but must be approved by the Coordinator / Owner first.
                                Upgrade tablecloth, chair cover, audio-visual is available at a cost; please see your
                                Coordinator for options. Usage of other Training space or Establishment public space must
                                be under contract or usage is chargeable and must be approved by the Coordinator /
                                Owner. </p>
                            <ul>
                                <li>All property belonging to Customer, Customer’s invitees, guests, agents and
                                    sub-contractors, and all equipment shall be delivered, set-up and removed on the day
                                    of the Training.
                                    Should the Customer need earlier access for set-up purposes, this can be arranged
                                    for an additional fee. The Customer is ultimately responsible for property belonging
                                    to the
                                    Customer’s invitees, guests, agents, and sub-contractors.
                                </li>
                                <li>Rental items must be scheduled for pick-up no later than within 24 hours of the
                                    conclusion of the Training.</li>
                                <li>Alcohol service must stop no later than 11:00 PM (or maximum of 5-hours if occurring
                                    sooner).</li>
                                <li>Music (DJ or live music) must stop no later than 11:00 PM</li>
                                <li>All guests must be off Catamount Consulting premises no later than midnight the day of the
                                Training (except clean-up crew, with all clean-ups to be done by 1:00 am).</li>
                            </ul>
                            <h6 class="headings">FINAL PAYMENT & PAYMENT POLICY:</h6>
                            <p> 100% of expected / outstanding balance payment is due 14 days prior to Training date. The
                                Establishment will terminate the contract
                                if payment is not received by contracted due date. If deposit or full payment is not
                                received as required by contracted date, the contract will be canceled. For check
                                payment
                                please send payment to: Catamount Consulting, (3, Hudson Street, Warrensburg, NY 12885). Rooms
                                must be paid for before entry is granted unless alternative payment arrangements have
                                been
                                pre-established for Training payment. </p>

                            <h6 class="headings">DAMAGES:</h6>
                            <p> The individual signing this agreement will be responsible for damage to or loss of
                                revenue by the Establishment due to activities of the guests under this contract,
                                including but not limited to the building, Establishment equipment, decorations,
                                fixtures, furniture, and refunds due to the negligence of your guests. The deposit which
                                is typically
                                applied towards the total bills of the organized Training, however in case of settlement of
                                damages, the deposit may be applied towards the total damages, including the use of the
                                Credit
                                Card on file, should there be a remaining balance due to Catamount Consulting. </p>

                            <h6 class="headings">COMPLIANCE WITH LAWS:</h6>
                            <p>You will comply with all applicable local and national laws, codes, regulations,
                                ordinances, and rules with respect to your obligations under
                                this Agreement and the services to be provided by you hereunder, including but not
                                limited to any laws and regulations governing Training organizers. You represent, warrant,
                                and agree
                                that you, are currently, and will continue to be for the term of this Agreement, in
                                compliance with all applicable local, state, federal regulations or laws. </p>

                            <h6 class="headings">INDEMNIFICATION:</h6>
                            <p> To the extent permitted by law, you agree to protect, indemnify, defend and hold
                                harmless the Establishment, Lotus Estate, LLC dba Catamount Consulting
                                and the owner of the Establishment, and each of their respective employees and agents
                                against all claims, losses or damages to persons or property, governmental charges or
                                fines,
                                and costs including reasonable attorneys' fees arising out of or connected with the
                                provision of goods and services and your group's use of Establishment's premises
                                hereunder and your
                                provision of services except to the extent that such claims arise out of the negligence
                                or willful misconduct of the Establishment, or its employees or agents acting within the
                                scope
                                of their authority. You further agree to obtain and keep in force General Liability
                                Insurance covering your contractual obligations hereunder with limits of not less than
                                $1,000,000 per
                                occurrence and provide the Establishment with proof of insurance with Establishment
                                named as additional insured and a certificate holder. The Establishment reserves the
                                right to require
                                client to provide security services for the Training at client cost. </p>


                            <h6 class="headings">RESPONSIBILITY AND SECURITY</h6>
                            <p class="text">
                                Catamount Consulting does not accept any responsibility for damage to or loss of any articles
                                or property left at Catamount Consulting prior to, during, or after the Training.
                                The Customer(s) agrees to be responsible for any damage done to Catamount Consulting Complex by
                                the Customer(s), his or her guests, invitees, employees, or other agents under the
                                Customer(s)
                                control. Further, Catamount Consulting shall not be liable for any loss, damage or injury of
                                any kind or character to any person or property caused by or arising from an act or
                                omission of the
                                Customer(s), or any of his or her guests, invitees, employees or other agents from any
                                accident or casualty occasioned by the failure of the Customer(s) to maintain the
                                premises in a
                                safe condition or arising from any other cause, The Customer(s), as a material part of
                                the consideration of this agreement, hereby waives on its behalf all claims and demands
                                against
                                Catamount Consulting for any such loss, damage, or injury of claims and demands against The
                                Bond 1786 for any such loss, damage, or injury of the Customer(s), and hereby agrees to
                                indemnify
                                and hold Catamount Consulting free and harmless from all liability of any such loss, damage or
                                injury to his or her persons, and from all costs and expenses arising there from,
                                including but
                                not limited to attorney fees. </p>

                            <h6 class="headings">EXCUSE OF PERFORMANCE (Force Majeure) </h6>
                            <p class="text">The performance of this agreement by Catamount Consulting is subject to acts of
                                God, war, government regulations or advisory, disaster, fire, accident, or other
                                casualty,
                                strikes or threats of strikes, labor disputes, civil disorder, acts and/or threats of
                                terrorism, or curtailment of transportation services or facilities, or similar cause
                                beyond the control of The Bond. Should the Training be cancelled through a Force Majeure
                                Training, all fees paid by Customer to Catamount Consulting will be returned to Customer within
                                thirty (30) days or Catamount Consulting will allow for the Training to be rescheduled, pending
                                availability, with no penalty, and there shall be no further liability between the
                                parties. </p>

                            <h6 class="headings">SEVERABILITY</h6>
                            <p class="text">If any provisions of this Agreement shall be held to be invalid or
                                unenforceable for any reason, the remaining provisions shall continue to be valid and
                                enforceable.
                                If a court finds that any provision of this Agreement is invalid or unenforceable, but
                                that by limiting such provision it would become valid and enforceable, then such
                                provision
                                shall be deemed to be written, construed, and enforced as so limited. </p>

                            <h6 class="headings">INSURANCE</h6>
                            <p class="text">Catamount Consulting shall carry liability and other insurance in such dollar
                                amount as deemed necessary by Catamount Consulting to protect itself against any claims arising
                                from any
                                officially scheduled activities during the Training/program period(s). Any third-party
                                suppliers/vendors used or contracted by Customer shall carry liability and other
                                necessary
                                insurance in the amount of no less than One Million Dollars ($1,000,000) to protect
                                itself against any claims arising from any officially scheduled activities during the
                                Training/program period(s); and to indemnify Catamount Consulting which shall be named as an
                                additional insured for the duration of this Contract. </p>



                            <h6 class="headings">CONDITIONS of USE</h6>
                            <p class="text">Renter’s activities during the Rental Period must be compatible with use of
                                the building/grounds and activities in areas adjacent to the Rental Space and building.
                                This includes but is not limited to playing loud music or making any noise at a level
                                that is not reasonable under the circumstances. Smoking is not permitted anywhere in the
                                buildings. The Rental Space must be cleaned and returned in a condition at the end of an
                                Training to a reasonable appearance as it was prior to the rental. Customer is responsible
                                for the removal of all decorations and trash from the property or placed in a dumpster
                                provided on site. </p>

                            <h6 class="headings">RESERVATION OF RIGHTS</h6>
                            <p class="text">Catamount Consulting reserves the right to cancel agreements for non-payment or for
                                non-compliance with any of the Rules and Conditions of Usage set forth in the Agreement.
                                The rights of Catamount Consulting as set-forth in this Agreement are in addition to any rights
                                or remedies which may be available to Catamount Consulting at law or equity.
                            </p>
                            <h6 class="headings">JURISDICTION & ATTORNEY’S FEES</h6>
                            <p class="text">The Parties agree that this Agreement will be governed by the laws of the
                                County of Warren in the State of New York. The Parties consent to the exclusive
                                jurisdiction of
                                and Location in Warren County, New York and the parties expressly consent to personal
                                jurisdiction and Location in said Court. The parties agree that in the Training of a breach of
                                this
                                Agreement or any dispute arises in any way relating to this Agreement, the prevailing
                                party in any arbitration or court proceeding will be entitled to recover an award of its
                                reasonable attorney’s fees, costs and pre and post judgment interest.</p>
                            <h6 class="headings">RULES AND CONTIONS FOR USAGE</h6>

                            <h6 class="headings">CANDLES:</h6>
                            <p>The use of any type of flame is prohibited in all buildings and throughout the site. The
                                new “flameless candles” which are battery operated are permitted
                                for use. </p>

                            <h6>CHILDREN:</h6>
                            <p> There have been times we have had guests at the complex whose children were not properly
                                supervised. Children under the age of 18 are your complete responsibility.
                                Please know where your children are always and make certain that they clearly understand
                                The Rules (They are not permitted near the pond). </p>

                            <h6 class="headings">CONTACT PERSON:</h6>
                            <p> You must designate one individual as your Contact Person. This must not be someone
                                heavily involved in the activities of the day, as they will be too
                                busy to effectively communicate with our on-site coordinator should
                                problems/concerns/questions. (When questions arise, do not designate any member of your
                                bridal party,
                                photographer, caterer, florist, or musician as your liaison). </p>

                            <h6 class="headings">DELIVERIES / DELIVERY TRUCKS:</h6>
                            <p>There is a size limit to the height and length of vehicles entering the complex due to
                                the damage inflicted to our trees.
                                Please coordinate limits with us. We will need to know the delivery dates and times of
                                any rentals, so we can meet them and show them where to drop their rentals. </p>

                            <h6 class="headings">DECORATIONS:</h6>
                            <p>Only pushpins and drafting tape may be used to affix decorations and/or signs. Any other
                                decorations, signage, electrical configurations, or
                                construction must be pre-approved by The Bond. Decorations may not be hung from light
                                fixtures. All decorations must be removed without leaving damages directly
                                following the departure of the last guest unless special arrangements have been made
                                between the Customer(s) and the Location.
                                ALL DECORATIONS MUST BE APPROVED BY Catamount Consulting. The Customer is responsible for all
                                damages to Catamount Consulting Locations and surround site. It is the Customer’s responsibility
                                to
                                remove all decorations and return Location to the condition in which it was received. </p>

                            <h6 class="headings">TRAINING ENDING TIME:</h6>
                            <p> All Trainings must end by 11:00 PM to comply with Township/County sound ordinances and to
                                allow for clean-up and closure of the site by 1:00 AM. </p>

                            <h6 class="headings">GARBAGE DISPOSAL:</h6>
                            <p>Trash disposal, other than the garbage disposal of items generated by the caterer, is
                                your responsibility. Immediately following the Training,
                                please have your Clean-up Committee take a few minutes to walk all the areas of the
                                building and property that have been utilized for the Training and pick-up any refuse that
                                may
                                have been dropped or blown around. This trash may be placed into Catamount Consulting
                                dumpsters. Customer shall be responsible for returning the Location (and site if
                                applicable) to the
                                condition in which it was provided to them. All property belonging to Customer,
                                Customer’s invitees, guests, agents, and sub-contractors, shall be removed by the end of
                                the
                                rental period. All property remaining on the premises beyond the end of the rental
                                agreement will be removed by Catamount Consulting at The Customers cost. Should the Customer
                                need special consideration for the removal of property beyond the rental period, this
                                can be arranged prior to the beginning of the Training for an additional fee.
                                Catamount Consulting is not responsible for any property left behind by Customer, Customer’s
                                guests, invitees, agents, and sub-contractors. </p>

                            <h6 class="headings">GUESTS:</h6>
                            <p>Please keep in mind when inviting Guests to your Training, that you are inviting them to our
                                home. We will expect visitors to conduct themselves in a mature,
                                responsible, and respectful manner. </p>

                            <h6 class="headings">HAIR & MAKE-UP</h6>
                            <p class="text">The Customer may provide their own Hair and Make-up staff. That staff will
                                be provided an adequate space with outlets to carry out their role. This designated
                                space will be at
                                the discretion of The Bond unless prior arrangements have been and approved by The Bond.
                            </p>

                            <h6>HANDICAP ACCOMMODTIONS:</h6>
                            <p>We provide level-designated parking, ramped walkways throughout the property along with
                                suitable restroom facilities. Motorized and transport
                                chairs can easily navigate the grounds. All Locations on the property are handicapped
                                accessible. </p>

                            <h6 class="headings">MUSIC AND ENTERTAINMENT:</h6> Although music (both live and recorded)
                            is permitted, the music must be contained at an acceptable sound level so as not to disturb
                            the local surrounding area. Catamount Consulting Training coordinator will help to establish
                            acceptable sound levels. Any complaints from neighbors or other parties may require the
                            levels to be reduced further. Catamount Consulting reserves the right to require Customer(s) to
                            cease the music it deems inappropriate, in its sole discretion. Catamount Consulting also reserves
                            the right to require the Customer(s) to lower the sound level or cease playing music, in its
                            sole discretion.

                            <h6 class="headings">PARKING:</h6> Parking is available at the designated areas on the East
                            side of the complex (gravel and grass areas). Persons shall pull into the cables that
                            identify parking locations. Handicap accessible parking spaces are provided at the posted
                            areas adjacent to the sidewalks. Parking is not permitted on the main street (Hudson Street)
                            or any access drive to a Location building. Establishment parking space for Establishment’s
                            guests takes priority. Parking for Training guest is based on availability, but plenty of
                            alternative parking spaces are available. The Establishment is not responsible for any
                            damages, theft, or towing. Any special Parking space requirements must be approved by the
                            Establishment Staff prior to your Training, applicable parking charges may apply.

                            <h6 class="headings">PETS:</h6> Sorry, absolutely no pets allowed. However, a family pet
                            involved in an Training will be considered.

                            <h6 class="headings">PHOTOGRAPHY:</h6> The many natural settings around Catamount Consulting were
                            maintained and developed for the enjoyment of all Trainings. We reserve the right for each
                            Customer the opportunity to use any area of the complex for wedding/reception photograph
                            sessions. All times for utilization of different areas at Catamount Consulting will be coordinated
                            with the schedule for each Location Customer. We also reserve the right to use any
                            photographs or other media reproductions of an Training in our publicity and advertising
                            materials.

                            <h6 class="headings">RENTAL SPACE CHANGES:</h6> Any contents or furniture movement must be
                            pre-approved by The Bond. It is the Customer’s responsibility to restore all areas to their
                            original appearance. Placements of tables, tents, live music, catering equipment, etc., must
                            also be approved by Catamount Consultingplanning staff.

                            <h6 class="headings">SIGNAGE:</h6> You may post your group’s sign or hang balloons at the
                            front entrance on Hudson Street, but please do NOT attach anything to or cover up our
                            entrance sign, or nail or screw anything to the trees.

                            <h6 class="headings">SMOKING: </h6> Catamount Consultingis a non-smoking facility. Ash-buckets will
                            be provided, and smoking permitted in the designated areas only.

                            <h6 class="headings">CATERING:</h6> The catering service areas in each of the Locations are not
                            intended to be used as a kitchen for meal preparation.

                            <h6 class="headings">WEATHER:</h6> The weather is usually suitable for outside Trainings from
                            May 15 until October 15. Since most of our Locations are booked-up for Trainings in advance,
                            please be advised that unless you reserve the Main Building or the Wedding Tent or one of
                            the other Locations at the time you schedule the main reception hall, we may not have any
                            additional indoor facilities available to serve as a “weather back-up plan”. Should there be
                            inclement weather on your reserved day, we will approve your last-minute rental of tents,
                            canopies, or heaters, provided they are set-up at an acceptable location.

                            <h6 class="headings">WEDDING TENT / ARBOR:</h6> The Gazebo and Arbors may be used as wedding
                            sites and for pictures (Chairs required for a wedding ceremony are to be provided and set-up
                            by Catamount Consulting based on the standard rental policy). If the Location has already been rented
                            as a Location for a different group, then special permission must be granted to utilize the
                            Tent for another party’s ceremony. Pictures are permitted to be taken at the Gazebos and
                            Arbor sites by all parties but shall be coordinated for use between all site Locations.

                            <h6 class="headings">WEDDING CEREMONIES:</h6> Wedding ceremonies may be held in the
                            Reception Location for no additional charge. Additional fees may apply for reset of room from
                            ceremony to reception. Customer is responsible for providing ceremony coordinator,
                            officiate, ceremony music and sound system.

                            <h6 class="headings">WEDDING REHEARSAL:</h6> In order to not conflict with other Location
                            rentals, rehearsals are planned for Thursday evenings (unless a different date is approved).
                            The complex must be vacated after completing the rehearsal program. The main Training halls
                            will not be available to decorate after the rehearsal. Alternative dates for Rehearsals may
                            be held on-site. These date and times are to be coordinated with and approved by The Training
                            Coordinator at Catamount Consulting.

                            <h6 class="headings">LOGISTICAL PLANS:</h6> Catamount Consulting planning team must review and
                            approve all proposed logistical plans for the use of the premises a minimum of thirty (30)
                            days prior to an Training.
                            <h6 class="headings">TRAININGS & WEDDING POLICY AND GUIDELINES AGREEMENT </h6>

                            I have read and understand the policies concerning Trainings held at Catamount Consulting. I agree to
                            uphold them and ensure that contractors and members of the Training party,
                            will abide by the policies. I understand it is my responsibility to inform the coordinator,
                            florist, photographers, etc., that they must also conform to this set of guidelines. <br>

                            Please note that all prices are subject to 20% Service Charge and NYS 7.0% Sales Tax

                            <h6 class="headings">RESERVATION PROCESS</h6>
                            <p class="text">
                                A rental contract must be signed, all pages initialed, as well as appropriate deposits
                                submitted to confirm utilization of a Catamount Consulting Location. <br><br>

                                A valid Credit Card is required to be on file for all Trainings to guarantee payment of
                                expenses in connection with this Agreement. Customer agrees
                                that any outstanding balance not received by the day of the Training will be charged to the
                                Credit Card on file. A Current Credit Card must be always communicated.
                                No Personal Checks are accepted for final payment. <br><br>
                                The Rules and Conditions for Usage are incorporated herein and are made a part hereof.
                                <br><br>

                                Please return signed contract with deposit no later than
                                <b>{{ \Carbon\Carbon::parse($meeting->start_date)->subDays($settings['buffer_day'])->format('d M, Y') }}</b>
                                or this contract is no longer valid.<br>
                            </p>--}}

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="comments" class="form-label">Comments</label>
                            <textarea name="comments" id="comments" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                    {{--<div class="row mt-3">
                        <div class="col-md-6">
                            <strong>Authorized Signature:</strong> <br>
                            <img src="{{$base64Image}}" style="width:30%; border-bottom:1px solid black;">
                        </div>
                        <div class="col-md-6">
                            <strong> Signature:</strong>
                            <br>
                            <div id="sig" class="mt-3">
                                <canvas id="signatureCanvas" width="500" class="signature-canvas"></canvas>
                                <input type="hidden" name="imageData" id="imageData">
                            </div>
                            <button type="button" id="clearButton" class="btn btn-danger btn-sm mt-1">Clear
                                Signature</button>
                            <!-- <button id="clearButton" class="btn btn-danger btn-sm mt-1">Clear Signature</button> -->
                        </div>
                    </div>--}}
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <button class="btn btn-success mt-1" style="float:right">Submit</button>
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
        width: 100%;
        /* height: 157px; */
        border-radius: 8px;
    }

    .row {
        --bs-gutter-x: -11.5rem !important;
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