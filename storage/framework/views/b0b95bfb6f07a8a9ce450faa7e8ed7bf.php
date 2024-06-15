<?php
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agreement</title>
    <link rel="stylesheet" type="text/css" href="<?php echo e(public_path('assets/css/style.css')); ?>">
    <style>
        body {
            font-family: "Open Sans", sans-serif;
            margin: 0;
            font-size: 12px;
        }

        .invoice {
            width: 100%;
            margin: 0 auto;
            /* border: 1px solid #000; */
        }

        .header {
            display: block;
        }

        .logo {
            position: relative;
            font-weight: bold;
            font-size: 16px;
            width: 70%;
            left: 20%;
        }

        .logo img {
            max-width: 100px;
            max-height: 80px;
            position: relative;
            top: 12%;
            right: 25%;
        }

        .invoice-details table {
            border-collapse: collapse;
        }

        .invoice-details td {
            border: 1px solid #000;
            padding: 3px 8px;
        }

        .bill-to {
            position: relative;
            left: 6%;
            top: -2%;
            border: 1px solid #000;
            width: 40%;
            padding: 2px 8px;
        }

        .bill-to p {
            margin: 0;
        }

        .items table {
            width: 100%;
            border-collapse: collapse;
        }

        .items th,
        .items td {
            border: 1px solid #000;
            padding: 2px 5px;
        }

        .items th {
            background-color: #f0f0f0;
        }

        .notes {
            position: relative;
            top: -8%;
            left: 10%;
            width: 50%;
            text-align: center;
        }

        .footer {
            text-align: center;
            font-size: 11px;
        }

        /* custom CSS */

        .tdTotal {
            font-weight: 600;
            font-size: 18px;
        }

        .borderN {
            border: none !important;
        }

        .logoTxt {
            position: relative;
            left: 18%;
        }

        .invoice-details {
            position: relative;
            right: -70%;
            top: -10%;
            width: 20%;
        }

        .invoice-details h2,
        .logoTxt h2 {
            font-size: 28px;
        }

        .strong {
            font-weight: 700;
            font-size: 18px;
        }

        .notes strong {
            font-size: 18px;
        }

        .notes p {
            word-wrap: break-word;
            text-align: center;
        }

        .boxBorder {
            position: relative;
            left: 15%;
            top: -12%;
            border: 1px solid #000;
            width: 50%;
            word-wrap: break-word;
            padding: 8px 12px;
            margin: 0;
        }

        .contactTable {
            position: absolute;
            display: flex;
            width: 35%;
        }

        .contactTable table {
            text-align: center;
        }

        .contactTable table:nth-child(2) {
            position: relative;
            left: 380px;
            top: -38px;
        }

        .spacer p {
            text-indent: 8rem;
        }

        .paidStemp {
            position: fixed;
            top: 20%;
            left: 40%;
            transform: rotate(-22deg);
            font-weight: 700;
            font-size: 22px;
        }
    </style>
</head>

<body>
    <div class="paidStemp">
        <h2>PAID</h2>
        <h2><?php echo e(date('d/m/Y')); ?></h2>
    </div>
    <div class="invoice">
        <div class="header">
            <div class="logo">
                <img src="<?php echo e(url('storage/uploads/logo/3_logo-light.png')); ?>" alt="Catamount Consulting">
                <p class="logoTxt">
                <h2>Catamount Consulting</h2><br>PO Box 442<br>Warrensburg, NY 12885<br>Ph: (518) 623-2352</p>
            </div>
            <div class="invoice-details">
                <h2>Invoice</h2>
                <table>
                    <tr>
                        <td class="strong">Date</td>
                        <td class="strong">Invoice #</td>
                    </tr>
                    <tr>
                        <td>1/5/2023</td>
                        <td>8231</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="bill-to">
            <h2 style="position: relative; left: 10%; top: 1%">Bill To</h2>
            <hr style="border: 1px solid #000">
            <p>Ryder Truck Rental</p>
            <p>160 West Commercial Ave</p>
            <p>Moonachie, NJ 07074</p>
        </div>
        <div class="items">
            <table>
                <thead>
                    <tr>
                        <td colspan="2" class="borderN"></td>
                        <th>P.O. No.</th>
                        <th>Terms</th>
                    </tr>
                    <tr>
                        <td colspan="2" class="borderN"></td>
                        <td></td>
                        <td>Due on receipt</td>
                    </tr>
                    <tr>
                        <th style="width: 60%;">Description</th>
                        <th style="width: 5%;">Qty</th>
                        <th style="width: 15%;">Rate</th>
                        <th style="width: 20%;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>BALANCE DUE For Onsite Audiometric Testing conducted on 1/4/22 45 people tested<br>
                            **Due to Scheduling and timing of the group testing took 12 hours which required a second overnight<br>
                            ***Deposit of $850.00 was paid on 10/21/21**</td>
                        <td>1</td>
                        <td>$850.00</td>
                        <td>$850.00</td>
                    </tr>
                    <tr class="spacer">
                        <td>
                            <p></p>
                            <p></p>
                            <p></p>
                            <p></p>
                            <p></p>
                            <p></p>
                            <p></p>
                            <p></p>
                            <p></p>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                </tbody>
                <tr>
                    <td colspan="2"></td>
                    <td class="tdTotal" style="border-right: none;">Subtotal</td>
                    <td style="border-left: none;">$1.6232</td>
                </tr>
                <tr>
                    <td class="borderN" colspan="2"></td>
                    <td class="tdTotal" style="border-right: none;">Sales Tax (0.0%)</td>
                    <td style="border-left: none;">$0.00</td>
                </tr>
                <tr>
                    <td class="borderN" colspan="2"></td>
                    <td class="tdTotal" style="border-right: none;">Total</td>
                    <td style="border-left: none;">$1,650.00</td>
                </tr>
                <tr>
                    <td class="borderN" colspan="2"></td>
                    <td class="tdTotal" style="border-right: none;">Payments/Credits</td>
                    <td style="border-left: none;">-$1,650.00</td>
                </tr>
                <tr>
                    <td class="borderN" colspan="2"></td>
                    <td class="tdTotal" style="border-right: none;">Balance Due </td>
                    <td style="border-left: none;">$0.00</td>
                </tr>
            </table>
        </div>
        <div class="notes strong">
            <strong>*NEW*</strong> Please Note that ALL Invoices are DUE ON RECEIPT. ALL Invoices that are not paid on Invoice date due and will be subject to Late Fees.
        </div>
        <div class="lateFee strong">
            <p class="boxBorder">Late fees charged will consist of 2% of unpaid balance, accrued every 30 days after invoice date.</p>
        </div>
        <div class="footer">
            <div class="items contactTable">
                <table>
                    <tr>
                        <th>E-mail</th>
                    </tr>
                    <tr>
                        <td>accounting@catamountconsultingllc.com</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Web Site</th>
                    </tr>
                    <tr>
                        <td>catamountconsultingllc.com</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Old  -->

    
</body>

</html><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/meeting/agreement/view.blade.php ENDPATH**/ ?>