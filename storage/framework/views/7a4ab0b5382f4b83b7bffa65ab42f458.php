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
                        <!-- <th><?php echo e(__('Total')); ?> <span class="opticy"> dddd</span></th> -->
                        <th><?php echo e(__('Notes')); ?> <span class="opticy"> dddd</span></th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td><textarea class="form-control" name="billing[1][description]" id="description" cols="30" rows="3"></textarea></td>
                        <td><input class="form-control cost-input" type="number" min="1" name="billing[1][cost]" id="cost" value="" required></td>
                        <td><input class="form-control quantity-input" type="number" min="1" name="billing[1][quantity]" id="quantity" value="" required></td>
                        <!-- <td><input class="form-control total-input" type="text" name="billing[1][total]" id="total" value="" required></td> -->
                        <input class="form-control total-input" type="hidden" name="billing[1][total]" id="total" value="" required>
                        <td><textarea class="form-control" name="billing[1][note]" id="note" cols="30" rows="3"></textarea></td>
                        <td class="action-buttons">
                            <div class="action-btn bg-danger ms-2">
                                <a href="javascript:void(0);" onclick="deleteRow(this)" class="mx-3 btn btn-sm  align-items-center text-white" data-bs-toggle="tooltip" title='Delete'>
                                    <i class="ti ti-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="" style="float:right;left:-2%;position: relative;">
                <a href="javascript:void(0);" onclick="addRowAfter()" data-size="md" data-bs-toggle="tooltip" title="Add new Row" class="btn btn-primary">
                    Add Row <i class="ti ti-plus"></i>
                </a>
            </div>

            <script>
                let rowCount = 1;

                function addRowAfter() {
                    const tableBody = document.querySelector('#invoiceTable tbody');
                    const lastRow = tableBody.querySelector('tr:last-child');
                    const newRow = lastRow.cloneNode(true);
                    clearRow(newRow);
                    updateRowNames(newRow);
                    tableBody.appendChild(newRow);
                    attachEventListeners();
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
                    row.querySelector('textarea[id="description"]').name = `billing[${rowCount}][description]`;
                    row.querySelector('input[id="cost"]').name = `billing[${rowCount}][cost]`;
                    row.querySelector('input[id="quantity"]').name = `billing[${rowCount}][quantity]`;
                    row.querySelector('input[id="total"]').name = `billing[${rowCount}][total]`;
                    row.querySelector('textarea[id="note"]').name = `billing[${rowCount}][note]`;
                }

                function updateAllRowNames() {
                    const rows = document.querySelectorAll('#invoiceTable tbody tr');
                    rowCount = 0;
                    rows.forEach((row, index) => {
                        rowCount = index + 1;
                        row.querySelector('textarea[id="description"]').name = `billing[${rowCount}][description]`;
                        row.querySelector('input[id="cost"]').name = `billing[${rowCount}][cost]`;
                        row.querySelector('input[id="quantity"]').name = `billing[${rowCount}][quantity]`;
                        row.querySelector('input[id="total"]').name = `billing[${rowCount}][total]`;
                        row.querySelector('textarea[id="note"]').name = `billing[${rowCount}][note]`;
                    });
                }
            </script>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label class="form-label"> Deposit on file: </label>
            <input type="number" name="deposits" id="deposits" min="1" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Sales Tax (%)</label>
            <input type="number" name="salesTax" id="salesTax" min="1" class="form-control">
        </div>
        <div class="col-md-6 divRgt" style="position: relative;right: 0;left: 50%;">
            <label class="form-label">Total Amount: </label>
            <input type="number" name="totalAmount" id="totalAmount" class="form-control" readonly value="">
            <label class="form-label">Payments /Credit (-)</label>
            <input type="number" name="paymentCredit" id="paymentCredit" min="1" class="form-control" value="">
            <label class="form-label">Due Amount</label>
            <input type="number" name="dueAmount" id="dueAmount" class="form-control" readonly value="">
        </div>
    </div>

    <script>
        function calculateTotals() {
            let totalAmount = 0;
            const rows = document.querySelectorAll('#invoiceTable tbody tr');
            rows.forEach((row) => {
                const cost = parseFloat(row.querySelector('.cost-input').value) || 0;
                const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
                const totalCost = cost * quantity;
                row.querySelector('.total-input').value = totalCost.toFixed(2);
                totalAmount += totalCost;
            });
            const salesTax = document.getElementById('salesTax').value;

            salesTaxs = totalAmount / salesTax;
            totalAmount = totalAmount + salesTaxs;
            document.getElementById('totalAmount').value = totalAmount.toFixed(2);
            updateDueAmount();
        }

        function attachEventListeners() {
            document.querySelectorAll('.cost-input, .quantity-input, #salesTax').forEach(input => {
                input.removeEventListener('keyup', calculateTotals);
                input.removeEventListener('change', calculateTotals);
                input.addEventListener('keyup', calculateTotals);
                input.addEventListener('change', calculateTotals);
            });
        }

        attachEventListeners();

        function updateDueAmount() {
            const totalAmount = parseFloat(document.getElementById('totalAmount').value) || 0;
            const paymentCredit = parseFloat(document.getElementById('paymentCredit').value) || 0;
            const deposits = parseFloat(document.getElementById('deposits').value) || 0;
            const dueAmount = totalAmount - paymentCredit - deposits;
            document.getElementById('dueAmount').value = dueAmount.toFixed(2);
        }
        document.getElementById('paymentCredit').addEventListener('keyup', updateDueAmount);
        document.getElementById('paymentCredit').addEventListener('change', updateDueAmount);
        document.getElementById('deposits').addEventListener('keyup', updateDueAmount);
        document.getElementById('deposits').addEventListener('change', updateDueAmount);
    </script>

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