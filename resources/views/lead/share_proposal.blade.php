<?php
$settings = App\Models\Utility::settings();
$billings = json_decode($settings['fixed_billing'], true);
$foodpcks = json_decode($lead->func_package, true);
$barpcks = json_decode($lead->bar_package, true);
// $barpcks = json_decode($lead->bar,true);
$labels = [
    'venue_rental' => 'Training Location',
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

$proposalDataArg = isset($proposal->proposal_data) ? json_decode($proposal->proposal_data) : [];
$proposalSettingArg = unserialize($settings['proposal']);

$agreement = isset($proposalDataArg->settings->agreement) ? $proposalDataArg->settings->agreement : $proposalSettingArg['agreement'];
$remarks = isset($proposalDataArg->settings->remarks) ? $proposalDataArg->settings->remarks : $proposalSettingArg['remarks'];
$scopeOfService = isset($proposalDataArg->settings->scopeOfService) ? $proposalDataArg->settings->scopeOfService : $proposalSettingArg['scopeOfService'];
$costBusiness = isset($proposalDataArg->settings->costBusiness) ? $proposalDataArg->settings->costBusiness : $proposalSettingArg['costBusiness'];
$cancenllation = isset($proposalDataArg->settings->cancenllation) ? $proposalDataArg->settings->cancenllation : $proposalSettingArg['cancenllation'];
?>
<div class="row">
    <div class="col-lg-12">
        {{ Form::model($lead, ['route' => ['lead.pdf', urlencode(encrypt($lead->id))], 'method' => 'POST','enctype'=>'multipart/form-data']) }}

        <div class="">
            <dl class="row">
                <input type="hidden" name="lead" value="{{ @$lead->id }}">
                <dt class="col-md-6"><span class="h6  mb-0">{{__('Name')}}</span></dt>
                <dd class="col-md-6">
                    <input type="text" name="name" class="form-control" value="{{ @$lead->name }}" readonly>
                </dd>

                <dt class="col-md-6"><span class="h6  mb-0">{{__('Recipient')}}</span></dt>
                <dd class="col-md-6">
                    <input type="email" name="email" class="form-control" value="{{ @$lead->email }}" required>
                </dd>

                <dt class="col-md-12"><span class="h6  mb-0">{{__('Subject')}}</span></dt>
                <dd class="col-md-12"><input type="text" name="subject" id="Subject" class="form-control" required></dd>

                <dt class="col-md-12"><span class="h6  mb-0">{{__('Content')}}</span></dt>
                <dd class="col-md-12"><textarea name="emailbody" id="emailbody" cols="30" rows="10" class="form-control" required></textarea></dd>

                <dt class="col-md-12"><span class="h6  mb-0">{{__('Upload Document')}}</span></dt>
                <dd class="col-md-12"><input type="file" name="attachment" id="attachment" class="form-control"></dd>
                <hr class="mt-4 mb-4">
                <dl class="row">
                    <dt class="col-md-2"><span class="h6 mb-0">{{__('Client')}}</span></dt>
                    <dd class="col-md-4">
                        <input type="text" name="pdf[client][name]" class="form-control" id="client" value="{{ @$proposalDataArg->client->name ? $proposalDataArg->client->name : $lead->name }}">
                    </dd>
                    <dt class="col-md-2"><span class="h6 mb-0">{{__('Phone')}}</span></dt>
                    <dd class="col-md-4">
                        <input type="text" name="pdf[client][phone]" class="form-control" id="phone" value="{{ @$proposalDataArg->client->phone ? $proposalDataArg->client->phone : $lead->primary_contact}}">
                    </dd>
                    <dt class="col-md-2"><span class="h6 mb-0">{{__('Email')}}</span></dt>
                    <dd class="col-md-4">
                        <input type="text" name="pdf[client][email]" class="form-control" id="email" value="{{ @$proposalDataArg->client->email ? $proposalDataArg->client->email : $lead->email}}">
                    </dd>
                    <dt class="col-md-2"><span class="h6 mb-0">{{__('Date of service')}}</span></dt>
                    <dd class="col-md-4">
                        <input type="text" name="pdf[client][dateOfService]" class="form-control" id="dateOfService" value="{{ @$proposalDataArg->client->dateOfService ? $proposalDataArg->client->dateOfService : $lead->start_date }}">
                    </dd>
                    <dt class="col-md-2"><span class="h6 mb-0">{{__('Services')}}</span></dt>
                    <dd class="col-md-10">
                        <input type="text" name="pdf[client][services]" class="form-control" id="services" value="{{ @$proposalDataArg->client->services ? $proposalDataArg->client->services : $lead->type }}">
                    </dd>
                    <hr class="mt-4 mb-4">
                    <dt class="col-md-12"><span class="h6 mb-0">{{__('Agreement')}}</span></dt>
                    <dd class="col-md-12">
                        <textarea rows="5" name="pdf[settings][agreement]" class="form-control" id="agreement">{{@$agreement}}</textarea>
                    </dd>
                    <dt class="col-md-12"><span class="h6  mb-0">{{__('Remarks')}}</span></dt>
                    <dd class="col-md-12">
                        <textarea rows="5" name="pdf[settings][remarks]" class="form-control" id="remarks">{{@$remarks}}</textarea>
                    </dd>
                    <dt class="col-md-12"><span class="h6  mb-0">{{__('Scope of Services')}}</span></dt>
                    <dd class="col-md-12">
                        <textarea rows="5" name="pdf[settings][scopeOfService]" class="form-control" id="scopeOfService">{{@$scopeOfService}}</textarea>
                    </dd>
                    <dt class="col-md-12"><span class="h6  mb-0">{{__('Cost and Business Terms')}}</span></dt>
                    <dd class="col-md-12">
                        <textarea rows="5" name="pdf[settings][costBusiness]" class="form-control" id="costBusiness">{{@$costBusiness}}</textarea>
                    </dd>
                    <dt class="col-md-12"><span class="h6  mb-0">{{__('Cancellation')}}</span></dt>
                    <dd class="col-md-12">
                        <textarea rows="5" name="pdf[settings][cancenllation]" class="form-control" id="cancenllation">{{@$cancenllation}}</textarea>
                    </dd>
                    <hr class="mt-4 mb-4">
                    <dt class="col-md-2"><span class="h6 mb-0">{{__('Name')}}</span></dt>
                    <dd class="col-md-10">
                        <input type="text" name="pdf[from][name]" class="form-control" id="client" value="{{ @$proposalDataArg->from->name ? $proposalDataArg->from->name : $users->name }}">
                    </dd>
                    <dt class="col-md-2"><span class="h6 mb-0">{{__('Designation')}}</span></dt>
                    <dd class="col-md-4">
                        <input type="text" name="pdf[from][designation]" class="form-control" id="client" value="{{ @$proposalDataArg->from->designation ? $proposalDataArg->from->designation : $users->type }}">
                    </dd>
                    <dt class="col-md-2"><span class="h6 mb-0">{{__('Date')}}</span></dt>
                    <dd class="col-md-4">
                        <input type="date" name="pdf[from][date]" class="form-control" id="client" value="{{ @$proposalDataArg->from->date ? $proposalDataArg->from->date : date('Y-m-d') }}">
                    </dd>
                    <hr class="mt-4 mb-4">
                    <dt class="col-md-2"><span class="h6 mb-0">{{__('Name')}}</span></dt>
                    <dd class="col-md-10">
                        <!-- <input type="text" name="pdf[to][name]" class="form-control" id="client" value=" {{ @$proposalDataArg->to->name ? $proposalDataArg->to->name : $lead->name }}"> -->
                        <input type="text" name="pdf[to][name]" class="form-control" id="client" value="">
                    </dd>
                    <dt class="col-md-2"><span class="h6 mb-0">{{__('Designation')}}</span></dt>
                    <dd class="col-md-4">
                        <!-- <input type="text" name="pdf[to][designation]" class="form-control" id="client" value=" {{ @$proposalDataArg->to->designation ? $proposalDataArg->to->designation : $lead->type }}"> -->
                        <input type="text" name="pdf[to][designation]" class="form-control" id="client" value="">
                    </dd>
                    <dt class="col-md-2"><span class="h6 mb-0">{{__('Date')}}</span></dt>
                    <dd class="col-md-4">
                        <!-- <input type="date" name="pdf[to][date]" class="form-control" id="client" value="{{ @$proposalDataArg->to->date ? $proposalDataArg->to->date : $lead->start_date }}"> -->
                        <input type="date" name="pdf[to][date]" class="form-control" id="client" value="">
                    </dd>

                </dl>
            </dl>
        </div>
        <div id="notification" class="alert alert-success mt-1">Link copied to clipboard!</div>
        <div id="validationErrors" style="display: none;" class="alert alert-danger mt-1"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" data-toggle="tooltip" onclick="getDataUrlAndCopy(this)" data-url="{{route('lead.signedproposal',urlencode(encrypt($lead->id)))}}" title='Copy To Clipboard'>
                <i class="ti ti-copy"></i>
            </button>
            {{Form::submit(__('Share via mail'),array('class'=>'btn btn-primary'))}}
        </div>
        {{Form::close()}}
    </div>
</div>
<style>
    #notification {
        display: none;
    }
