<?php
$settings = App\Models\Utility::settings();
$billings = json_decode($settings['fixed_billing'], true);
$additional_items = json_decode($settings['additional_items'], true);
$labels =
    [
        'venue_rental' => 'Venue',
        'hotel_rooms' => 'Hotel Rooms',
        'equipment' => 'Tent, Tables, Chairs, AV Equipment',
        'setup' => 'Setup',
        'bar_package' => 'Bar Package',
        'special_req' => 'Special Requests/Other',
        'food_package' => 'Food Package',
        'additional_items' => 'Additional Items'
    ];
$bar = [];
$barpcks = json_decode($event->bar_package, true);
foreach ($barpcks as $key => $barpck) {
    $bar[] = $barpck;
}
$barpckge = implode(',', $bar);
$foodpcks = json_decode($event->func_package, true);
$addpcks = json_decode($event->ad_opts, true);
$food = [];

$add = [];
foreach ($foodpcks as $key => $foodpck) {
    foreach ($foodpck as $foods) {
        $food[] = $foods;
    }
}

$foodpckge = implode(',', $food);
foreach ($addpcks as $key => $adpck) {
    foreach ($adpck as $ad) {
        $add[] = $ad;
    }
}
$addpckge = implode(',', $add);
$meetingData = [
    'venue_rental' => $event->venue_selection,
    'hotel_rooms' => $event->room,
    'equipment' => $event->spcl_request,
    'bar_package' => (isset($event->bar_package) && !empty($event->bar_package)) ? $barpckge : '',
    'food_package' => (isset($event->func_package) && !empty($event->func_package)) ? $foodpckge : '',
    'additional_items' => (isset($event->ad_opts) && !empty($event->ad_opts)) ? $addpckge : '',
    'setup' => ''
];
$totalFoodPackageCost = 0;
$totalbarPackageCost = 0;
foreach ($bar as $barItem) {
    foreach ($billings['barpackage'] as $category => $categoryItems) {
        if (isset($categoryItems[$barItem])) {
            $totalbarPackageCost += $categoryItems[$barItem];
            break;
        }
    }
}
if (isset($billings) && !empty($billings)) {
    foreach ($food as $foodItem) {
        foreach ($billings['package'] as $category => $categoryItems) {
            if (isset($categoryItems[$foodItem])) {
                $totalFoodPackageCost +=  (int)$categoryItems[$foodItem];
                break;
            }
        }
    }
    $meetingData['food_package_cost'] = $totalFoodPackageCost;
}
$additionalItemsCost = 0;
if (isset($additional_items) && !empty($additional_items)) {
    foreach ($additional_items as $category => $categoryItems) {
        foreach ($categoryItems as $item => $subItems) {
            foreach ($subItems as $key => $value) {
                if (in_array($key, $add)) {
                    // Add the value to the total cost
                    $additionalItemsCost += $value;
                }
            }
        }
    }
}


// Get the value for 'Patio' from the 'venue' array
$subcategories = array_map('trim', explode(',', $meetingData['venue_rental']));
$venueRentalCost = 0;
foreach ($subcategories as $subcategory) {
    $venueRentalCost += $billings['venue'][$subcategory] ?? 0;
}
$meetingData['venue_rental_cost'] = $venueRentalCost;
$meetingData['hotel_rooms_cost'] = $billings['hotel_rooms'] ?? '';
$meetingData['equipment_cost'] = $billings['equipment'] ?? '';
$meetingData['bar_package_cost'] = $totalbarPackageCost;
$meetingData['food_package_cost'] = $totalFoodPackageCost;
$meetingData['additional_items_cost'] = $additionalItemsCost ?? '';
$meetingData['special_req_cost'] = $billings['special_req'] ?? '';
$meetingData['setup_cost'] = '';
?>
<?php echo e(Form::open(array('route' => ['billing.addbilling', $id],'method'=>'post','enctype'=>'multipart/form-data' ,'id'=>'formdata'))); ?>

<div class="col-md-12">
    <div class="form-group">
        <h4 style="float:right;    background: teal;
    color: white;
    padding: 11px;
    border-radius: 5px;"><b>Guest Count: <?php echo e($event->guest_count); ?></b></h4>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo e(__('Description')); ?> <span class="opticy"> dddd</span></th>
                        <th><?php echo e(__('Cost(per person)')); ?> <span class="opticy"> dddd</span></th>
                        <th><?php echo e(__('Quantity')); ?> <span class="opticy"> dddd</span></th>
                        <th><?php echo e(__('Notes')); ?> <span class="opticy"> dddd</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e(ucfirst($label)); ?></td>
                        <td>
                            <input type="text" name="billing[<?php echo e($key); ?>][cost]" value="<?php echo e(isset($meetingData[$key.'_cost']) && $meetingData[$key.'_cost'] != '' ? $meetingData[$key.'_cost'] : 1); ?>" class="form-control dlr">
                        </td>
                        <td>
                            <input type="number" name="billing[<?php echo e($key); ?>][quantity]" min='1' class="form-control" value="<?php echo e(isset($meetingData[$key]) && $meetingData[$key] != '' ? $meetingData[$key] : 1); ?>" required>
                        </td>
                        <td>
                            <input type="text" name="billing[<?php echo e($key); ?>][notes]" class="form-control" value="<?php echo e(($key !== 'hotel_rooms') ? $meetingData[$key] ?? 1 : 1); ?>">
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            <label class="form-label"> Deposit on file: </label>
            <input type="number" name="deposits" min='0' class="form-control">
        </div>

    </div>

</div>
<?php echo e(Form::submit(__('Save'),array('class'=>'btn btn-primary '))); ?>

<?php echo e(Form::close()); ?>

<style>
    .modal-dialog.modal-md {
        max-width: max-content;
    }

    .table-responsive {
        float: left;
        width: 100%;
    }
</style><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/billing/create.blade.php ENDPATH**/ ?>