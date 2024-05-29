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

@$proposal = unserialize($proposal['proposal_data']);
/* $proposal_settings = unserialize($settings['proposal']);
$finalProposalArg = [];
foreach ($proposal as $proCustKey => $proCustValue) {
    $finalProposalArg[$proCustKey] = $proCustValue != NULL ? $proCustValue : $proposal_settings[$proCustKey];
} */
?>
<div class="row">
    <div class="col-lg-12">
        <div id="notification" class="alert alert-success mt-1">Link copied to clipboard!</div>
        {{ Form::model($lead, ['route' => ['lead.pdf', urlencode(encrypt($lead->id))], 'method' => 'POST','enctype'=>'multipart/form-data']) }}

        <div class="">
            <dl class="row">
                <input type="hidden" name="lead" value="{{ $lead->id }}">
                <dt class="col-md-6"><span class="h6  mb-0">{{__('Name')}}</span></dt>
                <dd class="col-md-6">
                    <input type="text" name="name" class="form-control" value="{{ $lead->name }}" readonly>
                </dd>

                <dt class="col-md-6"><span class="h6  mb-0">{{__('Recipient')}}</span></dt>
                <dd class="col-md-6">
                    <input type="email" name="email" class="form-control" value="{{ $lead->email }}" required>
                </dd>

                <dt class="col-md-12"><span class="h6  mb-0">{{__('Subject')}}</span></dt>
                <dd class="col-md-12"><input type="text" name="subject" id="Subject" class="form-control" required></dd>

                <dt class="col-md-12"><span class="h6  mb-0">{{__('Content')}}</span></dt>
                <dd class="col-md-12"><textarea name="emailbody" id="emailbody" cols="30" rows="10" class="form-control" required></textarea></dd>

                <dt class="col-md-12"><span class="h6  mb-0">{{__('Upload Document')}}</span></dt>
                <dd class="col-md-12"><input type="file" name="attachment" id="attachment" class="form-control"></dd>
                <hr class="mt-4 mb-4">

                {{--<div class="col-12  p-0 modaltitle pb-3 mb-3 flex-title">
                <h5 class="bb">{{ __('Estimated Billing Details') }}</h5>
                <span class="h6 mb-0" style="float:right;">{{__('Guest Count')}} : {{ $lead->guest_count }}</span>
        </div>
        <dl class="row">
            <div class="form-group">
                <div class="table-res">
                    <table class="table table-share">
                        <thead>
                            <tr>
                                <th>{{__('Description')}} </th>
                                <th>{{__('Cost(per person)')}} </th>
                                <th>{{__('Quantity')}} </th>
                                <th>{{__('Notes')}} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($labels as $key=> $label)
                            <tr>
                                <td>{{ucfirst($label)}}</td>
                                <td>
                                    <input type="text" name="billing[{{$key}}][cost]" value="{{ isset($leaddata[$key.'_cost']) ? $leaddata[$key.'_cost'] : '' }}" class="form-control dlr">
                                </td>
                                <td>
                                    <input type="number" name="billing[{{$key}}][quantity]" min='0' class="form-control" value="{{$leaddata[$key] ?? ''}}" required>
                                </td>
                                <td>
                                    <input type="text" name="billing[{{$key}}][notes]" class="form-control" value="{{ isset($key) && ($key !== 'hotel_rooms') ? $leaddata[$key] ?? '' : ''  }}">
                                </td>
                            </tr>
                            @endforeach
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
        </dl>--}}
        <h5 class="bb">{{ __('PDF') }}</h5>

        <dt class="col-md-3"><span class="h6  mb-0">{{__('Title')}}</span></dt>
        <dd class="col-md-9">
            <input type="text" name="title" class="form-control" id="title" value="{{__(@$proposal['title'])}}" />
        </dd>
        <dt class="col-md-3"><span class="h6  mb-0">{{__('Address')}}</span></dt>
        <dd class="col-md-9">
            <textarea name="address" class="form-control" id="address">{{__(@$proposal['address'])}}</textarea>
        </dd>
        <dt class="col-md-3"><span class="h6  mb-0">{{__('Agreement')}}</span></dt>
        <dd class="col-md-9">
            <textarea name="agreement" class="form-control" id="agreement">{{__(@$proposal['agreement'])}}</textarea>
        </dd>
        <dt class="col-md-3"><span class="h6  mb-0">{{__('Remarks')}}</span></dt>
        <dd class="col-md-9">
            <textarea name="remarks" class="form-control" id="remarks">{{__(@$proposal['remarks'])}}</textarea>
        </dd>
        <dt class="col-md-3"><span class="h6  mb-0">{{__('Footer')}}</span></dt>
        <dd class="col-md-9">
            <textarea name="footer" class="form-control" id="footer">{{__(@$proposal['footer'])}}</textarea>
        </dd>
        </dl>

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-success" data-toggle="tooltip" onclick="formSubmit(this)" data-url="{{route('lead.signedproposal',urlencode(encrypt($lead->id)))}}" title='Copy To Clipboard'>
            <i class="ti ti-copy"></i>
        </button>
        {{Form::submit(__('Share via mail'),array('class'=>'btn btn-primary'))}}
    </div>

    {{Form::close()}}
</div>
</div>
<script>
    jQuery(function($) {
        $('#agreement').richText();
        $('#remarks').richText();
        $('#address').richText();
        $('#footer').richText();
    });
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

    function formSubmit(element) {
        var dataURL = $(element).data('url');
        var url = "{{route('lead.pdf', urlencode(encrypt($lead->id)))}}";
        $(element).closest('form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('action', 'clipboard');
            $.ajax({
                url: url,
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('success');
                    copyToClipboard(dataURL);
                },
                error: function(xhr, status, error) {
                    console.log('error');
                }
            });
        });
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
</script>