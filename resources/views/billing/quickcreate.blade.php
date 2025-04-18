<?php
$settings = App\Models\Utility::settings();
$type_arr = explode(',', $settings['event_type']);
$type_arr = array_combine($type_arr, $type_arr);


$type_company = explode(',', $settings['quick_company']);
?>
@extends('layouts.admin')
@section('page-title')
{{ __('Quick invoice') }}
@endsection
@section('title')
{{ __('Quick invoice') }}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item">{{ __('Quick invoice') }}</li>
@endsection
@section('content')
@section('action-btn')
@endsection

{{Form::open(array('route' => ['billing.addbilling', $id = 00],'method'=>'post','enctype'=>'multipart/form-data' ,'id'=>'formdata'))}}
<div class="row">
    <div class="col-6 need_full">
        <div class="form-group">
            {{Form::label('organization_name',__('Organization name'),['class'=>'form-label']) }}
            <select name="organization_name" id="organization_name" class="form-control select2">
                <option value="">Choose contact</option>
                @foreach($company_names as $key => $value)
                <option value="{{$value}}">{{$value}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-6 need_full">
        <div class="form-group">
            <div id="account_payable_contact"></div>
        </div>
    </div>
    <div class="col-6 need_full">
        <div class="form-group">
            {{Form::label('name',__('Name'),['class'=>'form-label']) }}
            {{Form::text('other[name]',@$other['other_name'],array('class'=>'form-control','placeholder'=>__('Enter Name'), 'required' => 'required'))}}
        </div>
    </div>
    <div class="col-6 company_name" style="display: none;">
        <div class="form-group">
            {{Form::label('company_name',__('Company name'),['class'=>'form-label']) }}
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
    <div class="col-6 need_full">
        <div class="form-group intl-tel-input">
            {{ Form::label('phone', __('Phone'), ['class' => 'form-label']) }}
            <div class="intl-tel-input">
                <input type="tel" id="phone-input" name="other[other_contact]" class="phone-input form-control" placeholder="Enter Phone" maxlength="16" value="{{@$other['other_contact']}}">
                <input type="hidden" name="other[countrycode]" id="country-code">
            </div>
        </div>
    </div>

    <div class="col-6 need_full">
        <div class="form-group">
            {{Form::label('email',__('Email'),['class'=>'form-label']) }}
            {{Form::text('other[email]',@$other_contact['email'],array('class'=>'form-control','placeholder'=>__('Enter Email'), 'required' => 'required'))}}
        </div>
    </div>
    <div class="col-6 need_full">
        <div class="form-group">
            {{Form::label('lead_address',__('Address'),['class'=>'form-label']) }}
            {{Form::text('other[lead_address]',@$other_contact['lead_address'],array('class'=>'form-control','placeholder'=>__('Address'), 'required' => 'required'))}}
        </div>
    </div>
    <div class="col-6 need_full">
        <div class="form-group">
            {{Form::label('relationship',__('Title'),['class'=>'form-label']) }}
            {{Form::text('other[relationship]',@$other_contact['relationship'],array('class'=>'form-control','placeholder'=>__('Enter Title'), 'required' => 'required'))}}
        </div>
    </div>
    <div class="col-6 company_name" style="display: none;">
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
    <script>
        function updateFormValues(data = null) {
            if (data && typeof data === 'object' && Object.keys(data).length > 0) {
                Object.entries(data).forEach(function([key, value]) {
                    var inputElement = document.querySelector(`input[name="other[${key}]"]`);
                    if (inputElement) {
                        inputElement.value = value || '';
                    }
                });
            } else {
                var inputs = document.querySelectorAll('input[name^="other["]');
                inputs.forEach(function(input) {
                    input.value = '';
                });
            }
            phoneFormat();
        }
        var isNumericInput1 = (event) => {
            var key = event.keyCode;
            return ((key >= 48 && key <= 57) || // Allow number line
                (key >= 96 && key <= 105) // Allow number pad
            );
        };

        var isModifierKey1 = (event) => {
            var key = event.keyCode;
            return (event.shiftKey === true || key === 35 || key === 36) || // Allow Shift, Home, End
                (key === 8 || key === 9 || key === 13 || key === 46) || // Allow Backspace, Tab, Enter, Delete
                (key > 36 && key < 41) || // Allow left, up, right, down
                (
                    // Allow Ctrl/Command + A,C,V,X,Z
                    (event.ctrlKey === true || event.metaKey === true) &&
                    (key === 65 || key === 67 || key === 86 || key === 88 || key === 90)
                )
        };

        var enforceFormat1 = (event) => {
            // Input must be of a valid number format or a modifier key, and not longer than ten digits
            if (!isNumericInput1(event) && !isModifierKey1(event)) {
                event.preventDefault();
            }
        };

        var formatToPhone1 = (event) => {
            if (isModifierKey1(event)) {
                return;
            }

            // I am lazy and don't like to type things more than once
            var target = event.target;
            var input = event.target.value.replace(/\D/g, '').substring(0, 10); // First ten digits of input only
            var zip = input.substring(0, 3);
            var middle = input.substring(3, 6);
            var last = input.substring(6, 10);

            if (input.length > 6) {
                target.value = `(${zip}) ${middle} - ${last}`;
            } else if (input.length > 3) {
                target.value = `(${zip}) ${middle}`;
            } else if (input.length > 0) {
                target.value = `(${zip}`;
            }
        };

        var inputElement1 = document.querySelector('input[name="other[other_contact]"]');
        inputElement1.addEventListener('keydown', enforceFormat1);
        inputElement1.addEventListener('keyup', formatToPhone1);

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
            phoneFormat()

            function selectFun(companyValue, inputs3) {
                $("select[name=quick_contact]").on('change', function() {
                    var selectedValue = $(this).val();
                    $('div.company_name').hide();
                    if (selectedValue == 'other') {
                        $('div.company_name').show();
                    }

                    var quickContactData = inputs3[selectedValue];
                    updateFormValues(quickContactData)
                })
            }
            $("select[name=organization_name]").on('change', function() {
                companyName = $(this).val();
                $.ajax({
                    url: "{{route('companybyname')}}",
                    type: 'POST',
                    data: {
                        "companyName": companyName,
                        "_token": "{{ csrf_token() }}",
                    },
                    error: function(data) {
                        data = data.responseJSON;
                        console.error(data);
                    },
                    success: function(data) {
                        selectHTML = ''
                        selectHTML += `{{Form::label('account_payable_contact',__('Accounts Payables Contact'),['class'=>'form-label']) }}`
                        selectHTML += `<select name="quick_contact" id="quick_contact" class="form-control"><option value="">Choose contact</option>`
                        $.each(data, function(companyKey, companyData) {
                            $.each(companyData, function(contactKey, contactValue) {
                                if (contactKey.startsWith('primary') || contactKey.startsWith('secondary')) {
                                    if (contactKey.startsWith('primary')) {
                                        label = `Primary contact`;
                                    } else if (contactKey.startsWith('secondary')) {
                                        label = `Secondary contact`;
                                    } else {
                                        label = `Others`;
                                    }
                                    selectHTML += `<optgroup label="${label}">`;
                                    selectHTML += `<option value="${contactKey}">${contactValue.name || 'No Entries'}</option>`;
                                    selectHTML += `</optgroup>`;
                                }
                            });
                            selectHTML += `<optgroup label="Others">`;
                            $.each(companyData, function(contactKey, contactValue) {
                                if (contactKey.startsWith('payable')) {
                                    selectHTML += `<option value="${contactKey}">${contactValue.name || 'No Entries'}</option>`;
                                }
                            });
                            selectHTML += `</optgroup>`;
                        });
                        selectHTML += `<option value="other">Other</option>`;
                        selectHTML += `</select>`;
                        $('div#account_payable_contact').html(selectHTML);
                        selectFun(companyName, data[companyName]);
                    }
                });
            });
        });
    </script>
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label"> Deposit on file: </label>
            <input type="number" name="deposits" id="deposits" min="1" class="form-control">
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <div class="table-responsive">
                <table class="table" id="invoiceTable">
                    <thead>
                        <tr>
                            <th>{{__('Description')}} <span class="opticy"> dddd</span></th>
                            <th>{{__('Cost(per person)')}} <span class="opticy"> dddd</span></th>
                            <th>{{__('Quantity')}} <span class="opticy"> dddd</span></th>
                            <th>{{__('Notes')}} <span class="opticy"> dddd</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><textarea class="form-control" name="billing[1][description]" id="description" cols="30" rows="3"></textarea></td>
                            <td><input class="form-control cost-input" type="number" min="1" name="billing[1][cost]" id="cost" value="" required></td>
                            <td><input class="form-control quantity-input" type="number" min="1" name="billing[1][quantity]" id="quantity" value="" required></td>
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
                    var rowCount1 = 1;

                    function addRowAfter() {
                        var tableBody = document.querySelector('#invoiceTable tbody');
                        var lastRow = tableBody.querySelector('tr:last-child');
                        var newRow = lastRow.cloneNode(true);
                        clearRow(newRow);
                        updateRowNames(newRow);
                        tableBody.appendChild(newRow);
                        attachEventListeners();
                    }

                    function deleteRow(button) {
                        var row = button.closest('tr');
                        var table = row.parentNode;
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
                        rowCount1++;
                        row.querySelector('textarea[id="description"]').name = `billing[${rowCount1}][description]`;
                        row.querySelector('input[id="cost"]').name = `billing[${rowCount1}][cost]`;
                        row.querySelector('input[id="quantity"]').name = `billing[${rowCount1}][quantity]`;
                        row.querySelector('input[id="total"]').name = `billing[${rowCount1}][total]`;
                        row.querySelector('textarea[id="note"]').name = `billing[${rowCount1}][note]`;
                    }

                    function updateAllRowNames() {
                        var rows = document.querySelectorAll('#invoiceTable tbody tr');
                        rowCount1 = 0;
                        rows.forEach((row, index) => {
                            rowCount1 = index + 1;
                            row.querySelector('textarea[id="description"]').name = `billing[${rowCount1}][description]`;
                            row.querySelector('input[id="cost"]').name = `billing[${rowCount1}][cost]`;
                            row.querySelector('input[id="quantity"]').name = `billing[${rowCount1}][quantity]`;
                            row.querySelector('input[id="total"]').name = `billing[${rowCount1}][total]`;
                            row.querySelector('textarea[id="note"]').name = `billing[${rowCount1}][note]`;
                        });
                    }
                </script>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-6 need_full">
                <label class="form-label"> Deposit on file: </label>
                <input type="number" name="deposits" id="deposits" min="1" class="form-control">
            </div>
            <div class="col-6 need_full">
                <label class="form-label">Sales Tax (%)</label>
                <input type="number" name="salesTax" id="salesTax" min="1" class="form-control">
            </div>
            <div class="col-6 need_full">
                <label class="form-label">Purchase Order Number</label>
                <input type="number" name="purchaseOrder" id="purchaseOrder" min="1" class="form-control">
                <label class="form-label">Terms</label>
                <input type="text" name="terms" id="terms" class="form-control">
            </div>
            <div class="col-6 need_full">
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
                var rows = document.querySelectorAll('#invoiceTable tbody tr');
                rows.forEach((row) => {
                    var cost = parseFloat(row.querySelector('.cost-input').value) || 0;
                    var quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
                    var totalCost = cost * quantity;
                    row.querySelector('.total-input').value = totalCost.toFixed(2);
                    totalAmount += totalCost;
                });
                var salesTax = parseFloat(document.getElementById('salesTax').value) || 0;

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
                var totalAmount = parseFloat(document.getElementById('totalAmount').value) || 0;
                var paymentCredit = parseFloat(document.getElementById('paymentCredit').value) || 0;
                var deposits = parseFloat(document.getElementById('deposits').value) || 0;
                var dueAmount = totalAmount - paymentCredit - deposits;
                document.getElementById('dueAmount').value = dueAmount.toFixed(2);
            }
            document.getElementById('paymentCredit').addEventListener('keyup', updateDueAmount);
            document.getElementById('paymentCredit').addEventListener('change', updateDueAmount);
            document.getElementById('deposits').addEventListener('keyup', updateDueAmount);
            document.getElementById('deposits').addEventListener('change', updateDueAmount);
        </script>

    </div>
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
@endsection