<?php
$billing = App\Models\ProposalInfo::where('lead_id', $lead->id)->orderby('id', 'desc')->first();
if (isset($billing) && !empty($billing)) {
    $billing = json_decode($billing->proposal_info, true);
}
$settings = App\Models\Utility::settings();
@$proposalSettings = unserialize($proposal_info['proposal_data']);
@$proposal_settings = unserialize($settings['proposal']);

$selectedvenue = explode(',', $lead->venue_selection);
$imagePath = public_path('upload/signature/autorised_signature.png');
$imageData = base64_encode(file_get_contents($imagePath));
$base64Image = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . $imageData;
if (isset($proposal) && ($proposal['image'] != null)) {
    $signed = base64_encode(file_get_contents($proposal['image']));
    $sign = 'data:image/' . pathinfo($proposal['image'], PATHINFO_EXTENSION) . ';base64,' . $signed;
}

$proposalDataArg = json_decode($proposal_info->proposal_data);

// prx($proposalDataArg);
/* $proposalSettingsArg = [];
foreach ($proposal_settings as $proCustKey => $proCustValue) {
    if (array_key_exists($proCustKey, $proposalSettings)) {
        $proposalSettingsArg[$proCustKey] = $proposalSettings[$proCustKey];
    } else {
        $proposalSettingsArg[$proCustKey] = $proCustValue;
    }
} */
$token = array(
    'USER_EMAIL'  => $usersDetail->email,
);
$pattern = '[%s]';
foreach ($token as $key => $val) {
    $varMap[sprintf($pattern, $key)] = $val;
}
@$proposal_settings['address'] = strtr($proposal_settings['address'], $varMap);

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
                    <img class="logo-img center-new" src="<?php echo e(url('storage/uploads/logo/3_logo-light.png')); ?>" style="width: auto;margin:0 250px">
                </div>
            </div>
            <div class="col-sm-12 border-new">
                <h4 class="center-new"><?php echo __(@$proposal_settings['title']); ?></h4>
            </div>
            <div class="col-sm-12 border-new">
                <h4 class="center-new"><?php echo __(@$proposal_settings['address']); ?></h4>
            </div>
            <div class="col-sm-12 border-new">
                <h5 class="input-new">
                    <label for="client"><?php echo e(__('Client')); ?>: </label><span><?php echo e(__(@$proposalDataArg->client->name)); ?></span>
                </h5>
            </div>
        </div>
        <div class="row">
            <div class="sidebyside">
                <div class="col-sm-6 border-new">
                    <h5 class="input-new">
                        <label for="phone"><?php echo e(__('Phone')); ?>: </label><span><?php echo e(__(@$proposalDataArg->client->phone)); ?></span>
                    </h5>
                </div>
                <div class="col-sm-6 border-new">
                    <h5 class="input-new">
                        <label for="email2"><?php echo e(__('Email')); ?>: </label><span><?php echo e(__(@$lead->email)); ?></span>
                    </h5>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 border-new">
                <h5 class="input-new">
                    <label for="servicesDate"><?php echo e(__('Date of service')); ?>: </label><span><?php echo e(__($proposalDataArg->client->dateOfService)); ?></span>
                </h5>
            </div>
            <div class="col-sm-12 border-new">
                <h5 class="input-new">
                    <label for="services"><?php echo e(__('Services')); ?>: </label><span><?php echo e(__(@$proposalDataArg->client->services)); ?></span>
                </h5>
            </div>
            <div class="col-sm-12 border-new border-new1" style="min-height: 300px;">
                <h5 class="input-new">
                    <label for="agreement"><?php echo e(__('Agreement')); ?>: </label>
                </h5>
                <div class="textarea">
                    <p style="font-family: 'Open Sans', sans-serif;"><?php echo @$proposalDataArg->settings->agreement; ?></p>
                </div>
            </div>
            <div class="col-sm-12 border-new">
                <h5 class="input-new">
                    <label for="signature"><?php echo e(__('Signature')); ?>: </label>
                    <img src="<?php echo e(__($proposal->image)); ?>" alt="" srcset="">
                </h5>
            </div>
            <div class="col-sm-12 border-new border-new1" style="min-height: 300px;">
                <h5 class="input-new">
                    <label for="remarks"><?php echo e(__('Remarks')); ?>:</label>
                </h5>
                <div class="textarea">
                    <p style="font-family: 'Open Sans', sans-serif;"><?php echo @$proposalDataArg->settings->remarks; ?></p>
                </div>
            </div>
            <div class="col-sm-12">
                <h5 class="input-new">
                    <label for="date"><?php echo e(__('Date')); ?>: </label> <span><?php echo e(__(@$lead->start_date)); ?></span>
                </h5>
            </div>
            <div class="col-sm-12  mt-5">
                <h5 class="input-new">
                    <label for="scopeServices"><?php echo e(__('Scope of Services')); ?>:</label>
                </h5>
                <div class="textarea">
                    <p style="font-family: 'Open Sans', sans-serif;"><?php echo @$proposalDataArg->settings->scopeOfService; ?></p>
                </div>
            </div>
            <div class="col-sm-12 mt-5">
                <h5 class="input-new">
                    <label for="schedule"><?php echo e(__('Schedule')); ?>:</label>
                </h5>
                <div class="textarea">
                    <p style="font-family: 'Open Sans', sans-serif;"><?php echo @$proposal_settings['schedule']; ?></p>
                </div>
            </div>
            <div class="col-sm-12 mt-5">
                <h5 class="input-new">
                    <label for="costBusinessTerms"><?php echo e(__('Cost and Business Terms')); ?>:</label>
                </h5>
                <div class="textarea">
                    <p style="font-family: 'Open Sans', sans-serif;"><?php echo @$proposalDataArg->settings->costBusiness; ?></p>
                </div>
            </div>
            <div class="col-sm-12 mt-5">
                <h5 class="input-new">
                    <label for="cencellation"><?php echo e(__('CANCELLATION')); ?>:</label>
                </h5>
                <div class="textarea">
                    <p style="font-family: 'Open Sans', sans-serif;"><?php echo @$proposalDataArg->settings->cancenllation; ?></p>
                </div>
            </div>
            <!-- <div class="col-sm-12 border-new1">
                <h5 class="input-new">
                    <label for="scopeServices"><?php echo e(__('Scope of Services')); ?>: </label>
                </h5>
            </div>
            <div class="col-sm-12">
                <h5 class="input-new">
                    <label for="schedule"><?php echo e(__('Schedule')); ?>: </label>
                    <p style="font-family: 'Open Sans', sans-serif;">Catamount Consulting is prepared to proceed upon receiving the Proposal Acceptance Agreement</p>
                </h5>
            </div>
            <div class="col-sm-12">
                <h5 class="input-new">
                    <label for="costBusinessTerms"><?php echo e(__('Cost and Business Terms')); ?>: </label>
                    <p style="font-family: 'Open Sans', sans-serif;">The Proposal shall remain valid for the period of 60 days from the date of the proposal origination. </p>
                </h5>
            </div>
            <div class="col-sm-12">
                <h5 class="input-new">
                    <label for="cencellation"><?php echo e(__('CANCELLATION')); ?>: </label>
                    <p style="font-family: 'Open Sans', sans-serif;">Should the above testing be cancelled within 2 weeks of the testing date, there will be a cancellation fee of $ . If testing is rescheduled within 1 month, the cancellation fee will be</br>negotiated and mitigated.
                    </p>
                </h5>
            </div>
            <div class="col-sm-12">
                <h5 class="input-new">We look forward to work with you. Please feel free to contact our office with any questions or concerns.</br>Respectfully,</h5>
            </div> -->
            <div class="table">
                <table style="width: 100%; border-collapse: collapse; margin: 20px 0; font-family: Arial, sans-serif; background-color: #f9f9f9;">
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 8px;">Name</td>
                        <td style="padding: 8px;"><?php echo e(__(@$proposalDataArg->from->name)); ?></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 8px;">Title</td>
                        <td style="padding: 8px;"><?php echo e(__(@$proposalDataArg->from->designation)); ?></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 8px;">Date</td>
                        <td style="padding: 8px;"><?php echo e(__(@$proposalDataArg->from->date)); ?></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 8px;" colspan="2" style="text-align: center; background-color: #f2f2f2; font-weight: bold;">For</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 8px;">Name</td>
                        <td style="padding: 8px;"><?php echo e(__($proposalDataArg->to->name)); ?></td>
                        <!-- <td style="padding: 8px;"><?php echo e(__(@$proposalDataArg->to->name)); ?></td> -->
                    </tr>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 8px;">Title</td>
                        <td style="padding: 8px;"><?php echo e(__($proposalDataArg->to->designation)); ?></td>
                        <!-- <td style="padding: 8px;"><?php echo e(__(@$proposalDataArg->to->designation)); ?></td> -->
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Date</td>
                        <td style="padding: 8px;"><?php echo e(date('Y-m-d')); ?></td>
                        <!-- <td style="padding: 8px;"><?php echo e(__(@$proposalDataArg->to->date)); ?></td> -->
                    </tr>
                </table>
            </div>
            <!-- <div class="details">
                <h5 class="input-new1">
                    <label for="name"><?php echo e(__('Name')); ?>: </label><?php echo e(__($proposal->name)); ?>

                </h5>
                <h5 class="input-new1">
                    <label for="designation"><?php echo e(__('Designation')); ?>: </label><?php echo e(__($proposal->designation)); ?>

                </h5>
                <h5 class="input-new1">
                    <label for="date"><?php echo e(__('Date')); ?>: </label><?php echo e(__($proposal->date)); ?>

                </h5>
                <h5 class="input-new1">
                    <label for="to"><?php echo e(__('To')); ?></label>
                </h5>
                <h5 class="input-new1">
                    <label for="name"><?php echo e(__('Name')); ?>: </label><?php echo e(__($proposal->to_name)); ?>

                </h5>
                <h5 class="input-new1">
                    <label for="designation"><?php echo e(__('Designation')); ?>: <?php echo e(__($proposal->to_designation)); ?></label>
                </h5>
                <h5 class="input-new1">
                    <label for="date"><?php echo e(__('Date')); ?>: </label><?php echo e(__($proposal->to_date)); ?>

                </h5>
            </div> -->
        </div>
    </div>
</body>

</html><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/lead/signed_proposal.blade.php ENDPATH**/ ?>