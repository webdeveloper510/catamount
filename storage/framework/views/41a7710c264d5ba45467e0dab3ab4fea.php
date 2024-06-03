<?php
$settings = App\Models\Utility::settings();
$billings = json_decode($settings['fixed_billing'], true);
$foodpcks = json_decode($lead->func_package, true);
$barpcks = json_decode($lead->bar_package, true);
// $barpcks = json_decode($lead->bar,true);
$labels = [
    'venue_rental' => 'Venue',
    'hotel_rooms' => 'Hotel Rooms',
    'food_package' => 'Food Package',
    'bar_package' => 'Beverage/Bar Package'
];
$food = [];
$totalFoodPackageCost = 0;
$totalBarPackageCost = 0;
if (isset($billings) && !empty($billings)) {
    if (isset($foodpcks) && !empty($foodpcks)) {
        foreach ($foodpcks as $key => $foodpck) {
            foreach ($foodpck as $foods) {
                $food[] = $foods;
            }
        }
        $foodpckge = implode(',', $food);
        foreach ($food as $foodItem) {
            foreach ($billings['package'] as $category => $categoryItems) {
                if (isset($categoryItems[$foodItem])) {
                    $totalFoodPackageCost +=  (int)$categoryItems[$foodItem];
                    break;
                }
            }
        }
    }
    if (isset($barpcks) && !empty($barpcks)) {
        foreach ($barpcks as $key => $barpck) {
            $bar[] = $barpck;
        }
        $barpckge = implode(',', $bar);
        foreach ($bar as $barItem) {
            foreach ($billings['barpackage'] as $category => $categoryItems) {
                if (isset($categoryItems[$barItem])) {
                    $totalBarPackageCost +=  (int)$categoryItems[$barItem];
                    break;
                }
            }
        }
    }
}



$leaddata = [
    'venue_rental' => $lead->venue_selection,
    'hotel_rooms' => $lead->rooms,
    'food_package' => (isset($foodpckge) && !empty($foodpckge)) ? $foodpckge : '',
    'bar_package' => (isset($barpckge) && !empty($barpckge)) ? $barpckge : '',

];
$venueRentalCost = 0;
$subcategories = array_map('trim', explode(',', $leaddata['venue_rental']));
foreach ($subcategories as $subcategory) {
    $venueRentalCost += $billings['venue'][$subcategory] ?? 0;
}

$leaddata['hotel_rooms_cost'] = $billings['hotel_rooms'] ?? 0;
$leaddata['venue_rental_cost'] = $venueRentalCost;
$leaddata['food_package_cost'] = $totalFoodPackageCost;
$leaddata['bar_package_cost'] = $totalBarPackageCost;


/* echo '<pre>';
print_r($proposal);
echo '</pre>'; */

@$proposal = unserialize($proposal['proposal_data']) ?: [];
@$proposal_settings = unserialize($settings['proposal']);


$finalProposalArg = [];
foreach ($proposal as $proCustKey => $proCustValue) {
    @$finalProposalArg[$proCustKey] = $proCustValue != NULL ? $proCustValue : $proposal_settings[$proCustKey];
}

$token = array(
    'USER_EMAIL'  => $users->email,
);
$pattern = '[%s]';
foreach ($token as $key => $val) {
    $varMap[sprintf($pattern, $key)] = $val;
}
@$finalProposalArg['address'] = strtr($finalProposalArg['address'], $varMap);

