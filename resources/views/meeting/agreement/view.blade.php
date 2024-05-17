@php
$imagePath = public_path('upload/signature/autorised_signature.png');
$imageData = base64_encode(file_get_contents($imagePath));
$base64Image = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . $imageData;
if($agreement && ($agreement['signature'] != null)){
$signed = base64_encode(file_get_contents($agreement['signature']));
$sign = 'data:image/' . pathinfo($agreement['signature'], PATHINFO_EXTENSION) . ';base64,' . $signed;
}

$bar_pck = json_decode($meeting['bar_package'], true);
$total =[];
$startdate = \Carbon\Carbon::createFromFormat('Y-m-d', $meeting['start_date'])->format('d/m/Y');
$enddate = \Carbon\Carbon::createFromFormat('Y-m-d', $meeting['end_date'])->format('d/m/Y');
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agreement</title>
    <style>
        table {
            width: 100%;
            margin: 0 auto;
        }

        td,
        td,
        tr,
        th {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-md-12" style=" display:flex;justify-content:center; margin:0 auto; width:50%;font-size:12px;margin-bottom:15px;">
            <span style="text-align:left;font-size:14px;margin-bottom:10px;color:black;">The Bond 1786</span><br>
            <span style="text-align:left;font-size:14px;margin-bottom:10px;color:black;">Venue Rental Agreement & Banquet Event Order</span>
        </div>
    </div>
    <div class="row" style="display:flex; border:1px solid black;padding:2px 0px 10px;">
        <div class="col-md-6" style="text-align:left; margin-left:10px;">
            <dl>
                <span style="font-size:14px;margin-bottom:10px;color:black;">{{__('Name')}}: {{ $meeting['name'] }}</span><br>
                <span style="font-size:14px;margin-bottom:10px;color:black;">{{__('Phone & Email')}}: {{ $meeting['phone'] }} , {{ $meeting['email'] }}</span><br>
                <span style="font-size:14px;margin-bottom:10px;color:black;">{{__('Address')}}: {{ $meeting['lead_address'] }}</span><br>
                <span style="font-size:14px;margin-bottom:10px;color:black;">{{__('Event Date')}}: {{ $startdate }}</span>
            </dl>
        </div>
        <div class="col-md-6" style="text-align:right; margin-top:-9rem;margin-right:20px;">
            <dl class="text-align:left;">
                <span style="font-size:14px;color:black;margin-bottom:10px;padding-right:15px;padding:5px 10px;">{{__('Primary Contact')}}: {{ $meeting['name'] }}</span><br>
                <span style="font-size:14px;color:black;margin-bottom:10px;padding-right:15px;padding:5px 5px;">{{__('Phone')}}: {{ $meeting['phone'] }}</span><br>
                <span style="font-size:14px;color:black;margin-bottom:10px;padding-right:15px;padding:5px 5px;">{{__('Email')}}: {{ $meeting['email'] }}</span><br>
            </dl>
        </div>
    </div>
    <div class="row" style="display:flex;margin-bottom:10px;margin-bottom:10px;margin-bottom:20px; ">
        <div class="col-md-6" style="margin-left:10px;padding:2px 0px 20px;">
            <dl>
                <span style="font-size:14px;margin-bottom:10px;color:black;">{{__('Deposit')}}:</span><br>
                <span style="font-size:14px;margin-bottom:10px;margin-bottom:20px;margin-bottom:20px;padding-top:10px;color:black;padding-bottom:0px;">{{__('Billing Method')}}:</span>
            </dl>
        </div>
        <div class="col-md-6" style="text-align:right;margin-top:-5rem;margin-right:10px;">
            <dl>
                <span style="font-size:14px;margin-bottom:10px;padding-right:15px;color:black;">{{__('Catering Service')}}: NA</span><br>
            </dl>
        </div>
    </div>
    <table border="1">
        <thead>
            <tr>
                <th style="background-color:#d3ead3;font-size:13px;font-weight:300;padding:5px 10px;">Event Date</th>
                <th style="background-color:#d3ead3;font-size:13px;font-weight:300;padding:5px 10px;">Time</th>
                <th style="background-color:#d3ead3;font-size:13px;font-weight:300;padding:5px 10px;">Venue</th>
                <th style="background-color:#d3ead3;font-size:13px;font-weight:300;padding:5px 10px;">Event</th>
                <th style="background-color:#d3ead3;font-size:13px;font-weight:300;padding:5px 10px;">Function</th>
                <th style="background-color:#d3ead3;font-size:13px;font-weight:300;padding:5px 10px;">Room</th>
                <th style="background-color:#d3ead3;font-size:13px;font-weight:300;padding:5px 10px;">Exp</th>
                <th style="background-color:#d3ead3;font-size:13px;font-weight:300;padding:5px 10px;">GTD</th>
                <th style="background-color:#d3ead3;font-size:13px;font-weight:300;padding:5px 10px;">Set</th>
                <th style="background-color:#d3ead3;font-size:13px;font-weight:300;padding:5px 10px;">RENTAL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-size:13px;font-weight:300;padding:8px 10px;">Start Date: {{$startdate}} <br>
                <td style="font-size:13px;font-weight:300;padding:8px 10px;">Start Time:{{date('h:i A', strtotime($meeting['start_time']))}} <br>
                    End time:{{date('h:i A', strtotime($meeting['end_time']))}}</td>
                <td style="font-size:13px;font-weight:300;padding:8px 10px;">{{$meeting['venue_selection']}}</td>
                <td style="font-size:13px;font-weight:300;padding:8px 10px;">{{$meeting['type']}}</td>
                <td style="font-size:13px;font-weight:300;padding:8px 10px;">{{$meeting['function']}}</td>
                <td style="font-size:13px;font-weight:300;padding:8px 10px;">{{$meeting['room']}}</td>
                <td style="font-size:13px;font-weight:300;padding:8px 10px;">Exp</td>
                <td style="font-size:13px;font-weight:300;padding:8px 10px;">GTD</td>
                <td style="font-size:13px;font-weight:300;padding:8px 10px;">Set</td>
                <td style="font-size:13px;font-weight:300;padding:8px 10px;">RENTAL</td>
            </tr>

        </tbody>
    </table>
    
    <div class="row" style="margin-top:20px;padding-top:10px;">
        <div class="col-md-12">
            <p>This contract defines the terms and conditions under which Lotus Estate, LLC dba The Bond 1786, (hereinafter referred to as The Bond or The
                Bond 1786), and <b>{{$meeting['name']}}</b>(hereafter referred to as the Customer) agree to the Customer’s use of The Bond 1786 facilities on <b>{{$startdate}}</b>
                (reception/event date). This contract constitutes the entire agreement between the parties and becomes binding upon the signature of
                both parties. The contract may not be amended or changed unless executed in writing and signed by The Bond 1786 and the Customer.
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h4>Venue Selected</h4>
            <p>{{$meeting['venue_selection']}}</p><br><br>
            <p>
                The venue/s described above has been reserved for you for the date and time stipulated. Please note that the hours assigned to your event include all set-up and
                all clean-up, including the set-up and clean-up of all subcontractors that you may utilize. It is understood you will adhere to and follow the terms of this Agreement,
                and you will be responsible for any damage to the premises and site, including the behavior of your guests, invitees, agents, or sub-contractors resulting from your
                use of venue/s.
            </p>
            <h4>Rental Deposit and Payment Agreement</h4>
            <p>
                The total cost for use of The Bond 1786 and its facilities described in this contract is listed above. To reserve services on the
                date/s requested, The Bond 1786 requires this contract be signed by Customer and an <b> initial payment of $3,000</b> be deposited.
                The balance is due prior to the event date. Deposits and payments will be made at the time of signing of the Contract. Payments
                can be made by cash, Bank checks (made payable to <b>The Bond 1786</b>), on the schedule noted below. A receipt from The Bond
                1786 will be provided for each.
            </p>
            <h4>Billing Summary -Estimate</h4>
            <table>
                <thead>
                    <tr>
                        <th style="text-align:left; font-size:13px;text-align:left; padding:5px 5px; margin-left:5px;">Name : {{$meeting['name']}}</th>
                        <th colspan="2" style="padding:5px 0px;margin-left :5px;font-size:13px"></th>
                        <th colspan="3" style="text-align:left;text-align:left; padding:5px 5px; margin-left:5px;">Date:<?php echo date("d/m/Y"); ?> </th>
                        <th style="text-align:left; font-size:13px;padding:5px 5px; margin-left:5px;">Event: {{$meeting['type']}}</th>
                    </tr>
                    <tr style="background-color:#063806;">
                        <th style="color:#ffffff; font-size:13px;text-align:left; padding:5px 5px; margin-left:5px;">Description</th>
                        <th colspan="2" style="color:#ffffff; font-size:13px;padding:5px 5px; margin-left:5px;">Additional</th>
                        <th style="color:#ffffff; font-size:13px;padding:5px 5px;margin-left: 5px;font-size:13px">Cost</th>
                        <th style="color:#ffffff; font-size:13px;padding:5px 5px;margin-left: 5px;font-size:13px">Quantity</th>
                        <th style="color:#ffffff; font-size:13px;padding:5px 5px;margin-left :5px;font-size:13px">Total Price</th>
                        <th style="color:#ffffff; font-size:13px;padding:5px 5px;margin-left :5px;font-size:13px">Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Venue Rental</td>
                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>

                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">${{$billing_data['venue_rental']['cost']}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">{{$billing_data['venue_rental']['quantity']}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">${{$total[] = $billing_data['venue_rental']['cost'] * $billing_data['venue_rental']['quantity']}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">{{$meeting['venue_selection']}}</td>
                    </tr>

                    <tr>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Brunch / Lunch / Dinner Package</td>
                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;"> ${{$billing_data['food_package']['cost']}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">{{$billing_data['food_package']['quantity']}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">${{$total[] =$billing_data['food_package']['cost'] * $billing_data['food_package']['quantity']}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">{{$meeting['function']}}</td>

                    </tr>
                    <tr>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Bar Package</td>
                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">${{$billing_data['bar_package']['cost']}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">{{$billing_data['bar_package']['quantity']}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">${{$total[] = $billing_data['bar_package']['cost']* $billing_data['bar_package']['quantity']}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">{{implode(',',$bar_pck)}}</td>
                    </tr>
                    <tr>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Hotel Rooms</td>
                        <td colspan="2" style="padding:5px 5px; margin-left:5px;"></td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">${{$billing_data['hotel_rooms']['cost']}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">{{$billing_data['hotel_rooms']['quantity']}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">${{$total[] = $billing_data['hotel_rooms']['cost'] * $billing_data['hotel_rooms']['quantity']}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    </tr>
                    <tr>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Tent, Tables, Chairs, AV Equipment</td>
                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">${{$billing_data['equipment']['cost']}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">{{$billing_data['equipment']['quantity']}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">${{$total[] = $billing_data['equipment']['cost'] * $billing_data['equipment']['quantity']}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    </tr>

                    @if(!$billing_data['setup']['cost'] == '')
                    <tr>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Welcome / Rehearsal / Special Setup</td>
                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px"></td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">${{$billing_data['setup']['cost']}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">{{$billing_data['setup']['quantity']}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">${{$total[] =$billing_data['setup']['cost'] * $billing_data['setup']['quantity']}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    </tr>
                    @endif
                    <tr>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Special Requests / Others</td>
                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">${{$billing_data['additional_items']['cost']}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">{{$billing_data['additional_items']['quantity']}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">${{$total[] =$billing_data['additional_items']['cost'] * $billing_data['additional_items']['quantity']}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>

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
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">${{array_sum($total)}}</td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    </tr>
                    <tr>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Sales, Occupancy Tax</td>
                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"> </td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">${{ 7* array_sum($total)/100 }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align:left;text-align:left; padding:5px 5px; margin-left:5px;font-size:13px;">Service Charges & Gratuity</td>
                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">${{ 20 * array_sum($total)/100 }}</td>

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
                        <td style="background-color:#ffff00; padding:5px 5px; margin-left:5px;font-size:13px;">Grand Total / Estimated Total</td>
                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                        <td style="padding:5px 5px; margin-left:5px;font-size:13px;">${{$grandtotal= array_sum($total) + 20* array_sum($total)/100 + 7* array_sum($total)/100}}</td>

                        <td></td>
                    </tr>
                    <tr>
                        <td style="background-color:#d7e7d7; padding:5px 5px; margin-left:5px;font-size:13px;">Deposits on file</td>
                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                        <td colspan="2" style="background-color:#d7e7d7;padding:5px 5px; margin-left:5px;font-size:13px;">${{$deposit= $billing->deposits}}</td>
                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    </tr>
                    <tr>
                        <td style="background-color:#ffff00;text-align:left; padding:5px 5px; margin-left:5px;font-size:13px;">balance due</td>
                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                        <td colspan="3" style="padding:5px 5px; margin-left:5px;font-size:13px;background-color:#9fdb9f;">${{$grandtotal - $deposit}}</td>
                        <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    </tr>
                </tbody>


            </table>
            <h3 style="text-align:center">TERMS AND CONDITIONS</h3>
            <h4>FOOD AND ALCOHOLIC BEVERAGES and 3RD PARTY / ON-SITE VENDORS</h4>
            <p>
                The Client and their guests agree to not bring in any unauthorized food or beverage into The Bond 1786. The Establishment does not allow outside alcoholic beverages, unless agreed with the Terms. Catering service is available at a cost; please see your
                Coordinator for menu selections. The Coordinator / Owner reserves the right to approve all vendors providing services to the event to include food,
                audio/visual, and merchandise.
            </p>
            <p>It is understood and agreed that the Customer may serve beverages containing alcohol (including but not limit to beer, wine, champagne, mixed drinks
                with liquor, etc., by way of example) hereinafter call “Alcohol”, upon the following terms and conditions:
            </p>
            <ul>
                <li> A copy of Liquor License/Permit must be on records at the Establishment before any alcohol can be served at your event, by a 3 rd Party Vendor.</li>
                <li>A food waiver must be on file for all outside food brought to the Establishment.</li>
                <li>Under NO circumstances shall Client(s) sell or attempt to sell any Alcohol to anyone.</li>
                <li>Customer shall not permit any person under the age of twenty-one (21) to consume alcohol regardless of whether the person is accompanied by a parent or guardian.</li>
                <li>Customer hereby agrees to use their best efforts to ensure that Alcohol will not be served to anyone who is intoxicated or appears to be intoxicated.</li>
                <li>Customer hereby expressly grants to The Bond 1786, at The Bond’s sole discretion and option, to instruct the security officer(s) to remove any person(s) from the Venue, if in the opinion of The Bond 1786 representative in charge, the licensed
                    and bonded Bartender and/or the security officer(s) the person(s) is intoxicated, unruly or could present a danger to themselves or others, and/or the Venue.</li>
                <li>Customer hereby agrees to be liable and responsible for all act(s) and actions of every kind and nature for each person in attendance at Customer’s function or event.</li>
                <li>Caterers: No caterer can be used without prior approval of The Bond 1786. Each caterer approved should be familiar with The Bond 1786 venues, rules, and regulations.</li>
                <li>Each one of these caterers will have to carry required liability insurance for The Bond.</li>
                <li>If Customer requests a different food service company, they must be pre-approved by The Bond 1786 and meet their rules and regulations.</li>
                <li>Your catering company is responsible for the set-up, break-down and clean-up of the catered site. Please allow appropriate time for break-down and clean-up to meet the contracted timelines.</li>
                <li>All event trash must be disposed of in the designated areas at the conclusion of the event.</li>
                <li>ALL vendors must adhere to the terms of our guidelines, and it is the Customer’s responsibility to share these guidelines with them.</li>
                <li>Usage of cooking equipment such as fryers are allowed, with proper safety precautions, DOH certifications and requirements fully satisfied. The areas these can be used should be pre-evaluated and approved, along with the provisions for oil
                    disposal.</li>
                <li>All food brought into the Establishment must be prepared and ready for reheat with chafing dish and sterno / Gas fuel.</li>
                <li>Food and beverage must be contained in your contracted event space only and should not be brought into the lobby or other Establishment public space.</li>
            </ul>
            <h4>CANCELLATION POLICY & DATE CHANGES:</h4>
            <p><b>Small & Private Events -</b> A written cancellation request must be received by The Bond sales office no later than 30 days prior to contracted event date to avoid
                forfeit of deposit or payment toward expected revenue. Cancellations received after this time will incur a charge in the amount of the contracted revenue.
                100% of expected revenue is not refundable if cancellation is made between 1-29 days prior to event date. Company or individual contracting the event will be
                assessed this charge through either a deduction from the prepayment or charge credit card on file, whichever applies. If cash payment, you will be invoiced for
                any cancellation fees. Events that are booked within the 29-day period cannot be cancelled and are non-refundable, unless agreed upon and approved during the
                booking of the Event.</p>

            <b>Large Events & Weddings -</b>
            <p>
                1. Changes: In the unlikely event the Customer is required to change the date of the event or Wedding, every effort will be made by The Bond 1786 to transfer reservations to support the new date. The Customer agrees that in the event of a date change, any expenses including, but not limited to, deposits, and fees that are non-refundable, and non-transferable are the sole responsibility of Customer. The Customer further understands that last minute changes can impact the quality of the event, and that The Bond 1786 is not responsible for these compromises in quality.

                2. Cancellation: In the event customer cancels the event, customer shall notify The Bond 1786 immediately in writing or by email. Once cancelled, the Customer shall be responsible for agreed liquidated damages as follows. The parties agree that the liquidated damages are reasonable.
            </p>
            <ul>
                <li> In the event Customer cancels the event more than one year prior to the event, Customer shall forfeit to The Bond 1786 as liquidated damages one-half (1/2) of deposit.</li>
                <li>In the event customer cancels the event less than one year but not more than six months prior to the event, Customer shall forfeit to The Bond 1786 as liquidated damages the entire deposit. </li>
                <li> In the event Customer cancels the event less than six (6) months but more than three (3) months prior to the event, Customer shall forfeit to The Bond 1786 as liquidated damages fifty percent (50 %) of the rental fee. </li>
                <li> In the event customer cancels the event less than three (3) months prior to the event, Customer shall forfeit to The Bond 1786 as liquidated damages the entire rental fee. </li>
            </ul>
            <h4> GUARANTEE NUMBER OF GUESTS: </h4>
            <p>The (GTD) guaranteed count will be the assumed as the minimum billable count, however the final guaranteed number of guests is due (7) seven working days prior to
                the start of your event. Should the final guarantee not be received (7) seven working days prior to the above event(s), the basis for the final billing calculation will
                be the above contracted GTD (guaranteed) number of guests, or the actual number of guests attending the event, whichever is higher. </p>

            <h4>SET-UP & EVENT SET-UP LIMITATIONS:</h4>
            <p>Any space / room set up changes made on the day of the event will be charged a $500 fee. Additional time required above
                the contracted time will be charged a $250 per hour fee. Client may bring their own linen, decorations, and equipment but must be approved by the Coordinator / Owner first.
                Upgrade tablecloth, chair cover, audio-visual is available at a cost; please see your Coordinator for options. Usage of other event space or Establishment public space must
                be under contract or usage is chargeable and must be approved by the Coordinator / Owner. </p>
            <ul>
                <li>All property belonging to Customer, Customer’s invitees, guests, agents and sub-contractors, and all equipment shall be delivered, set-up and removed on the day of the event.
                    Should the Customer need earlier access for set-up purposes, this can be arranged for an additional fee. The Customer is ultimately responsible for property belonging to the
                    Customer’s invitees, guests, agents, and sub-contractors.
                </li>
                <li>Rental items must be scheduled for pick-up no later than within 24 hours of the conclusion of the Event.</li>
                <li>Alcohol service must stop no later than 11:00 PM (or maximum of 5-hours if occurring sooner).</li>
                <li>Music (DJ or live music) must stop no later than 11:00 PM</li>
                <li>All guests must be off The Bond 1786 premises no later than midnight the day of the event (except clean-up crew, with all clean-ups to be done by 1:00 am).</li>
            </ul>
            <h4>FINAL PAYMENT & PAYMENT POLICY:</h4>
            <p> 100% of expected / outstanding balance payment is due 14 days prior to event date. The Establishment will terminate the contract
                if payment is not received by contracted due date. If deposit or full payment is not received as required by contracted date, the contract will be canceled. For check payment
                please send payment to: The Bond 1786, (3, Hudson Street, Warrensburg, NY 12885). Rooms must be paid for before entry is granted unless alternative payment arrangements have been
                pre-established for event payment. </p>

            <h4>DAMAGES:</h4>
            <p> The individual signing this agreement will be responsible for damage to or loss of revenue by the Establishment due to activities of the guests under this contract,
                including but not limited to the building, Establishment equipment, decorations, fixtures, furniture, and refunds due to the negligence of your guests. The deposit which is typically
                applied towards the total bills of the organized event, however in case of settlement of damages, the deposit may be applied towards the total damages, including the use of the Credit
                Card on file, should there be a remaining balance due to The Bond 1786. </p>

            <h4>COMPLIANCE WITH LAWS:</h4>
            <p>You will comply with all applicable local and national laws, codes, regulations, ordinances, and rules with respect to your obligations under
                this Agreement and the services to be provided by you hereunder, including but not limited to any laws and regulations governing event organizers. You represent, warrant, and agree
                that you, are currently, and will continue to be for the term of this Agreement, in compliance with all applicable local, state, federal regulations or laws. </p>

            <h4>INDEMNIFICATION:</h4>
            <p> To the extent permitted by law, you agree to protect, indemnify, defend and hold harmless the Establishment, Lotus Estate, LLC dba The Bond 1786
                and the owner of the Establishment, and each of their respective employees and agents against all claims, losses or damages to persons or property, governmental charges or fines,
                and costs including reasonable attorneys' fees arising out of or connected with the provision of goods and services and your group's use of Establishment's premises hereunder and your
                provision of services except to the extent that such claims arise out of the negligence or willful misconduct of the Establishment, or its employees or agents acting within the scope
                of their authority. You further agree to obtain and keep in force General Liability Insurance covering your contractual obligations hereunder with limits of not less than $1,000,000 per
                occurrence and provide the Establishment with proof of insurance with Establishment named as additional insured and a certificate holder. The Establishment reserves the right to require
                client to provide security services for the event at client cost. </p>


            <h4>RESPONSIBILITY AND SECURITY</h4>
            <p>
                The Bond 1786 does not accept any responsibility for damage to or loss of any articles or property left at The Bond 1786 prior to, during, or after the event.
                The Customer(s) agrees to be responsible for any damage done to The Bond 1786 Complex by the Customer(s), his or her guests, invitees, employees, or other agents under the Customer(s)
                control. Further, The Bond 1786 shall not be liable for any loss, damage or injury of any kind or character to any person or property caused by or arising from an act or omission of the
                Customer(s), or any of his or her guests, invitees, employees or other agents from any accident or casualty occasioned by the failure of the Customer(s) to maintain the premises in a
                safe condition or arising from any other cause, The Customer(s), as a material part of the consideration of this agreement, hereby waives on its behalf all claims and demands against
                The Bond 1786 for any such loss, damage, or injury of claims and demands against The Bond 1786 for any such loss, damage, or injury of the Customer(s), and hereby agrees to indemnify
                and hold The Bond 1786 free and harmless from all liability of any such loss, damage or injury to his or her persons, and from all costs and expenses arising there from, including but
                not limited to attorney fees. </p>

            <h4>EXCUSE OF PERFORMANCE (Force Majeure) </h4>
            <p>The performance of this agreement by The Bond 1786 is subject to acts of God, war, government regulations or advisory, disaster, fire, accident, or other casualty,
                strikes or threats of strikes, labor disputes, civil disorder, acts and/or threats of terrorism, or curtailment of transportation services or facilities, or similar cause
                beyond the control of The Bond. Should the event be cancelled through a Force Majeure event, all fees paid by Customer to The Bond 1786 will be returned to Customer within
                thirty (30) days or The Bond 1786 will allow for the event to be rescheduled, pending availability, with no penalty, and there shall be no further liability between the parties. </p>

            <h4>SEVERABILITY</h4>
            <p>If any provisions of this Agreement shall be held to be invalid or unenforceable for any reason, the remaining provisions shall continue to be valid and enforceable.
                If a court finds that any provision of this Agreement is invalid or unenforceable, but that by limiting such provision it would become valid and enforceable, then such provision
                shall be deemed to be written, construed, and enforced as so limited. </p>

            <h4>INSURANCE</h4>
            <p>The Bond 1786 shall carry liability and other insurance in such dollar amount as deemed necessary by The Bond 1786 to protect itself against any claims arising from any
                officially scheduled activities during the event/program period(s). Any third-party suppliers/vendors used or contracted by Customer shall carry liability and other necessary
                insurance in the amount of no less than One Million Dollars ($1,000,000) to protect itself against any claims arising from any officially scheduled activities during the
                event/program period(s); and to indemnify The Bond 1786 which shall be named as an additional insured for the duration of this Contract. </p>



            <h4>CONDITIONS of USE</h4>
            <p>Renter’s activities during the Rental Period must be compatible with use of the building/grounds and activities in areas adjacent to the Rental Space and building.
                This includes but is not limited to playing loud music or making any noise at a level that is not reasonable under the circumstances. Smoking is not permitted anywhere in the
                buildings. The Rental Space must be cleaned and returned in a condition at the end of an event to a reasonable appearance as it was prior to the rental. Customer is responsible
                for the removal of all decorations and trash from the property or placed in a dumpster provided on site. </p>

            <h4>RESERVATION OF RIGHTS</h4>
            <p>The Bond 1786 reserves the right to cancel agreements for non-payment or for non-compliance with any of the Rules and Conditions of Usage set forth in the Agreement.
                The rights of The Bond 1786 as set-forth in this Agreement are in addition to any rights or remedies which may be available to The Bond 1786 at law or equity.
            </p>
            <h4>JURISDICTION & ATTORNEY’S FEES</h4>
            <p>The Parties agree that this Agreement will be governed by the laws of the County of Warren in the State of New York. The Parties consent to the exclusive jurisdiction of
                and venue in Warren County, New York and the parties expressly consent to personal jurisdiction and venue in said Court. The parties agree that in the event of a breach of this
                Agreement or any dispute arises in any way relating to this Agreement, the prevailing party in any arbitration or court proceeding will be entitled to recover an award of its
                reasonable attorney’s fees, costs and pre and post judgment interest.</p>
            <h4>RULES AND CONTIONS FOR USAGE</h4>

            <h4>CANDLES:</h4>
            <p>The use of any type of flame is prohibited in all buildings and throughout the site. The new “flameless candles” which are battery operated are permitted
                for use. </p>

            <h4>CHILDREN:</h4>
            <p> There have been times we have had guests at the complex whose children were not properly supervised. Children under the age of 18 are your complete responsibility.
                Please know where your children are always and make certain that they clearly understand The Rules (They are not permitted near the pond). </p>

            <h4>CONTACT PERSON:</h4>
            <p> You must designate one individual as your Contact Person. This must not be someone heavily involved in the activities of the day, as they will be too
                busy to effectively communicate with our on-site coordinator should problems/concerns/questions. (When questions arise, do not designate any member of your bridal party,
                photographer, caterer, florist, or musician as your liaison). </p>

            <h4>DELIVERIES / DELIVERY TRUCKS:</h4>
            <p>There is a size limit to the height and length of vehicles entering the complex due to the damage inflicted to our trees.
                Please coordinate limits with us. We will need to know the delivery dates and times of any rentals, so we can meet them and show them where to drop their rentals. </p>

            <h4>DECORATIONS:</h4>
            <p>Only pushpins and drafting tape may be used to affix decorations and/or signs. Any other decorations, signage, electrical configurations, or
                construction must be pre-approved by The Bond. Decorations may not be hung from light fixtures. All decorations must be removed without leaving damages directly
                following the departure of the last guest unless special arrangements have been made between the Customer(s) and the venue.
                ALL DECORATIONS MUST BE APPROVED BY The Bond 1786. The Customer is responsible for all damages to The Bond 1786 Venues and surround site. It is the Customer’s responsibility to
                remove all decorations and return Venue to the condition in which it was received. </p>

            <h4>EVENT ENDING TIME:</h4>
            <p> All events must end by 11:00 PM to comply with Township/County sound ordinances and to allow for clean-up and closure of the site by 1:00 AM. </p>

            <h4>GARBAGE DISPOSAL:</h4>
            <p>Trash disposal, other than the garbage disposal of items generated by the caterer, is your responsibility. Immediately following the event,
                please have your Clean-up Committee take a few minutes to walk all the areas of the building and property that have been utilized for the event and pick-up any refuse that may
                have been dropped or blown around. This trash may be placed into The Bond 1786 dumpsters. Customer shall be responsible for returning the Venue (and site if applicable) to the
                condition in which it was provided to them. All property belonging to Customer, Customer’s invitees, guests, agents, and sub-contractors, shall be removed by the end of the
                rental period. All property remaining on the premises beyond the end of the rental agreement will be removed by The Bond 1786 at The Customers cost. Should the Customer
                need special consideration for the removal of property beyond the rental period, this can be arranged prior to the beginning of the event for an additional fee.
                The Bond 1786 is not responsible for any property left behind by Customer, Customer’s guests, invitees, agents, and sub-contractors. </p>

            <h4>GUESTS:</h4>
            <p>Please keep in mind when inviting Guests to your event, that you are inviting them to our home. We will expect visitors to conduct themselves in a mature,
                responsible, and respectful manner. </p>

            <h4>HAIR & MAKE-UP</h4>
            <p>The Customer may provide their own Hair and Make-up staff. That staff will be provided an adequate space with outlets to carry out their role. This designated space will be at
                the discretion of The Bond unless prior arrangements have been and approved by The Bond.</p>

            <h4>HANDICAP ACCOMMODTIONS:</h4>
            <p>We provide level-designated parking, ramped walkways throughout the property along with suitable restroom facilities. Motorized and transport
                chairs can easily navigate the grounds. All venues on the property are handicapped accessible. </p>

            <h4>MUSIC AND ENTERTAINMENT:</h4> Although music (both live and recorded) is permitted, the music must be contained at an acceptable sound level so as not to disturb the local surrounding area. The Bond 1786 event coordinator will help to establish acceptable sound levels. Any complaints from neighbors or other parties may require the levels to be reduced further. The Bond 1786 reserves the right to require Customer(s) to cease the music it deems inappropriate, in its sole discretion. The Bond 1786 also reserves the right to require the Customer(s) to lower the sound level or cease playing music, in its sole discretion.

            <h4>PARKING:</h4> Parking is available at the designated areas on the East side of the complex (gravel and grass areas). Persons shall pull into the cables that identify parking locations. Handicap accessible parking spaces are provided at the posted areas adjacent to the sidewalks. Parking is not permitted on the main street (Hudson Street) or any access drive to a venue building. Establishment parking space for Establishment’s guests takes priority. Parking for event guest is based on availability, but plenty of alternative parking spaces are available. The Establishment is not responsible for any damages, theft, or towing. Any special Parking space requirements must be approved by the Establishment Staff prior to your event, applicable parking charges may apply.

            <h4>PETS:</h4> Sorry, absolutely no pets allowed. However, a family pet involved in an event will be considered.

            <h4>PHOTOGRAPHY:</h4> The many natural settings around The Bond 1786 were maintained and developed for the enjoyment of all events. We reserve the right for each Customer the opportunity to use any area of the complex for wedding/reception photograph sessions. All times for utilization of different areas at The Bond 1786 will be coordinated with the schedule for each venue’s Customer. We also reserve the right to use any photographs or other media reproductions of an event in our publicity and advertising materials.

            <h4>RENTAL SPACE CHANGES:</h4> Any contents or furniture movement must be pre-approved by The Bond. It is the Customer’s responsibility to restore all areas to their original appearance. Placements of tables, tents, live music, catering equipment, etc., must also be approved by The Bond 1786planning staff.

            <h4>SIGNAGE:</h4> You may post your group’s sign or hang balloons at the front entrance on Hudson Street, but please do NOT attach anything to or cover up our entrance sign, or nail or screw anything to the trees.

            <h4>SMOKING: </h4> The Bond 1786is a non-smoking facility. Ash-buckets will be provided, and smoking permitted in the designated areas only.

            <h4>CATERING:</h4> The catering service areas in each of the venues are not intended to be used as a kitchen for meal preparation.

            <h4>WEATHER:</h4> The weather is usually suitable for outside events from May 15 until October 15. Since most of our venues are booked-up for events in advance, please be advised that unless you reserve the Main Building or the Wedding Tent or one of the other venues at the time you schedule the main reception hall, we may not have any additional indoor facilities available to serve as a “weather back-up plan”. Should there be inclement weather on your reserved day, we will approve your last-minute rental of tents, canopies, or heaters, provided they are set-up at an acceptable location.

            <h4>WEDDING TENT / ARBOR:</h4> The Gazebo and Arbors may be used as wedding sites and for pictures (Chairs required for a wedding ceremony are to be provided and set-up by The Bond 1786 based on the standard rental policy). If the Venue has already been rented as a venue for a different group, then special permission must be granted to utilize the Tent for another party’s ceremony. Pictures are permitted to be taken at the Gazebos and Arbor sites by all parties but shall be coordinated for use between all site venues.

            <h4>WEDDING CEREMONIES:</h4> Wedding ceremonies may be held in the Reception Venue for no additional charge. Additional fees may apply for reset of room from ceremony to reception. Customer is responsible for providing ceremony coordinator, officiate, ceremony music and sound system.

            <h4>WEDDING REHEARSAL:</h4> In order to not conflict with other venue rentals, rehearsals are planned for Thursday evenings (unless a different date is approved). The complex must be vacated after completing the rehearsal program. The main event halls will not be available to decorate after the rehearsal. Alternative dates for Rehearsals may be held on-site. These date and times are to be coordinated with and approved by The Event Coordinator at The Bond 1786.

            <h4>LOGISTICAL PLANS:</h4> The Bond 1786 planning team must review and approve all proposed logistical plans for the use of the premises a minimum of thirty (30) days prior to an event.
            <h4>EVENTS & WEDDING POLICY AND GUIDELINES AGREEMENT </h4>

            I have read and understand the policies concerning events held at The Bond 1786. I agree to uphold them and ensure that contractors and members of the event party,
            will abide by the policies. I understand it is my responsibility to inform the coordinator, florist, photographers, etc., that they must also conform to this set of guidelines. <br>

            Please note that all prices are subject to 20% Service Charge and NYS 7.0% Sales Tax

            <h4>RESERVATION PROCESS</h4>
            <p>
                A rental contract must be signed, all pages initialed, as well as appropriate deposits submitted to confirm utilization of a The Bond 1786 Venue. <br><br>

                A valid Credit Card is required to be on file for all events to guarantee payment of expenses in connection with this Agreement. Customer agrees
                that any outstanding balance not received by the day of the event will be charged to the Credit Card on file. A Current Credit Card must be always communicated.
                No Personal Checks are accepted for final payment. <br><br>
                The Rules and Conditions for Usage are incorporated herein and are made a part hereof. <br><br>

            </p>


            <div class="main-div">
                <div class="row">
                    <div class="col-md-6" style="float:left;width:50%;">
                        <strong>Authorized Signature:</strong> <br>
                        <img src="{{$base64Image}}" style="width:30%; border-bottom:1px solid black;">
                    </div>
                </div>
                <div class="col-md-6" style="float:right;width:50%">
                    <strong>Signature:</strong><br>
                    <img src="{{@$sign}}" style="width:40%; border-bottom:1px solid black;margin-top:10%">
                </div>

            </div>
</body>

</html>