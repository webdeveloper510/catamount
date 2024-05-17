<?php 
 $event= App\Models\Meeting::where('id',$paymentinfo->event_id)->first();
 $logo=\App\Models\Utility::get_file('uploads/logo/');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Bond 1786</title>
    <style>
    body {
        background-color: #F6F6F6;
        margin: 0;
        padding: 0;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        margin: 0;
        padding: 0;
    }

    p {
        margin: 0;
        padding: 0;
    }

    .container {
        width: 100%;
        margin-right: auto;
        margin-left: auto;
    }

    .brand-section {
        background-color: #0d1033;
        padding: 10px 40px;
    }

    .logo {
        width: 50%;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
    }

    .col-6 {
        width: 50%;
        flex: 0 0 auto;
    }

    .text-white {
        color: #fff;
    }

    .company-details {
        float: right;
        text-align: right;
    }

    .body-section {
        padding: 16px;
        border: 1px solid gray;
    }

    .heading {
        font-size: 20px;
        margin-bottom: 08px;
    }

    .sub-heading {
        color: #262626;
        margin-bottom: 05px;
    }

    table {
        background-color: #fff;
        width: 100%;
        border-collapse: collapse;
    }

    table thead tr {
        border: 1px solid #111;
        background-color: #f2f2f2;
    }

    table td {
        vertical-align: middle !important;
        text-align: center;
    }

    table th,
    table td {
        padding-top: 08px;
        padding-bottom: 08px;
    }

    .table-bordered {
        box-shadow: 0px 0px 5px 0.5px gray;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid #dee2e6;
    }

    .text-right {
        text-align: end;
    }

    .w-20 {
        width: 20%;
    }

    .float-right {
        float: right;
    }

    .image {
        text-align: center;
    }
    </style>
</head>

<body>
    <div class="image">
        <img src="{{$logo.'3_logo-light.png'}}" alt="{{ config('app.name', 'The Bond 1786') }}"
            class="logo logo-lg nav-sidebar-logo" height="auto" style="width:10%;" />
    </div>
    <div class="container">
        <div class="brand-section">
            <div class="row">
                <div class="col-6">
                    <h1 class="text-white">The Bond 1786</h1>
                </div>

            </div>
        </div>

        <div class="body-section">
            <div class="row">
                <div class="col-6">
                    <h2 class="heading">Transaction Id : {{$paymentlog->transaction_id}}</h2>
                    <p class="sub-heading"> Date: {{ \Carbon\Carbon::parse($paymentlog->created_at)->format('M d, Y') }}
                    </p>
                    <p class="sub-heading">Email Address: {{$event->email}}</p>
                </div>
                <div class="col-6">
                    <p>Full Name: {{$event->name}} </p>
                    <p>Address: {{$event->lead_address}} </p>
                    <p>Phone Number: {{$event->phone}} </p>
                </div>
            </div>
        </div>

        <div class="body-section">
            <h3 class="heading">Event Details</h3>
            <br>
            <table class="table-bordered">
                <thead>
                    <!-- <tr>
                        <th></th>
                        <th class="w-20"></th>
                       
                    </tr> -->
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2">Event Type</td>
                        <td>{{$event->type}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Date of Event</td>
                        <td>{{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">No. of guests</td>
                        <td>{{$event->guest_count}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Venue</td>
                        <td>{{$event->venue_selection}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Function</td>
                        <td>{{$event->function}}</td>
                    </tr>



                </tbody>
            </table>

        </div>
        <div class="body-section">
            <h3 class="heading">Billing Details</h3>
            <br>
            <table class="table-bordered">

                <tbody>

                    <tr>
                        <td colspan="2" class="text-right"><b>Total Amount</b></td>
                        <td> <b>${{$paymentinfo->amount}}</b></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right"><b>Adjustments</b></td>
                        <td> <b>${{$paymentinfo->adjustments}} </b></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Late Fee(If any)</td>
                        <td>{{ ($paymentinfo->latefee == 0)? '--' : $paymentinfo->latefee}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right"><b>Paid Amount</b></td>
                        <td> <b>${{$paymentlog->amount}} </b></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right"><b>Balance Due</b></td>
                        <td> <b>${{$paymentinfo->amount - $paymentlog->amount - $paymentinfo->adjustments}} </b></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <h3 class="heading">Payment Status: Paid</h3>
            <h3 class="heading">Payment Mode: {{ucfirst($paymentinfo->modeofpayment)}}</h3>
        </div>
        <div class="body-section">
            <p>&copy; The Bond 1786. All rights reserved.

            </p>
        </div>
    </div>

</body>

</html>