?>
<div class="row">
    <div class="col-lg-12">
        <?php echo e(Form::model($lead, ['route' => ['lead.pdf', urlencode(encrypt($lead->id))], 'method' => 'POST','enctype'=>'multipart/form-data'])); ?>


        <div class="">
            <dl class="row">
                <input type="hidden" name="lead" value="<?php echo e($lead->id); ?>">
                <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Name')); ?></span></dt>
                <dd class="col-md-6">
                    <input type="text" name="name" class="form-control" value="<?php echo e($lead->name); ?>" readonly>
                </dd>

                <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Recipient')); ?></span></dt>
                <dd class="col-md-6">
                    <input type="email" name="email" class="form-control" value="<?php echo e($lead->email); ?>" required>
                </dd>

                <dt class="col-md-12"><span class="h6  mb-0"><?php echo e(__('Subject')); ?></span></dt>
                <dd class="col-md-12"><input type="text" name="subject" id="Subject" class="form-control" required></dd>

                <dt class="col-md-12"><span class="h6  mb-0"><?php echo e(__('Content')); ?></span></dt>
                <dd class="col-md-12"><textarea name="emailbody" id="emailbody" cols="30" rows="10" class="form-control" required></textarea></dd>

                <dt class="col-md-12"><span class="h6  mb-0"><?php echo e(__('Upload Document')); ?></span></dt>
                <dd class="col-md-12"><input type="file" name="attachment" id="attachment" class="form-control"></dd>
                <hr class="mt-4 mb-4">
                <h5 class="bb"><?php echo e(__('PDF')); ?></h5>
                <dl class="row">
                    <dt class="col-md-12"><span class="h6 mb-0"><?php echo e(__('Agreement')); ?></span></dt>
                    <dd class="col-md-12">
                        <textarea name="agreement" class="form-control" id="agreement"><?php echo e(@$finalProposalArg['agreement']); ?></textarea>
                    </dd>
                    <dt class="col-md-12"><span class="h6  mb-0"><?php echo e(__('Remarks')); ?></span></dt>
                    <dd class="col-md-12">
                        <textarea name="remarks" class="form-control" id="remarks"><?php echo e((@$finalProposalArg['remarks'])); ?></textarea>
                    </dd>

                    <dt class="col-md-12"><span class="h6  mb-0"><?php echo e(__('Scope of Services')); ?></span></dt>
                    <dd class="col-md-12">
                        <textarea name="scopeOfService" class="form-control" id="scopeOfService"><?php echo e((@$finalProposalArg['scopeOfService'])); ?></textarea>
                    </dd>

                    <dt class="col-md-12"><span class="h6  mb-0"><?php echo e(__('Cost and Business Terms')); ?></span></dt>
                    <dd class="col-md-12">
                        <textarea name="costBusiness" class="form-control" id="costBusiness"><?php echo e((@$finalProposalArg['costBusiness'])); ?></textarea>
                    </dd>
                    <dt class="col-md-12"><span class="h6  mb-0"><?php echo e(__('CANCELLATION')); ?></span></dt>
                    <dd class="col-md-12">
                        <textarea name="cancenllation" class="form-control" id="cancenllation"><?php echo e((@$finalProposalArg['cancenllation'])); ?></textarea>
                    </dd>
                </dl>
            </dl>
        </div>
        <div id="notification" class="alert alert-success mt-1">Link copied to clipboard!</div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" data-toggle="tooltip" onclick="formSubmit(event,this,'clipboard')" data-url="<?php echo e(route('lead.signedproposal',urlencode(encrypt($lead->id)))); ?>" title='Copy To Clipboard'>
                <i class="ti ti-copy"></i>
            </button>
            <!-- <button type="button" class="btn btn-primary" data-toggle="tooltip" onclick="formSubmit(this,'mail')" title='Send to mail'>Share via mail</button> -->
            <?php echo e(Form::submit(__('Share via mail'),array('class'=>'btn btn-primary'))); ?>

        </div>

        <?php echo e(Form::close()); ?>

    </div>
</div>
<script>
    txtEditor('agreement');
    txtEditor('remarks');
    txtEditor('scopeOfService');
    txtEditor('costBusiness');
    txtEditor('cancenllation');
</script>
<style>
    #notification {
        display: none;
    }
</style>
<script>
    /* function getDataUrlAndCopy(button) {
        var dataUrl = button.getAttribute('data-url');
        copyToClipboard(dataUrl);
        // alert("Copied the data URL: " + dataUrl);
    } */

    function formSubmit(event, element, type) {
        event.preventDefault();
        event.stopPropagation();
        // type = type == 'clipboard' ? 'clipboard' : 'mail';
        var dataURL = $(element).data('url');
        var url = "<?php echo e(route('lead.pdf', urlencode(encrypt($lead->id)))); ?>";
        $(element).closest('form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('action', type);
            $.ajax({
                url: url,
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    if (type == 'clipboard') {
                        copyToClipboard(dataURL);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(status);
                    console.log(error);
                }
            });
        });
        event.stopPropagation();
        $(element).closest('form').trigger('submit');
    }


    function copyToClipboard(text) {
        /* Create a temporary input element */
        var tempInput = document.createElement("input");

        /* Set the value of the input element to the text to be copied */
        tempInput.value = text;

        document.body.appendChild(tempInput);

        /* Select the text in the input element */
        tempInput.select();

        /* Copy the selected text to the clipboard */
        document.execCommand("copy");

        /* Remove the temporary input element from the DOM */
        document.body.removeChild(tempInput);
        showNotification();

        /* Hide the notification after 2 seconds (adjust as needed) */
        setTimeout(hideNotification, 2000);
    }

    function showNotification() {
        var notification = document.getElementById('notification');
        notification.style.display = 'block';
    }

    function hideNotification() {
        var notification = document.getElementById('notification');
        notification.style.display = 'none';
    }
</script><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/lead/share_proposal.blade.php ENDPATH**/ ?>