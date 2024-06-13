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
    <style>
        .invoice-container {
            /* width: 800px; */
            margin: 0 auto;
            padding: 20px;
            /* border: 1px solid #000; */
        }

        header {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header-left img {
            width: 100px;
            height: auto;
        }

        .header-left p,
        .header-right p {
            margin: 0;
        }

        .header-right {
            text-align: right;
        }

        .bill-to {
            margin-top: 20px;
        }

        .details table,
        .totals table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .details table td,
        .totals table td {
            border: 1px solid #000;
            padding: 8px;
        }

        .details table td:first-child {
            width: 70%;
        }

        .totals table td {
            text-align: right;
        }

        footer {
            margin-top: 20px;
            font-size: 0.9em;
            border-top: 2px solid #000;
            padding-top: 10px;
            text-align: center;
        }
    </style>
</head>

<body>


    <div class="invoice-container">
        <header>
            <div class="header-left">
                <img src="<?php echo e(url('storage/uploads/logo/3_logo-light.png')); ?>" alt="Catamount Consulting">
                <p><strong>Catamount Consulting</strong><br>PO Box 442<br>Warrensburg, NY 12885<br>Ph. (518) 623-2352</p>
            </div>
            <div class="header-right">
                <h2>Invoice</h2>
                <p>Date: 1/5/2022<br>Invoice #: 8233</p>
            </div>
        </header>
        <section class="bill-to">
            <p><strong>Bill To</strong></p>
            <p>Bylada Foods<br>140 West Commercial Ave<br>Moonachie, NJ 07074</p>
        </section>
        <section class="details">
            <table>
                <tr>
                    <td>Description</td>
                    <td>Qty</td>
                    <td>Rate</td>
                    <td>Amount</td>
                </tr>
                <tr>
                    <td>BALANCE DUE For Onsite Audiometric Testing conducted on 1/4/22 45 people tested<br>
                        Due to Scheduling and timing of the groups testing took 12 hours which required a second overnight<br>
                        ***Deposit of $850.00 was paid on 10/21/21***</td>
                    <td>1</td>
                    <td>$850.00</td>
                    <td>$850.00</td>
                </tr>
                <tr>
                    <td>Due to Scheduling and timing of the groups testing took 12 hours which required a second overnight</td>
                    <td>1</td>
                    <td>$800.00</td>
                    <td>$800.00</td>
                </tr>
            </table>
        </section>
        <section class="totals">
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td>$1,650.00</td>
                </tr>
                <tr>
                    <td>Sales Tax (0.0%)</td>
                    <td>$0.00</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>$1,650.00</td>
                </tr>
                <tr>
                    <td>Payments/Credits</td>
                    <td>-$1,650.00</td>
                </tr>
                <tr>
                    <td><strong>Balance Due</strong></td>
                    <td><strong>$0.00</strong></td>
                </tr>
            </table>
        </section>
        <footer>
            <p>
                <strong>*NEW*</strong> Please Note that ALL Invoices are DUE ON RECEIPT. ALL invoices that are not paid on invoice date can and will be subject to Late Fees.<br>
                Late fees charged will consist of 2% of unpaid balance, accrued every 30 days after invoice date.
            </p>
            <p>
                E-mail: accounting@catamountconsultingllc.com<br>
                Web Site: catamountconsultingllc.com
            </p>
        </footer>
    </div>


    
</body>

</html><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/meeting/agreement/view.blade.php ENDPATH**/ ?>