@extends('layouts.admin')
@section('page-title')
{{__('Lead Information')}}
@endsection
@section('title')
<div class="page-header-title">
    {{__('Lead Information')}}
</div>
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
<li class="breadcrumb-item"><a href="{{ route('lead.index') }}">{{__('Leads')}}</a></li>
<li class="breadcrumb-item">{{__('Lead Details')}}</li>
@endsection
@section('action-btn')

@endsection
@section('content')
<?php
$billing = App\Models\ProposalInfo::where('lead_id', $lead->id)->orderby('id', 'desc')->first();
if (isset($billing) && !empty($billing)) {
    $billing = json_decode($billing->proposal_info, true);
}
$converted_to_event = App\Models\Meeting::where('attendees_lead', $lead->id)->exists();
?>
<div class="row card" style="display:none">
    <div class="col-md-12">
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
                        Event: {{ucfirst($lead->type)}}</th>
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
                    <td style="padding:5px 5px; margin-left:5px;font-size:13px;">Training Location Rental</td>
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
<div class="container-field">
    <div id="wrapper">
        <div id="page-content-wrapper">
            <div class="container-fluid xyz">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="useradd-1" class="card">
                            <div class="card-body table-border-style">
                                <div class="table-responsive">
                                    <table class="table datatable" id="datatable">
                                        <thead>
                                            <tr>
                                                <!-- <th scope="col" class="sort" data-sort="name">{{__('Lead')}}</th> -->
                                                <th scope="col" class="sort" data-sort="name">{{__('Name')}}</th>
                                                <th scope="col" class="sort" data-sort="name">{{__('Organization')}}</th>
                                                <th scope="col" class="sort" data-sort="budget">{{__('Phone')}}</th>
                                                <th scope="col" class="sort" data-sort="budget">{{__('Email')}}</th>
                                                <th scope="col" class="sort" data-sort="budget">{{__('Address')}}</th>
                                                <th scope="col" class="sort">{{__('Status')}}</th>
                                                <th scope="col" class="sort">{{__('Training')}}</th>
                                                <th scope="col" class="sort">{{__('Converted to Training')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($leads as $lead)
                                            <tr>
                                                <td>{{ucfirst($lead->name)}}</td>
                                                <td>{{ucfirst($lead->company_name)}}</td>
                                                <td>{{$lead->primary_contact}}</td>
                                                <td>{{$lead->email ?? '--'}}</td>
                                                <td>{{$lead->lead_address ?? '--'}}</td>

                                                <td>{{ __(\App\Models\Lead::$stat[$lead->lead_status]) }}</td>
                                                <td>{{$lead->type}}</td>
                                                @if(App\Models\Meeting::where('attendees_lead',$lead->id)->exists())
                                                <td> Yes </td>
                                                @else
                                                <td> No </td>
                                                @endif

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid xyz mt-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="useradd-1" class="card">

                            <div class="card-body table-border-style">
                                <h3>Lead Details</h3>
                                <hr>
                                <div class=" mt-4">
                                    @foreach($leads as $lKey => $lead)
                                    @php
                                    $trainers = \App\Models\Meeting::where('attendees_lead', $lead->id)->first();
                                    $trainerName = \App\Models\User::find($lead->assigned_user)->name;
                                    if ($trainers) {
                                    $trainer_user_data = json_decode($trainers->user_data, true);
                                    if (isset($trainer_user_data) && !empty($trainer_user_data)) {
                                    $tName = [];
                                    foreach ($trainer_user_data as $key => $value) {
                                    $tName[] = \App\Models\User::find($key)->name;
                                    }
                                    $trainerName = implode(', ', $tName);
                                    }

                                    }
                                    @endphp

                                    <h4> {{ucfirst($lead->name)}}</h4>
                                    <hr>
                                    <dl class="row">
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Attendees')}}</span></dt>
                                        <dd class="col-md-6 need_half"><span class="">{{ $lead->guest_count }}</span></dd>
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Training Location')}}</span></dt>
                                        <dd class="col-md-6 need_half"><span class="">{{ $lead->venue_selection ??'--' }}</span></dd>
                                        {{--<dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Function')}}</span></dt>
                                        <dd class="col-md-6 need_half"><span class="">{{$lead->function ?? '--'}}</span></dd>--}}
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Assigned Trainer')}}</span></dt>
                                        <dd class="col-md-6 need_half"><span class="">{{ $trainerName ?? '--' }}</span>
                                        </dd>
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('How did here about us?')}}</span></dt>
                                        <dd class="col-md-6 need_half"><span class="">{{ $lead->description ??' --' }}</span></dd>
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Training')}}</span></dt>
                                        <dd class="col-md-6 need_half"><span class="">{{ $lead->type ??' --' }}</span></dd>
                                        {{--<dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Package')}}</span></dt>
                                        <dd class="col-md-6 need_half"><span class="">
                                                <?php $package = json_decode($lead->func_package, true);
                                                if (isset($package) && !empty($package)) {
                                                    foreach ($package as $key => $value) {
                                                        echo implode(',', $value);
                                                    }
                                                } else {
                                                    echo '--';
                                                }
                                                ?>
                                            </span></dd>
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Additional Items')}}</span>
                                        </dt>
                                        <dd class="col-md-6 need_half"><span class="">
                                                <?php $additional = json_decode($lead->ad_opts, true);
                                                if (isset($additional) && !empty($additional)) {
                                                    foreach ($additional as $key => $value) {
                                                        echo implode(',', $value);
                                                    }
                                                } else {
                                                    echo "--";
                                                }

                                                ?>
                                            </span></dd>
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Any Special Requests')}}</span></dt>
                                        <dd class="col-md-6 need_half"><span class="">{{$lead->spcl_req ?? '--'}}</span></dd>
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Proposal Response')}}</span>
                                        </dt>
                                        <dd class="col-md-6 need_half"><span class="">@if(App\Models\Proposal::where('lead_id',$lead->id)->exists())
                                                <?php $proposal = App\Models\Proposal::where('lead_id', $lead->id)->first()->notes; ?>
                                                {{$proposal}}
                                                @else --
                                                @endif</span></dd>
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Estimate Amount')}}</span>
                                        </dt>
                                        <dd class="col-md-6 need_half"><span class="">{{ $grandtotal != 0 ? '$'. $grandtotal : '--' }}</span></dd>--}}
                                        @php
                                        @$imgPath = App\Models\Proposal::where('lead_id', $lead->id)->orderBy('created_at','desc')->first();
                                        @$imgPathss = explode('/', @$imgPath->image);
                                        @endphp
                                        @if($imgPath)
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Proposal signature')}}</span>
                                        </dt>
                                        <dd class="col-md-6 need_half" style="border: 1px solid #000;"><span class=""><img src="{{ asset('upload/' . @$imgPathss[1]) }}" alt="" srcset=""></span></dd>
                                        @endif
                                    </dl>
                                    {{--@php
                                    @$trainerName = \App\Models\User::where('id',$filteredMeetingsNew[$lKey]['user_id'])->first();
                                    @endphp
                                    @if($trainerName)
                                    <h4>Training Detail</h4>
                                    <hr>
                                    <dl class="row">
                                        <dt class="col-md-6 need_half"><span class="h6  mb-0">{{__('Trainer name')}}</span>
                                    </dt>
                                    <dd class="col-md-6 need_half"><span class="">

                                            <h6>{{@$trainerName->name ?? ''}}</h6>
                                        </span>
                                    </dd>
                                    </dl>
                                    @endif--}}
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid xyz mt-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="useradd-1" class="card">

                            <div class="card-body table-border-style">
                                <h3>Billing Details</h3>
                                <div class="table-responsive mt-4">
                                    <table class="table datatable" id="datatable">
                                        <thead>
                                            <tr>
                                                <!-- <th scope="col" class="sort" data-sort="name">{{__('Lead')}}</th> -->
                                                <th scope="col" class="sort" data-sort="name">{{__('Created On')}}</th>
                                                <th scope="col" class="sort" data-sort="name">{{__('Training Name')}}</th>
                                                <th scope="col" class="sort" data-sort="budget">{{__('Name')}}</th>
                                                <th scope="col" class="sort" data-sort="budget">{{__('Amount')}}</th>
                                                <th scope="col" class="sort" data-sort="budget">{{__('Due')}}</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($leads as $lead)
                                            <?php

                                            $event = App\Models\Meeting::where('attendees_lead', $lead->id)->first();
                                            if ($event) {
                                                $billing = App\Models\PaymentLogs::where('event_id', $event->id)->get();

                                                $lastpaid = App\Models\PaymentLogs::where('event_id', $event->id)->orderby('id', 'DESC')->first();

                                                if (isset($lastpaid) && !empty($lastpaid)) {
                                                    $amount = App\Models\PaymentInfo::where('event_id', $event->id)->first();
                                                    $amountpaid = 0;
                                                    foreach ($billing as $pay) {
                                                        $amountpaid += $pay->amount;
                                                    }
                                                    echo "<tr>";
                                                    echo "<td>" . Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $lastpaid->created_at)->format('M d, Y') . "</td>";
                                                    echo "<td>" . $event->name . "</td>";
                                                    echo "<td>" . $lead->name . "</td>";
                                                    echo "<td>" . $amount->amount . "</td>";
                                                    echo "<td>" . $amount->amounttobepaid - $amountpaid . "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr>";
                                                echo "<td></td>";
                                                echo "<td style='text-align: center;'><b><h6 class='text-secondary'>{$lead->name}: Lead Not Converted to Trainings Yet.</h6><b></td>";
                                                echo "<td></td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid xyz mt-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" id="useradd-1">
                            <div class="card-body table-border-style">
                                <h3>Upload Documents</h3>
                                {{Form::open(array('route' => ['lead.uploaddoc', $lead->id],'method'=>'post','enctype'=>'multipart/form-data' ,'id'=>'formdata'))}}
                                <label for="customerattachment">Attachment</label>
                                <input type="file" name="customerattachment" id="customerattachment" class="form-control" required>
                                <input type="submit" value="Submit" class="btn btn-primary mt-4" style="float: right;">
                                {{Form::close()}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card" id="useradd-1">
                            <div class="card-body table-border-style">
                                <h3>Attachments</h3>
                                <div class="table-responsive ">
                                    <table class="table table-bordered">
                                        <thead>
                                            <th>Attachment</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($docs as $doc)
                                            @if(Storage::disk('public')->exists($doc->filepath))
                                            <tr>
                                                <td>{{$doc->filename}}</td>
                                                <td><a href="{{ Storage::url('app/public/'.$doc->filepath) }}" download style="color: teal;" title="Download">View Document <i class="fa fa-download"></i></a>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('script-page')
<script>
    $(document).ready(function() {
        $('#addnotes').on('submit', function(e) {
            e.preventDefault();
            var id = <?php echo  $lead->id; ?>;
            var notes = $('input[name="notes"]').val();
            var createrid = <?php echo Auth::user()->id; ?>;

            $.ajax({
                url: "{{ route('addleadnotes', ['id' => $lead->id]) }}", // URL based on the route with the actual user ID
                type: 'POST',
                data: {
                    "notes": notes,
                    "createrid": createrid,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    location.reload();
                }
            });

        });
    });
</script>
@endpush