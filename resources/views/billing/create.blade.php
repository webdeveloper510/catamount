<?php
$settings = App\Models\Utility::settings();
$billings = json_decode($settings['fixed_billing'], true);
$additional_items = json_decode($settings['additional_items'], true);

$type_arr = explode(',', $settings['event_type']);
$type_arr = array_combine($type_arr, $type_arr);

$type_company = explode(',', $settings['quick_company']);

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
{{Form::open(array('route' => ['billing.addbilling', $id],'method'=>'post','enctype'=>'multipart/form-data' ,'id'=>'formdata'))}}
<div class="col-md-12">
    <h3>Accounts Payables Contact</h3>
    <hr>
    <div class="row form-group append">
        <div class="form-group">
            <select name="quick_contact" id="quick_contact" class="form-control">
                <option value="">Choose contact</option>
                <option value="primary">Primary contact: {{$quick_contact['primary']['name']}}</option>
                <option value="secondary">Secondary contact: {{$quick_contact['secondary']['name']}}</option>
                <optgroup label="Accounts Payables">
                    @foreach($payable as $key => $value)
                    @php
                    $pay_data = json_decode($value, true);
                    if ($pay_data === null) {
                    continue;
                    }
                    $df = isset($key) ? "payable_{$key}" : 'payable_';
                    $name = isset($pay_data['name']) ? $pay_data['name'] : 'Default Name';
                    @endphp
                    <option value="{{$df}}">{{$name}}</option>
                    @endforeach
                </optgroup>
                <option value="other">Other</option>
            </select>
        </div>
        <div class="col-md-6 need_full">
            <div class="form-group">
                {{Form::label('name',__('Name'),['class'=>'form-label']) }}
                {{Form::text('other[name]',@$other['other_name'],array('class'=>'form-control','placeholder'=>__('Enter Name'), 'required' => 'required'))}}
            </div>
        </div>
        <div class="col-md-6 need_full company_name" style="display: none;">
            <div class="form-group">
                {{Form::label('company_name',__('Company name'),['class'=>'form-label']) }}
                {{--Form::text('other[company_name]',@$other['company_name'],array('class'=>'form-control','placeholder'=>__('Enter company name')))--}}
                <select name="other[company_name]" id="company_name" class="form-control">
                    <option value="">Choose company</option>
                    @if(isset($type_company) && !empty($type_company))
                    @foreach($type_company as $key => $value)
                    @if(!empty($value))
                    <option value="{{$key}}">{{$value}}</option>
                    @endif
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-md-6 need_full">
            <div class="form-group intl-tel-input">
                {{ Form::label('phone', __('Phone'), ['class' => 'form-label']) }}
                <div class="intl-tel-input">
                    <input type="tel" id="phone-input" name="other[other_contact]" class="phone-input form-control" placeholder="Enter Phone" maxlength="16" value="{{@$other['other_contact']}}">
                    <input type="hidden" name="other[countrycode]" id="country-code">
                </div>
            </div>
        </div>

        <div class="col-md-6 need_full">
            <div class="form-group">
                {{Form::label('email',__('Email'),['class'=>'form-label']) }}
                {{Form::text('other[email]',@$other_contact['email'],array('class'=>'form-control','placeholder'=>__('Enter Email'), 'required' => 'required'))}}
            </div>
        </div>
        <div class="col-md-6 need_full">
            <div class="form-group">
                {{Form::label('lead_address',__('Address'),['class'=>'form-label']) }}
                {{Form::text('other[lead_address]',@$other_contact['lead_address'],array('class'=>'form-control','placeholder'=>__('Address'), 'required' => 'required'))}}
            </div>
        </div>
        <div class="col-md-6 need_full">
            <div class="form-group">
                {{Form::label('relationship',__('Title'),['class'=>'form-label']) }}
                {{Form::text('other[relationship]',@$other_contact['relationship'],array('class'=>'form-control','placeholder'=>__('Enter Title'), 'required' => 'required'))}}
            </div>
        </div>
        <div class="col-md-6 need_full company_name" style="display: none;">
            <div class="form-group">
                {{Form::label('type',__('Training Type'),['class'=>'form-label']) }}
                <span class="text-sm">
                    <i class="fa fa-asterisk text-danger" aria-hidden="true"></i>
                </span>
                <select name="other[type]" id="type" class="form-control">
                    <option value="">Select Type</option>
                    @foreach($type_arr as $type)
                    <option value="{{$type}}">{{$type}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <script>
        function updateFormValues(data = null) {
            data.forEach(function(index, value) {
                document.querySelector(`input[name="other[${value}]"]`).value = value || null;
            })
            // document.querySelector('input[name="other[company_name]"]').value = data.company_name || null;
            // document.querySelector('input[name="other[other_contact]"]').value = data.other_contact || null;
            // document.querySelector('input[name="other[email]"]').value = data.email || null;
            // document.querySelector('input[name="other[lead_address]"]').value = data.lead_address || null;
            // document.querySelector('input[name="other[relationship]"]').value = data.relationship || null;
        }
        const isNumericInput = (event) => {
            const key = event.keyCode;
            return ((key >= 48 && key <= 57) || // Allow number line
                (key >= 96 && key <= 105) // Allow number pad
            );
        };

        const isModifierKey = (event) => {
            const key = event.keyCode;
            return (event.shiftKey === true || key === 35 || key === 36) || // Allow Shift, Home, End
                (key === 8 || key === 9 || key === 13 || key === 46) || // Allow Backspace, Tab, Enter, Delete
                (key > 36 && key < 41) || // Allow left, up, right, down
                (
                    // Allow Ctrl/Command + A,C,V,X,Z
                    (event.ctrlKey === true || event.metaKey === true) &&
                    (key === 65 || key === 67 || key === 86 || key === 88 || key === 90)
                )
        };

        const enforceFormat = (event) => {
            // Input must be of a valid number format or a modifier key, and not longer than ten digits
            if (!isNumericInput(event) && !isModifierKey(event)) {
                event.preventDefault();
            }
        };

        const formatToPhone = (event) => {
            if (isModifierKey(event)) {
                return;
            }

            // I am lazy and don't like to type things more than once
            const target = event.target;
            const input = event.target.value.replace(/\D/g, '').substring(0, 10); // First ten digits of input only
            const zip = input.substring(0, 3);
            const middle = input.substring(3, 6);
            const last = input.substring(6, 10);

            if (input.length > 6) {
                target.value = `(${zip}) ${middle} - ${last}`;
            } else if (input.length > 3) {
                target.value = `(${zip}) ${middle}`;
            } else if (input.length > 0) {
                target.value = `(${zip}`;
            }
        };

        const inputElement = document.querySelector('input[name="other[other_contact]"]');
        inputElement.addEventListener('keydown', enforceFormat);
        inputElement.addEventListener('keyup', formatToPhone);

        function phoneFormat() {
            var phoneNumber = $('input[name="other[other_contact]"]').val();
            var lastTenDigits = phoneNumber.substr(-10);
            var formattedPhoneNumber = '(' + lastTenDigits.substr(0, 3) + ') ' + lastTenDigits.substr(3, 3) + '-' +
                lastTenDigits.substr(6);
            $('input[name="other[other_contact]"]').val(formattedPhoneNumber);
            var input = document.querySelector('input[name="other[other_contact]"]');
            var iti = window.intlTelInput(input, {
                separateDialCode: true,
            });

            var indiaCountryCode = iti.getSelectedCountryData().iso2;
            var countryCode = iti.getSelectedCountryData().dialCode;
            $('#country-code').val(countryCode);
            if (indiaCountryCode !== 'us') {
                iti.setCountry('us');
            }
        }

        $(document).ready(function() {
            phoneFormat();
            $("select[name=quick_contact]").on('change', function() {
                var selectedValue = $(this).val();
                var quickContactData = @json($quick_contact);
                if (selectedValue == 'primary') {
                    inputs = quickContactData['primary'];
                    $('div.company_name').hide();
                } else if (selectedValue == 'secondary') {
                    inputs = quickContactData['secondary'];
                    $('div.company_name').hide();
                } else if (selectedValue != 'secondary' && selectedValue != 'primary' && selectedValue != 'other') {
                    inputs = quickContactData[selectedValue];
                } else {
                    inputs = quickContactData['other'];
                    if (selectedValue == 'other') {
                        $('div.company_name').show();
                    }
                }
                updateFormValues(inputs)
            })
        });
    </script>
    <div class="form-group">
        <div class="col-md-12">
            <label class="form-label"> Deposit on file: </label>
            <input type="number" name="deposits" id="deposits" min="1" class="form-control">
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <h4 style="float:right;background: teal;color: white;padding: 11px;border-radius: 5px;"><b>Guest Count: {{$event->guest_count}}</b></h4>
        <div class="table-responsive">
            <table class="table" id="invoiceTable">
                <thead>
                    <tr>
                        <th>{{__('Description')}} <span class="opticy"> dddd</span></th>
                        <th>{{__('Cost(per person)')}} <span class="opticy"> dddd</span></th>
                        <th>{{__('Quantity')}} <span class="opticy"> dddd</span></th>
                        <!-- <th>{{__('Total')}} <span class="opticy"> dddd</span></th> -->
                        <th>{{__('Notes')}} <span class="opticy"> dddd</span></th>
                    </tr>
                </thead>
                <tbody>
                    {{--@foreach($labels as $key => $label)
                    <tr>
                        <td>{{ucfirst($label)}}</td>
                    <td>
                        <input type="text" name="billing[{{$key}}][cost]" value="{{ isset($meetingData[$key.'_cost']) && $meetingData[$key.'_cost'] != '' ? $meetingData[$key.'_cost'] : 1 }}" class="form-control dlr">
                    </td>
                    <td>
                        <input type="number" name="billing[{{$key}}][quantity]" min='1' class="form-control" value="{{isset($meetingData[$key]) && $meetingData[$key] != '' ? $meetingData[$key] : 1}}" required>
                    </td>
                    <td>
                        <input type="text" name="billing[{{$key}}][notes]" class="form-control" value="{{ ($key !== 'hotel_rooms') ? $meetingData[$key] ?? 1 : 1 }}">
                    </td>
                    </tr>
                    @endforeach--}}
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
                        attachEventListeners();
                        calculateTotals();
                    } else {
                        alert("At least one row must be present.");
                    }
                }

                function clearRow(row) {
                    row.querySelectorAll('textarea, input').forEach(input => input.value = '');
                    attachEventListeners();
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
        <div class="col-md-6">
            <label class="form-label">Purchase Order Number</label>
            <input type="number" name="purchaseOrder" id="purchaseOrder" min="1" class="form-control">
            <label class="form-label">Terms</label>
            <input type="text" name="terms" id="terms" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Total Amount</label>
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
            const salesTax = parseFloat(document.getElementById('salesTax').value) || 0;

            totalAmount = totalAmount + (totalAmount * (salesTax / 100));
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
{{ Form::submit(__('Save'),array('class'=>'btn btn-primary')) }}
{{ Form::close() }}
<style>
    .modal-dialog.modal-md {
        max-width: max-content;
    }

    .table-responsive {
        float: left;
        width: 100%;
    }
</style>