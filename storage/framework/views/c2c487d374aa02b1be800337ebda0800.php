<?php
$billing = App\Models\ProposalInfo::where('lead_id', $lead->id)->orderby('id', 'desc')->first();
if (isset($billing) && !empty($billing)) {
    $billing = json_decode($billing->proposal_info, true);
}
$selectedvenue = explode(',', $lead->venue_selection);
$imagePath = public_path('upload/signature/autorised_signature.png');
$imageData = base64_encode(file_get_contents($imagePath));
$base64Image = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . $imageData;
if (isset($proposal) && ($proposal['image'] != null)) {
    $signed = base64_encode(file_get_contents($proposal['image']));
    $sign = 'data:image/' . pathinfo($proposal['image'], PATHINFO_EXTENSION) . ';base64,' . $signed;
}

// $data['lead'] = $lead->toArray();
// $data['proposal'] = $proposal->toArray();
/* echo '<pre>';
print_r($data); */

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
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    label,
    span,
    p {
        font-family: "Open Sans", sans-serif;

    }

    .border-new {
        border: 1px solid #000 !important;
        padding: 15px 0;
    }

    .border-new1 {
        padding: 10px 0 40px 0;
    }

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
        /* column-gap: 20px; */
        /* font-size: 18px; */
    }

    .input-new1 {
        display: flex;
        /* column-gap: 20px; */
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
            /* Ensure color fidelity */
            /* background: white; */
            /* Set a white background */
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

        /* .container {
            display: flex;
            grid-template-columns: repeat(2, 1fr);
        } */


        /* .col-sm-6 {
            max-width: 50%;
        } */
        /* .col-sm-6 {
            width: calc(100%/2);
        } */
        .sidebyside {
            display: flex !important;
            width: 100% !important;
        }

        .col-sm-6 {
            width: 49.7% !important;
            float: left;
        }
    }

    .sidebyside {
        display: flex !important;
        width: 100% !important;
    }

    .col-sm-6 {
        width: 49.7% !important;
        float: left;
    }
</style>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 mt-4 border-new">
                <div class="img-section">
                    <img class="logo-img center-new" src="<?php echo e(URL::asset('storage/uploads/logo/3_logo-light.png')); ?>" style="width: auto;margin:0 250px">
                </div>
            </div>
            <div class="col-sm-12 border-new">
                <h4 class="center-new"><?php echo e(__('Proposal Acceptance Agreement')); ?></h4>
            </div>
            <div class="col-sm-12 border-new">
                <h5 class="center-new">PLEASE RETURN TO: Catamount Consulting, PO Box 442, Warrensburg NY 12885</br>Or</h5>
                <h5 class="center-new input-new">
                    <label for="email"><?php echo e(__('Email')); ?>: </label><?php echo e(__($auth->email)); ?>

                </h5>
                <h5 class="center-new">Feel free to call our office at (518) 623-2352 with any questions</h5>
            </div>
            <div class="col-sm-12 border-new">
                <h5 class="input-new">
                    <label for="client"><?php echo e(__('Client')); ?>: </label><?php echo e(__($lead->name)); ?>

                </h5>
            </div>
        </div>
        <div class="row">
            <div class="sidebyside">
                <div class="col-sm-6 border-new">
                    <h5 class="input-new">
                        <label for="phone"><?php echo e(__('Phone')); ?>: </label><?php echo e(__($lead->primary_contact)); ?>

                    </h5>
                </div>
                <div class="col-sm-6 border-new">
                    <h5 class="input-new">
                        <label for="email2"><?php echo e(__('Email')); ?>: </label><?php echo e(__($lead->email)); ?>

                    </h5>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 border-new">
                <h5 class="input-new">
                    <label for="servicesDate"><?php echo e(__('Date of service')); ?>: </label><?php echo e(__($lead->start_date)); ?>

                </h5>
            </div>
            <div class="col-sm-12 border-new">
                <h5 class="input-new">
                    <label for="services"><?php echo e(__('Services')); ?>: </label><?php echo e(__($lead->type)); ?>

                </h5>
            </div>
            <div class="col-sm-12 border-new border-new1" style="min-height: 250px;">
                <h5 class="input-new">
                    <label for="agreement"><?php echo e(__('Agreement')); ?>: </label>
                </h5>
                <div class="textarea">
                    <?= html_entity_decode($proposal->agreement) ?>
                </div>
            </div>
            <div class="col-sm-12 border-new">
                <h5 class="input-new">
                    <label for="signature"><?php echo e(__('Signature')); ?>: </label>
                    <img src="<?php echo e(__($proposal->image)); ?>" alt="" srcset="">
                </h5>
            </div>
            <div class="col-sm-12 border-new border-new1" style="min-height: 250px;">
                <h5 class="input-new">
                    <label for="remarks"><?php echo e(__('Remarks')); ?>: </label>
                </h5>
                <div class="textarea">
                    <?= html_entity_decode($proposal->remarks) ?>
                </div>
            </div>
            <div class="col-sm-12">
                <h5 class="input-new">
                    <label for="date"><?php echo e(__('Date')); ?>: </label>
                </h5>
            </div>
            <div class="col-sm-12 border-new1">
                <h5 class="input-new">
                    <label for="scopeServices"><?php echo e(__('Scope of Services')); ?>: </label>
                </h5>
            </div>
            <div class="col-sm-12">
                <h5 class="input-new">
                    <label for="schedule"><?php echo e(__('Schedule')); ?>: </label>
                    <p>Catamount Consulting is prepared to proceed upon receiving the Proposal Acceptance Agreement</p>
                </h5>
            </div>
            <div class="col-sm-12">
                <h5 class="input-new">
                    <label for="costBusinessTerms"><?php echo e(__('Cost and Business Terms')); ?>: </label>
                    <p>The Proposal shall remain valid for the period of 60 days from the date of the proposal origination. </p>
                </h5>
            </div>
            <div class="col-sm-12">
                <h5 class="input-new">
                    <label for="cencellation"><?php echo e(__('CANCELLATION')); ?>: </label>
                    <p>Should the above testing be cancelled within 2 weeks of the testing date, there will be a cancellation fee of $ . If testing is rescheduled within 1 month, the cancellation fee will be</br>negotiated and mitigated.
                    </p>
                </h5>
            </div>
            <div class="col-sm-12">
                <h5 class="input-new">We look forward to work with you. Please feel free to contact our office with any questions or concerns.</br>Respectfully,</h5>
            </div>
            <div class="col-sm-12">
                <h5 class="input-new1"><label for="name"><?php echo e(__('Name')); ?>: </label><?php echo e(__($auth->name)); ?></h5>
                <h5 class="input-new1"><label for="designation"><?php echo e(__('Designation')); ?>: </label><?php echo e(__($auth->type)); ?></h5>
                <h5 class="input-new1"><label for="date"><?php echo e(__('Date')); ?>: </label><?php echo e(__(date('Y-m-d'))); ?></h5>
                <h5 class="input-new1"><label for="to"><?php echo e(__('To')); ?></label></h5>
                <h5 class="input-new1"><label for="name"><?php echo e(__('Name')); ?>: </label><?php echo e(__($lead->name)); ?></h5>
                <h5 class="input-new1"><label for="designation"><?php echo e(__('Designation')); ?>: </label></h5>
                <h5 class="input-new1"><label for="date"><?php echo e(__('Date')); ?>: </label><?php echo e(__($lead->start_date)); ?></h5>
            </div>
        </div>
    </div>
</body>

</html><?php /**PATH D:\0Work\xampp\htdocs\laravel\catamount\resources\views/lead/signed_proposal.blade.php ENDPATH**/ ?>