<?php
$selectedvenue = explode(',', $lead->venue_selection);
$billing = App\Models\ProposalInfo::where('lead_id', $lead->id)->orderby('id', 'desc')->first();
if (isset($billing) && !empty($billing)) {
    $billing = json_decode($billing->proposal_info, true);
}
$startdate = \Carbon\Carbon::createFromFormat('Y-m-d', $lead->start_date)->format('d/m/Y');
$enddate = \Carbon\Carbon::createFromFormat('Y-m-d', $lead->end_date)->format('d/m/Y');
?>
<div class="row card" style="display:none">
    <div class="col-md-12 ">
        <h5 class="headings"><b>Billing Summary - ESTIMATE</b></h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="text-align:left; font-size:13px;text-align:left; padding:5px 5px; margin-left:5px;">
                        Name : {{ucfirst($lead->name)}}</th>
                    <th colspan="2" style="padding:5px 0px;margin-left: 5px;font-size:13px"></th>
                    <th colspan="3" style="text-align:left;text-align:left; padding:5px 5px; margin-left:5px;">
                        Date:<?php echo date("d/m/Y"); ?> </th>
                    <th style="text-align:left; font-size:13px;padding:5px 5px; margin-left:5px;">
                        Trainings: {{ucfirst($lead->type)}}</th>
                </tr>
                <tr style="background-color:#063806;">
                    <th>Description</th>
                    <th colspan="2"> Additional</th>
                    <th>Cost</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Training Location. Rental</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>

                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        ${{$billing['venue_rental']['cost'] ?? 0 }}
                    </td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        {{$billing['venue_rental']['quantity'] ?? 1}}
                    </td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        ${{$total[] = ($billing['venue_rental']['cost']?? 0)  * ($billing['venue_rental']['quantity'] ?? 1)}}
                    </td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        {{$lead->venue_selection}}
                    </td>
                </tr>

                <tr>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Brunch / Lunch /
                        Dinner Package</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        ${{$billing['food_package']['cost'] ?? 0}}</td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        {{$billing['food_package']['quantity'] ?? 1}}
                    </td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        ${{$total[] = ($billing['food_package']['cost'] ?? 0) * ($billing['food_package']['quantity'] ?? 1)}}
                    </td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        {{$lead->function}}
                    </td>

                </tr>

                <tr>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Hotel Rooms</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;"></td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        ${{$billing['hotel_rooms']['cost'] ?? 0 }}
                    </td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        {{$billing['hotel_rooms']['quantity'] ?? 1}}
                    </td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">

                        ${{$total[] =($billing['hotel_rooms']['cost'] ?? 0)* ( $billing['hotel_rooms']['quantity']??1)}}


                    </td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                </tr>

                <tr>
                    <td>-</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td colspan="3" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>

                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                </tr>
                <tr>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Total</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        ${{array_sum($total)}}
                    </td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                </tr>
                <tr>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Sales, Occupancy
                        Tax</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"> </td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        ${{ 7* array_sum($total)/100 }}
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align:left;text-align:left; padding:5px 5px; margin-left:5px;font-size:13px;">
                        Service Charges & Gratuity</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        ${{ 20 * array_sum($total)/100 }}
                    </td>

                    <td></td>
                </tr>
                <tr>
                    <td>-</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;"> </td>

                    <td></td>
                </tr>
                <tr>
                    <td style="background-color:#ffff00; padding:5px 5px; margin-left:5px;font-size:13px;">
                        Grand Total / Estimated Total</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">
                        ${{$grandtotal= array_sum($total) + 20* array_sum($total)/100 + 7* array_sum($total)/100}}
                    </td>

                    <td></td>
                </tr>
                <tr>
                    <td style="background-color:#d7e7d7; padding:5px 5px; margin-left:5px;font-size:13px;">
                        Deposits on file</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td colspan="3" style="background-color:#d7e7d7;padding:5px 5px; margin-left:5px;font-size:13px;">
                        No Deposits yet
                    </td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                </tr>
                <tr>
                    <td style="background-color:#ffff00;text-align:left; padding:5px 5px; margin-left:5px;font-size:13px;">
                        balance due</td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                    <td colspan="3" style="padding:5px 5px; margin-left:5px;font-size:13px;background-color:#9fdb9f;">
                        ${{$grandtotal= array_sum($total) + 20* array_sum($total)/100 + 7* array_sum($total)/100}}

                    </td>
                    <td colspan="2" style="padding:5px 5px; margin-left:5px;font-size:13px;"></td>
                </tr>
            </tbody>

        </table>
    </div>
