@extends('layouts.admin')
@section('page-title')
{{__('Leads')}}
@endsection
@section('title')
<div class="page-header-title">
    {{__('Leads')}}
</div>
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
<li class="breadcrumb-item">{{__('Leads')}}</li>

@endsection
@section('action-btn')

@can('Create Lead')
<a href="#" data-url="{{ route('lead.create',['lead',0]) }}" data-size="lg" data-ajax-popup="true"
    data-bs-toggle="tooltip" data-title="{{__('Create New Lead')}}" title="{{__('Create')}}"
    class="btn btn-sm btn-primary btn-icon m-1">
    <i class="ti ti-plus"></i>
</a>
@endcan
@endsection
@section('content')
<div class="container-field">

    <div id="wrapper">
        <div id="page-content-wrapper">
            <div class="container-fluid xyz p0">

                <div class="row">
                    <div class="col-lg-12 ">
                        <div id="useradd-1" class="card">
                            <div class="card-body table-border-style">
                                <div class="table-responsive">
                                    <table class="table datatable" id="datatable">
                                        <thead>
                                            <tr>
                                                <!-- <th scope="col" class="sort" data-sort="name">{{__('Lead')}}</th> -->
                                                <th scope="col" class="sort" data-sort="name">{{__('Name')}} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort" data-sort="budget">{{__('Email')}} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort">{{__('Status')}} <span class="opticy"> dddd</span></th>
                                                <!-- <th scope="col" class="sort">{{__('Proposal Status')}}</th> -->
                                                <th scope="col" class="sort">{{__('Lead Status')}}<span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort">{{__('Created On')}}<span class="opticy"> dddd</span></th>
                                                @if(Gate::check('Show Lead') || Gate::check('Edit Lead') ||
                                                Gate::check('Delete Lead'))
                                                <th scope="col" class="text-end">{{__('Action')}} <span class="opticy"> dddd</span></th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($leads as $lead)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('lead.info',urlencode(encrypt($lead->id))) }}"
                                                        data-size="md" title="{{ __('Lead Details') }}"
                                                        class="action-item text-primary"
                                                        style="color:#1551c9 !important;">
                                                        <b> {{ ucfirst($lead->name) }}</b>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="budget">{{ $lead->email }}</span>
                                                </td>
                                                <td><select name="lead_status" id="lead_status" class="form-select"
                                                        data-id="{{$lead->id}}">
                                                        @foreach($statuss as $key => $stat)
                                                        <option value="{{ $key }}"
                                                            {{ isset($lead->lead_status) && $lead->lead_status == $key ? "selected" : "" }}>
                                                            {{ $stat }}</option>
                                                        @endforeach</td>
                                                <td>
                                                    @if($lead->status == 0)
                                                    <span
                                                        class="badge bg-info p-2 px-3 rounded">{{ __(\App\Models\Lead::$status[$lead->status]) }}</span>
                                                    @elseif($lead->status == 1)
                                                    <span
                                                        class="badge bg-warning p-2 px-3 rounded">{{ __(\App\Models\Lead::$status[$lead->status]) }}</span>
                                                    @elseif($lead->status == 2)
                                                    <span
                                                        class="badge bg-secondary p-2 px-3 rounded">{{ __(\App\Models\Lead::$status[$lead->status]) }}</span>
                                                    @elseif($lead->status == 3)
                                                    <span
                                                        class="badge bg-danger p-2 px-3 rounded">{{ __(\App\Models\Lead::$status[$lead->status]) }}</span>
                                                    @elseif($lead->status == 4)
                                                    <span
                                                        class="badge bg-success p-2 px-3 rounded">{{ __(\App\Models\Lead::$status[$lead->status]) }}</span>
                                                    @elseif($lead->status == 5)
                                                    <span
                                                        class="badge bg-warning p-2 px-3 rounded">{{ __(\App\Models\Lead::$status[$lead->status]) }}</span>
                                                    @endif
                                                </td>
                                                <td>{{\Auth::user()->dateFormat($lead->created_at)}}</td>
                                                @if(Gate::check('Show Lead') || Gate::check('Edit Lead') ||
                                                Gate::check('Delete Lead') ||Gate::check('Manage Lead') )
                                                <td class="text-end">
                                                    @if($lead->status == 4)
                                                    <div class="action-btn bg-secondary ms-2">
                                                        <a href="{{ route('meeting.create',['meeting',0])}}"
                                                            id="convertLink" data-size="md" data-url="#"
                                                            data-bs-toggle="tooltip" data-title="{{ __('Convert') }}"
                                                            title="{{ __('Convert To Event') }}" data-id="{{$lead->id}}"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="fas fa-exchange-alt"></i> </a>
                                                    </div>
                                                    @endif
                                                    @if($lead->status == 0 )
                                                    <div class="action-btn bg-primary ms-2">
                                                        <a href="javascript:void(0);" data-size="md"
                                                            data-url="{{ route('lead.shareproposal',urlencode(encrypt($lead->id))) }}"
                                                            data-ajax-popup="true" data-bs-toggle="tooltip"
                                                            data-title="{{ __('Proposal') }}"
                                                            title="{{ __('Share Proposal') }}"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="ti ti-share"></i>
                                                        </a>
                                                    </div>
                                                    @endif
                                                    @if($lead->status >= 2 )
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="{{route('lead.review',urlencode(encrypt($lead->id))) }}"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white "
                                                            data-bs-toggle="tooltip" title="{{__('Review')}}"
                                                            data-title="{{__('Review Lead')}}">
                                                            <i class="fas fa-pen"></i></a>
                                                    </div>
                                                   @endif
                                                    <div class="action-btn bg-primary ms-2">
                                                        <a href="{{route('lead.clone',urlencode(encrypt($lead->id)))}}"
                                                            data-size="md" data-url="#" data-bs-toggle="tooltip"
                                                            title="{{ __('Clone') }}" data-title="{{ __('Clone') }}"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="fa fa-clone"></i>
                                                        </a>
                                                    </div>
                                                    @if($lead->status >= 1)
                                                    <div class="action-btn bg-success ms-2">
                                                        <a href="{{route('lead.proposal',urlencode(encrypt($lead->id))) }}"
                                                            data-bs-toggle="tooltip" data-title="{{__('Proposal')}}"
                                                            title="{{__('View Proposal')}}"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white">
                                                            <i class="ti ti-receipt"></i>
                                                        </a>
                                                    </div>
                                                    @endif
                                                    @can('Show Lead')
                                                    <div class="action-btn bg-warning ms-2">
                                                        <!-- <a href="{{ route('lead.show',$lead->id) }}" title="{{__('Quick View')}}"
                                                            data-ajax-popup="true" data-title="{{__('Lead Details')}}"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="ti ti-eye"></i> -->
                                                            <a href="javascript:void(0);" data-size="md"
                                                            data-url="{{ route('lead.show',$lead->id) }}"
                                                            data-bs-toggle="tooltip" title="{{__('Quick View')}}"
                                                            data-ajax-popup="true" data-title="{{__('Lead Details')}}"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="ti ti-eye"></i>
                                                        </a>
                                                    </div>
                                                    @endcan
                                                    @if($lead->status == 0)
                                                    @can('Edit Lead')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="{{ route('lead.edit',$lead->id) }}"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white "
                                                            data-bs-toggle="tooltip" title="{{__('Details')}}"
                                                            data-title="{{__('Edit Lead')}}"><i
                                                                class="ti ti-edit"></i></a>
                                                    </div>
                                                    @endcan
                                                    @endif
                                                    @can('Delete Lead')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' =>
                                                        ['lead.destroy', $lead->id]]) !!}
                                                        <a href="javascript:void(0);"
                                                            class="mx-3 btn btn-sm  align-items-center text-white show_confirm"
                                                            data-bs-toggle="tooltip" title='Delete'>
                                                            <i class="ti ti-trash"></i>
                                                        </a>
                                                        {!! Form::close() !!}
                                                    </div>
                                                    @endcan
                                                </td>
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
        </div>
    </div>