</style>
<script>
    /*  txtEditor('agreement');
    txtEditor('remarks');
    txtEditor('scopeOfService');
    txtEditor('costBusiness');
    txtEditor('cancenllation'); */
    /* function getDataUrlAndCopy(button) {
        var dataUrl = button.getAttribute('data-url');
        copyToClipboard(dataUrl);
        // alert("Copied the data URL: " + dataUrl);
    } */

    function getDataUrlAndCopy(button) {

        var dataUrl = button.getAttribute('data-url');

        $('.error-message').hide().html('');
        var optionalFields = ['pdf[to][name]', 'pdf[to][designation]'];
        var pdfData = {};
        var hasError = false;
        var errorMessages = [];
        $('input[name^="pdf"],textarea[name^="pdf"]').each(function() {
            var name = $(this).attr('name');
            var value = $(this).val();

            var matches = name.match(/^pdf\[(.+?)\]\[(.+?)\]$/);
            if (matches) {
                var key = matches[1];
                var field = matches[2];

                if (!pdfData[key]) {
                    pdfData[key] = {};
                }
                pdfData[key][field] = value;

                /* if (!optionalFields.includes(field) && !value) {
                    hasError = true;
                    errorMessages.push(`The ${key} ${field} field is required.`);
                    $(this).addClass('error');
                } else {
                    $(this).removeClass('error');
                } */

                /* if (field !== 'notes' && !value) {
                    hasError = true;
                    errorMessages.push(`The ${key} ${field} field is required.`);
                    $(this).addClass('error');
                } else {
                    $(this).removeClass('error');
                } */
            }
        });

        if (hasError) {
            $('#validationErrors').html(errorMessages.join('<br>')).show();
        } else {
            $('#validationErrors').hide();
            var url = '{{route("lead.copyurl",urlencode(encrypt($lead->id)))}}';
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "pdfData": pdfData,
                },
                success: function(response) {
                    copyToClipboard(dataUrl);
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    }

    function copyToClipboard(text) {
        var tempInput = document.createElement("input");
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        showNotification();
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
</script>