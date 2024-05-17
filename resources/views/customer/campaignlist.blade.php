@extends('layouts.admin')
@section('page-title')
    {{__('Campaign')}}
@endsection
@section('title')
    <div class="page-header-title">
        {{__('Campaign')}}
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">{{__('Campaigns')}}</a></li>
    <li class="breadcrumb-item">{{__('View Campaigns')}}</li>
@endsection
@section('content')
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
                                                <th scope="col" class="sort" data-sort="name">{{__('Campaign Title')}} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort" data-sort="name">{{__('Campaign Type')}} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort" data-sort="budget">{{__('Created At')}} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort">{{__('Action')}} <span class="opticy"> dddd</span></th>                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($campaignlist as $key=> $campaign)
                                                <tr>
                                                    <td><span class="budget"><b>{{ucfirst($campaign->title)}}</b></span></td>
                                                    <td><span class="budget"><b>{{ucfirst($campaign->type)}}</b></span></td>
                                                    <td><span class="budget">{{ \Carbon\Carbon::parse($campaign->created_at)->format('d M, Y')}}</span></td>
                                                    <td><button onclick="toggleRowVisibility(<?php echo $key + 1 ?>)" style="border-radius: 35px;">
                                                    <span class="dash-arrow"><i class="ti ti-chevron-right"></i> </span>
                                                    </button></td>
                                                </tr>
                                                <tr class="hidden-row" id="hiddenRow{{ $key + 1 }}" style="display: none;    background: #e6ebf2;">
                                                    <th scope="col">Users</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col" >Actions</th>
                                                    <th></th>
                                                </tr>
                                                <tr class="hidden-row" id="hiddenRowContent{{ $key + 1 }}" style="display: none;    background: #e6ebf2;">
                                                    <td><span class="budget"><b>{{ucfirst($campaign->recipients)}}</b></span></td>
                                                    <td><span class="budget"><b>{{ucfirst($campaign->description)}}</b></span></td>
                                                    <td><button type="button"style="border-radius: 35px;" title="Resend" onclick="resendcampaign(<?php  echo $campaign->id?>)">
                                                    <i class="ti ti-share"></i>
                                                </button></td>
                                                <td></td>
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
<script>
    function toggleRowVisibility(rowNumber) {
        var row = document.getElementById('hiddenRow' + rowNumber);
        var rowContent = document.getElementById('hiddenRowContent' + rowNumber);
        if (row.style.display === "table-row") {
            row.style.display = "none";
            rowContent.style.display = "none";
        } else {
            row.style.display = "table-row";
            rowContent.style.display = "table-row";
        }
    }
    function resendcampaign(id){
       $.ajax({
                url: "{{route('resend-campaign')}}",
                type: 'POST',
                data: {
                    "id": id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    console.log(data);
                   
                }
            });
    }
</script>
@endsection