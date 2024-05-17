@php
$settings = App\Models\Utility::settings();
if(isset($settings['fixed_billing'])&& !empty($settings['fixed_billing'])){
$billings = json_decode($settings['fixed_billing'],true);
}
if(isset($settings['additional_items'])&& !empty($settings['additional_items'])){
$additional_items = json_decode($settings['additional_items'],true);
}

$labels =
[
'venue_rental' => 'Venue',
'hotel_rooms'=>'Hotel Rooms',
'equipment'=>'Tent, Tables, Chairs, AV Equipment',
'setup' =>'Setup',
'bar_package'=>'Bar Package',
'special_req' =>'Special Requests/Other',
'food_package'=>'Food Package',
'additional_items' =>'Additional Items'
];
$meetingData = [
'venue_rental' => $event->venue_selection,
'hotel_rooms'=>$event->room,
'equipment' =>$event->spcl_request,
'bar_package' => $event->bar . ((isset($event->bar_package) && !empty($event->bar_package)) ? ('(' . $event->bar_package . ')') : ''),
'food_package' => ((isset($event->func_package) && !empty($event->func_package)) ? ( $event->func_package ) : ''),
'additional_items' => $event->ad_opts,
'setup' =>''
];
// Split the 'food_package' string into an array of items
$foodItems = explode(',', $meetingData['food_package']);

// Initialize the total cost
$totalFoodPackageCost = 0;
if(isset($billings) && !empty($billings)){
// Check dynamically for each item in 'food_package'
    foreach ($foodItems as $foodItem) {
        // Remove any extra spaces
        $foodItem = trim($foodItem);

        // Check if the item exists in the billingObject and has a cost
        foreach ($billings as $category => $categoryItems) {
            if (is_array($categoryItems) && isset($categoryItems[$foodItem])) {
                $totalFoodPackageCost += $categoryItems[$foodItem];
                break; // Break out of the inner loop once a match is found
            }
        }
    }
    $meetingData['food_package_cost'] = $totalFoodPackageCost;
}
$additionalItemsCost = 0;
if(isset($billings) && !empty($billings)){
foreach ($additional_items as $item) {
    foreach ($item as $itemName => $itemCost) {
        if (in_array($itemName, explode(',', $meetingData['additional_items']))) {
            $additionalItemsCost += $itemCost;
        }
    }
}
$meetingData['additional_items_cost'] = $additionalItemsCost;
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
$meetingData['bar_package_cost'] = 8;
$meetingData['food_package_cost'] = $totalFoodPackageCost;
$meetingData['additional_items_cost'] = $additionalItemsCost ;
$meetingData['special_req_cost'] =  $billings['special_req'] ?? '';
$meetingData['setup_cost'] = '';
@endphp
{{Form::open(array('url'=>'billing','method'=>'post','enctype'=>'multipart/form-data' ,'id'=>'formdata'))}}
<div class="col-md-12">
    <div class="form-group">
        <table class="table">
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
                        <input type="text" name="billing[{{$key}}][cost]" value="${{ isset($meetingData[$key.'_cost']) ? $meetingData[$key.'_cost'] : '' }}" class="form-control">
                    </td>
                    <td>
                        <input type="number" name="billing[{{$key}}][quantity]" min='0' class="form-control" value="{{$meetingData[$key] ?? ''}}" required>
                    </td>
                    <td>
                        <input type="text" name="billing[{{$key}}][notes]" class="form-control" value="{{ ($key !== 'hotel_rooms') ? $meetingData[$key] ?? '' : '' }}">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="form-group">
        <label class="form-label"> Deposit on file: </label>
        <input type="number" name="deposits" min='0' class="form-control" required>
    </div>
</div>
{{Form::submit(__('Save'),array('class'=>'btn btn-primary '))}}
{{ Form::close() }}    
<style>
    .modal-dialog.modal-md {
        max-width: max-content;
    }
</style>