</div>
@endsection
@push('script-page')
<script>
$(document).ready(function() {
    $('#convertLink').on('click', function(event) {
        event.preventDefault(); // Prevent the default link behavior
        
        var leadId = $(this).data('id');
        
        // Set the lead ID in localStorage after a delay
        setTimeout(function() {
            localStorage.setItem('leadId', leadId);
            
            // Redirect to the specified URL after setting the item
            window.location.href = "{{ route('meeting.create',['meeting',0])}}";
        }, 1000); // Adjust the delay time as needed (1000 milliseconds = 1 second)
    });
});
</script>
<script>
function duplicate(id) {
    var url = "{{route('lead.create',['lead',0])}}";
    $.ajax({
        url: "{{ route('meeting.lead') }}",
        type: 'POST',
        data: {
            "venue": venu,
            "_token": "{{ csrf_token() }}",
        },
        success: function(data) {
            console.log(data);
        }
    });
}
$('select[name= "lead"]').on('change', function() {
    $('#breakfast').hide();
    $('#lunch').hide();
    $('#dinner').hide();
    $('#wedding').hide();
    var venu = this.value;
    $.ajax({
        url: "{{ route('meeting.lead') }}",
        type: 'POST',
        data: {
            "venue": venu,
            "_token": "{{ csrf_token() }}",
        },
        success: function(data) {
            console.log(data);
            venue_str = data.venue_selection;
            venue_arr = venue_str.split(",");
            func_str = data.function;
            func_arr = func_str.split(",");
            $('input[name ="company_name"]').val(data.company_name);
            $('input[name ="name"]').val(data.name);
            $('input[name ="phone"]').val(data.phone);
            $('input[name ="relationship"]').val(data.relationship);
            $('input[name ="start_date"]').val(data.start_date);
            // $('input[name ="end_date"]').val(data.end_date);
            $('input[name ="start_time"]').val(data.start_time);
            $('input[name ="end_time"]').val(data.end_time);
            $('input[name ="rooms"]').val(data.rooms);
            $('input[name ="email"]').val(data.email);
            $('input[name ="lead_address"]').val(data.lead_address);
            $("select[name='type'] option[value='" + data.type + "']").prop("selected", true);
            $("input[name='bar'][value='" + data.bar + "']").prop('checked', true);
            // $("select[name='user'] option[value='"+data.assigned_user+"']").prop("selected", true);
            $("input[name='user[]'][value='" + data.assigned_user + "']").prop('checked', true);
            $.each(venue_arr, function(i, val) {
                $("input[name='venue[]'][value='" + val + "']").prop('checked', true);
            });

            $.each(func_arr, function(i, val) {
                $("input[name='function[]'][value='" + val + "']").prop('checked', true);
            });

            $('input[name ="guest_count"]').val(data.guest_count);

            var checkedFunctions = $('input[name="function[]"]:checked').map(function() {
                return $(this).val();
            }).get();
            console.log("check", checkedFunctions);

            if (checkedFunctions.includes('Breakfast') || checkedFunctions.includes('Brunch')) {
                // console.log("fdsfdsfds")
                $('#breakfast').show();
            }
            if (checkedFunctions.includes('Lunch')) {
                $('#lunch').show();
            }
            if (checkedFunctions.includes('Dinner')) {
                $('#dinner').show();
            }
            if (checkedFunctions.includes('Wedding')) {
                $('#wedding').show();
            }
        }
    });
});
$('select[name = "lead_status"]').on('change', function() {
    var val = $(this).val();
    var id = $(this).attr('data-id');
    var url = "{{route('lead.changeleadstat')}}";
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            "status": val,
            'id': id,
            "_token": "{{ csrf_token() }}"
        },
        success: function(data) {
            if(val == 1){
                show_toastr('Primary', 'Lead Activated', 'success');
            }else{
                show_toastr('Success', 'Lead InActivated', 'danger');

            }
            console.log(val)
        
        }
    });
})
</script>
@endpush