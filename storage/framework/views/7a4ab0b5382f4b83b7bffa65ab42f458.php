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
            <table class="table" id="invoiceTable">
                <thead>
                    <tr>
                        <th><?php echo e(__('Description')); ?> <span class="opticy"> dddd</span></th>
                        <th><?php echo e(__('Cost(per person)')); ?> <span class="opticy"> dddd</span></th>
                        <th><?php echo e(__('Quantity')); ?> <span class="opticy"> dddd</span></th>
                        <th><?php echo e(__('Notes')); ?> <span class="opticy"> dddd</span></th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td><textarea name="billing[1][description]" id="description" cols="30" rows="3"></textarea></td>
                        <td><input type="number" min="1" name="billing[1][cost]" id="cost" value="" required></td>
                        <td><input type="number" min="1" name="billing[1][quantity]" id="quantity" value="" required></td>
                        <td><input type="text" name="billing[1][note]" id="note" value=""></td>
                        <td class="action-buttons">
                            <div class="action-btn bg-primary ms-2">
                                <a href="javascript:void(0);" onclick="addRowAfter(this)" data-size="md" data-bs-toggle="tooltip" title="" class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                    <i class="ti ti-plus"></i>
                                </a>
                            </div>
                            <div class="action-btn bg-danger ms-2">
                                <a href="javascript:void(0);" onclick="deleteRow(this)" class="mx-3 btn btn-sm  align-items-center text-white" data-bs-toggle="tooltip" title='Delete'>
                                    <i class="ti ti-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <script>
                    let rowCount = 1;

                    function addRowAfter(button) {
                        const row = button.closest('tr');
                        const newRow = row.cloneNode(true);
                        clearRow(newRow);
                        updateRowNames(newRow);
                        row.parentNode.insertBefore(newRow, row.nextSibling);
                    }

                    function deleteRow(button) {
                        const row = button.closest('tr');
                        const table = row.parentNode;
                        if (table.rows.length > 1) {
                            row.remove();
                            updateAllRowNames();
                        } else {
                            alert("At least one row must be present.");
                        }
                    }

                    function clearRow(row) {
                        row.querySelectorAll('textarea, input').forEach(input => input.value = '');
                    }

                    function updateRowNames(row) {
                        rowCount++;
                        row.querySelector('textarea').name = `billing[${rowCount}][description]`;
                        row.querySelector('input[id="cost"]').name = `billing[${rowCount}][cost]`;
                        row.querySelector('input[id="quantity"]').name = `billing[${rowCount}][quantity]`;
                        row.querySelector('input[id="note"]').name = `billing[${rowCount}][note]`;
                    }

                    function updateAllRowNames() {
                        const rows = document.querySelectorAll('#billingTable tbody tr');
                        rowCount = 0;
                        rows.forEach((row, index) => {
                            rowCount = index + 1;
                            row.querySelector('textarea').name = `billing[${rowCount}][description]`;
                            row.querySelector('input[id="cost"]').name = `billing[${rowCount}][cost]`;
                            row.querySelector('input[id="quantity"]').name = `billing[${rowCount}][quantity]`;
                            row.querySelector('input[id="note"]').name = `billing[${rowCount}][note]`;
                        });
                    }
                </script>
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