</div>
<div class="row ">
    <div class="col-md-12 half-col">
        <div class="card ">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Lead')}}</span></dt>
                    <dd class="col-md-6"><span class="">{{ $lead->leadname }}</span></dd>

                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Organization')}}</span></dt>
                    <dd class="col-md-6"><span class="">{{ $lead->company_name }}</span></dd>

                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Lead Created')}}</span></dt>
                    <dd class="col-md-6"><span class="">{{\Auth::user()->dateFormat($lead->created_at)}}</span></dd>

                    <dt class="col-md-12"><span class="h4  mb-0" style="display: block;padding: 20px 0;text-align: -webkit-center;">{{__('Primary Contact')}}</span></dt>

                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Name')}}</span></dt>
                    <dd class="col-md-6">
                        <span class="">{{ @$lead->name ?? '--'}}</span>
                    </dd>

                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Phone')}}</span></dt>
                    <dd class="col-md-6"><span class="" id="phone-input">{{ $lead->primary_contact }}</span></dd>

                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Email')}}</span></dt>
                    <dd class="col-md-6"><span class="">{{ $lead->email }}</span></dd>

                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Address')}}</span></dt>
                    <dd class="col-md-6"><span class="">{{ $lead->lead_address ?? '--'}}</span></dd>

                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Title')}}</span></dt>
                    <dd class="col-md-6">
                        <span class="">{{ @$lead->relationship ?? '--'}}</span>
                    </dd>

                    @php
                    @$secondary_contact = json_decode($lead->secondary_contact);
                    @endphp


                    <dt class="col-md-12"><span class="h4  mb-0" style="display: block;padding: 20px 0;text-align: -webkit-center;">{{__('Secondary Contact')}}</span></dt>
                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Name')}}</span></dt>
                    <dd class="col-md-6">
                        <span class="">{{ @$secondary_contact->name ?? '--'}}</span>
                    </dd>
                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Phone')}}</span></dt>
                    <dd class="col-md-6">
                        <span class="" id="phone-input1">{{ @$secondary_contact->secondary_contact ?? '--'}}</span>
                    </dd>
                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Email')}}</span></dt>
                    <dd class="col-md-6">
                        <span class="">{{ @$secondary_contact->email ?? '--'}}</span>
                    </dd>
                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Address')}}</span></dt>
                    <dd class="col-md-6">
                        <span class="">{{ @$secondary_contact->lead_address ?? '--'}}</span>
                    </dd>
                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Title')}}</span></dt>
                    <dd class="col-md-6">
                        <span class="">{{ @$secondary_contact->relationship ?? '--'}}</span>
                    </dd>

                    <dt class="col-md-12"><span class="h4  mb-0" style="display: block;padding: 20px 0;text-align: -webkit-center;">{{__('Training Details')}}</span></dt>
                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Training Location')}}</span></dt>
                    <dd class="col-md-6"><span class="">{{ !empty($lead->venue_selection)? $lead->venue_selection :'--'}}</span></dd>
                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Type')}}</span></dt>
                    <dd class="col-md-6"><span class="">{{ $lead->type }}</span></dd>

                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Attendees')}}</span></dt>
                    <dd class="col-md-6"><span class="">{{ $lead->guest_count }}</span></dd>

                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Assigned Staff')}}</span></dt>
                    <dd class="col-md-6"><span class="">{{ !empty($lead->assign_user)?$lead->assign_user->name:'Not Assigned Yet'}}
                            {{ !empty($lead->assign_user)? '('.$lead->assign_user->type.')' :''}}</span></dd>

                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Trainings Date')}}</span></dt>
                    <dd class="col-md-6"><span class="">{{ \Auth::user()->dateFormat($lead->start_date) }}</span></dd>

                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Time')}}</span></dt>
                    <dd class="col-md-6"><span class="">
                            @if($lead->start_time == $lead->end_time)
                            --
                            @else
                            {{date('h:i A', strtotime($lead->start_time))}} -
                            {{date('h:i A', strtotime($lead->end_time))}}
                            @endif
                        </span>
                    </dd>

                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Any Special Requirements')}}</span></dt>
                    @if($lead->spcl_req)
                    <dd class="col-md-6"><span class="">{{$lead->spcl_req}}</span></dd>
                    @else
                    <dd class="col-md-6"><span class="">--</span></dd>
                    @endif
                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Estimate Amount')}}</span></dt>
                    <dd class="col-md-6"><span class="">{{ $grandtotal != 0 ? '$'. $grandtotal : '--' }}</span></dd>

                    <dt class="col-md-6"><span class="h6  mb-0">{{__('Status')}}</span></dt>
                    <dd class="col-md-6"><span class="">
                            @if($lead->status == 0)
                            <span class="badge bg-info p-2 px-3 rounded">{{ __(\App\Models\Lead::$status[$lead->status]) }}</span>
                            @elseif($lead->status == 1)
                            <span class="badge bg-warning p-2 px-3 rounded">{{ __(\App\Models\Lead::$status[$lead->status]) }}</span>
                            @elseif($lead->status == 2)
                            <span class="badge bg-secondary p-2 px-3 rounded">{{ __(\App\Models\Lead::$status[$lead->status]) }}</span>
                            @elseif($lead->status == 3)
                            <span class="badge bg-danger p-2 px-3 rounded">{{ __(\App\Models\Lead::$status[$lead->status]) }}</span>
                            @elseif($lead->status == 4)
                            <span class="badge bg-success p-2 px-3 rounded">{{ __(\App\Models\Lead::$status[$lead->status]) }}</span>
                            @elseif($lead->status == 5)
                            <span class="badge bg-warning p-2 px-3 rounded">{{ __(\App\Models\Lead::$status[$lead->status]) }}</span>
                            @endif
                    </dd>
                </dl>
            </div>
            @if($lead->status == 0)
            <div class="card-footer">
                <div class="w-100 text-end pr-2">
                    @can('Edit Lead')
                    <div class="action-btn bg-info ms-2">
                        <a href="{{ route('lead.edit',$lead->id) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center text-white" data-bs-toggle="tooltip" data-title="{{__('Training Edit')}}" title="{{__('Edit')}}"><i class="ti ti-edit"></i>
                        </a>
                    </div>
                    @endcan
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var phoneNumber = "<?php echo @$lead->primary_contact ?>";
        var num = phoneNumber.trim();
        var lastTenDigits = phoneNumber.substr(-10);
        var formattedPhoneNumber = '(' + lastTenDigits.substr(0, 3) + ') ' + lastTenDigits.substr(3, 3) + '-' +
            lastTenDigits.substr(6);
        $('#phone-input').text(formattedPhoneNumber);

        var phoneNumber1 = "<?php echo @$secondary_contact->secondary_contact ?>";
        if(phoneNumber1) {
        var num = phoneNumber1.trim();
        var lastTenDigits1 = phoneNumber1.substr(-10);
        var formattedPhoneNumber1 = '(' + lastTenDigits1.substr(0, 3) + ') ' + lastTenDigits1.substr(3, 3) + '-' +
            lastTenDigits1.substr(6);
        $('#phone-input1').text(formattedPhoneNumber1);
        } else {
            $('#phone-input1').text();
        }
    });
</script>