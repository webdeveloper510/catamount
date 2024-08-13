@php
$agreestatus= \App\Models\Meeting::$status;
$settings = App\Models\Utility::settings();
@endphp
@extends('layouts.admin')
@section('page-title')
{{ __('Trainings') }}
@endsection
@section('title')
{{ __('Trainings') }}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item">{{ __('Trainings') }}</li>
@endsection
@section('action-btn')
@can('Create Training')
<div class="col-12 text-end mt-3">
    <a href="{{ route('meeting.create',['meeting',0]) }}">
        <button id="rmLocalStorage" data-bs-toggle="tooltip" title="{{ __('Create') }}" class="btn btn-sm btn-primary btn-icon m-1">
            <i class="ti ti-plus"></i></button>
    </a>
</div>
<script>
    document.getElementById('rmLocalStorage').onclick = function() {
        localStorage.removeItem('leadId');
    }
</script>
@endcan
@endsection
@section('filter')
@endsection
@section('content')
<?php

$url = 'https://oauth.airslate.com/public/oauth/token';

// Data to be sent in the POST request
$data = array(
    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
    'assertion' => 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiI5YjY5YTAzNy0zN2Q1LTQ2MzgtODM0Mi1jMGJhZjkzNGM1YWMiLCJzdWIiOiJjYzllZDA0Ni0yMzBkLTRjNjctOTAwYi04NzkzMmQzNGM5YWIiLCJpc3MiOiJvYXV0aC5haXJzbGF0ZS5jb20iLCJpYXQiOjE3MjEwMzkzODIsImV4cCI6NDg3NjcxMjkzMCwic2NvcGUiOiJlbWFpbCJ9.LpEPTjeSA_TGNTvkTZsk4cnBKKEZbfIShxSmWxhER5HZ7c_1ebMpVQwB-00gzU-mX_FdV6Vd4bAhn5IuX0TCo6cuqm5Uw7wbgMIiLU8hq8DYma3tV6Oikpv1UUPJR1gtVk8BfUGtSMMf23ZkPNDLkDxY2Gvf35llH5W7RWQwrMcF4w2ux9ZcitwTZ2Du6iaJryrY41IPeHhJHPNbVEphQTBAjDUGQdfUoHrhkDS4Fiu7VYHuSITCsk9C2wglMiBTgC3-LwSz3t43PwDqXKkK952L4XO3Nmfr1w29x9tRjB4co_R3wGEy1HpVPjUJ6loYEA_jrLt4_TIQW9I7nnIJEw'
);

// Initialize cURL
$ch = curl_init();

// Set the URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Accept: application/json',
    'Content-Type: application/x-www-form-urlencoded'
));

// Execute the request
$response = curl_exec($ch);

// Check for errors
if ($response === FALSE) {
    die(curl_error($ch));
}

// Close cURL resource
curl_close($ch);

// Decode and print the response
$token_data = json_decode($response, true);

$token_value = $token_data['access_token'];
?>
<div class="container-field">
    <div id="wrapper0">
        <div id="page-content-wrapper" class="p0">
            <div class="container-fluid xyz p0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" id="useradd-1">
                            <div class="card-body table-border-style">
                                <div class="table-responsive overflow_hidden">
                                    <table id="datatable" class="table datatable align-items-center">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="sort" data-sort="name">{{ __('Leads') }} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort" data-sort="status">{{ __('Status') }} <span class="opticy"> dddd</span></th>
                                                <th scope="col" class="sort" data-sort="completion">
                                                    {{ __('Date Start') }} <span class="opticy"> dddd</span>
                                                </th>
                                                <th scope="col" class="sort" data-sort="completion">{{ __('Trainings') }}
                                                    <span class="opticy"> dddd</span>
                                                </th>
                                                <th scope="col" class="sort" data-sort="completion">
                                                    {{ __('Assigned Staff') }} <span class="opticy"> dddd</span>
                                                </th>
                                                @if (Gate::check('Show Training') || Gate::check('Edit Training') ||
                                                Gate::check('Delete Training'))
                                                <th scope="col" class="text-end">{{ __('Action') }} <span class="opticy"> dddd</span></th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($meetings as $meeting)
                                            <tr>
                                                {{--<td>
                                                    <a href="{{ route('meeting.edit', $meeting->id) }}" data-size="md" data-title="{{ __('Training Details') }}" class="action-item text-primary" style=" color: #1551c9 !important;">
                                                @if($meeting->attendees_lead != 0)
                                                {{ucfirst(\App\Models\Lead::where('id',$meeting->attendees_lead)->pluck('leadname')->first())}}
                                                @else
                                                {{ucfirst($meeting->eventname)}}
                                                @endif
                                                </a>
                                                </td>--}}
                                                <td>
                                                    <?php $contractor_name = ""; ?>
                                                    @if($meeting->attendees_lead != 0)
                                                    <?php $leaddata = \App\Models\Lead::where('id', $meeting->attendees_lead)->first() ?>
                                                    @if(isset($leaddata) && !empty($leaddata))
                                                    <a href="{{ route('lead.info',urlencode(encrypt($leaddata->id)))}}" data-size="md"
                                                        data-title="{{ __('Event Details') }}"
                                                        class="action-item text-primary"
                                                        style=" color: #1551c9 !important;">
                                                        {{ucfirst($leaddata->leadname)}}
                                                        <?php $contractor_name = ucfirst($leaddata->leadname); ?>
                                                    </a>
                                                    @endif
                                                    @else
                                                    <a href="{{route('meeting.detailview',urlencode(encrypt($meeting->id)))}}"
                                                        data-size="md" title="{{ __('Detailed view ') }}"
                                                        class="action-item text-primary" style=" color: #1551c9 !important;">
                                                        {{ucfirst($meeting->eventname)}}</a>
                                                    <?php $contractor_name = ucfirst($meeting->eventname); ?>
                                                    @endif
                                                </td>
                                                <td>

                                                    <select name="drop_status" id="drop_status" class="form-select" data-id="{{$meeting->id}}">
                                                        @foreach($agreestatus as $key => $stat)
                                                        <option value="{{ $key }}" {{ isset($meeting->status) && $meeting->status == $key ? "selected" : "" }}>
                                                            {{ $stat }}
                                                        </option>
                                                        @endforeach
                                                    </select>


                                                    {{-- @if ($meeting->status == 0)
                                                    <span class="badge bg-info p-2 px-3 rounded">{{ __(\App\Models\Meeting::$status[$meeting->status]) }}</span>
                                                    @elseif($meeting->status == 1)
                                                    <span class="badge bg-warning p-2 px-3 rounded">{{ __(\App\Models\Meeting::$status[$meeting->status]) }}</span>
                                                    @elseif($meeting->status == 2)
                                                    <span class="badge bg-success p-2 px-3 rounded">{{ __(\App\Models\Meeting::$status[$meeting->status]) }}</span>
                                                    @elseif($meeting->status == 3)
                                                    <span class="badge bg-success p-2 px-3 rounded">{{ __(\App\Models\Meeting::$status[$meeting->status]) }}</span>
                                                    @elseif($meeting->status == 4)
                                                    <span class="badge bg-warning p-2 px-3 rounded">{{ __(\App\Models\Meeting::$status[$meeting->status]) }}</span>
                                                    @elseif($meeting->status == 5)
                                                    <span class="badge bg-danger p-2 px-3 rounded">{{ __(\App\Models\Meeting::$status[$meeting->status]) }}</span>

                                                    @endif--}}
                                                </td>
                                                <td>
                                                    <span class="budget">{{ \Auth::user()->dateFormat($meeting->start_date) }}</span>
                                                </td>
                                                <td>
                                                    <span class="budget">{{ $meeting->type }}</span>
                                                </td>

                                                <td>
                                                    <span class="budget">{{-- App\Models\User::where('id',$meeting->user_id)->pluck('name')->first() --}} {{$meeting->trainer_data}}</span>
                                                </td>
                                                @if (Gate::check('Show Training') || Gate::check('Edit Training') ||
                                                Gate::check('Delete Training'))
                                                <td class="text-end">
                                                    @if($meeting->status == 0)
                                                    <div class="action-btn bg-primary ms-2">
                                                        <a href="#" data-size="md" data-url="{{ route('meeting.share', $meeting->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-title="{{ __('Event Details') }}" title="{{ __('Share') }}" class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="ti ti-share"></i>
                                                        </a>
                                                    </div>
                                                    @elseif($meeting->status == 1 ||$meeting->status == 4)
                                                    <div class="action-btn bg-primary ms-2">
                                                        <a href="#" data-size="md" data-title="{{ __('Agreement') }}" title="{{ __('Agreement Sent') }}" data-bs-toggle="tooltip" class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="ti ti-clock"></i>
                                                        </a>
                                                    </div>
                                                    @elseif($meeting->status == 2)
                                                    <div class="action-btn bg-primary ms-2">
                                                        <a href="{{route('meeting.review',urlencode(encrypt($meeting->id)))}}" data-size="md" data-title="{{ __('Agreement') }}" title="{{ __('Review Agreement') }}" data-bs-toggle="tooltip" class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="fa fa-pen"></i>
                                                        </a>
                                                    </div>
                                                    @endif
                                                    @if(App\Models\Billing::where('event_id',$meeting->id)->exists())
                                                    <div class="action-btn bg-success ms-2">
                                                        <a href="{{route('meeting.agreement',urlencode(encrypt($meeting->id))) }}" target="_blank" data-bs-toggle="tooltip" data-title="{{__('Agreement')}}" title="{{__('View Agreement')}}" class="mx-3 btn btn-sm d-inline-flex align-items-center text-white">
                                                            <i class="ti ti-receipt"></i>
                                                        </a>
                                                    </div>

                                                    @endif
                                                    @can('Show Training')
                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="#" data-size="md" data-url="{{ route('meeting.show', $meeting->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-title="{{ __('Training Details') }}" title="{{ __('Quick View') }}" class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                            <i class="ti ti-eye"></i>
                                                        </a>
                                                    </div>
                                                    @endcan
                                                    @can('Edit Training')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="{{ route('meeting.edit', $meeting->id) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center text-white" data-bs-toggle="tooltip" data-title="{{ __('Details') }}" title="{{ __('Edit') }}"><i class="ti ti-edit"></i></a>
                                                    </div>
                                                    @if($meeting->is_contract_accepted != 1 && $meeting->status == 3)
                                                    <div class="action-btn bg-info ms-2 cursor" onclick="setContractorDetails('<?= $contractor_name ?>' , '<?= $meeting->id ?>')" data-toggle="modal" data-target="#myModal" data-title="{{ __('Share contract') }}">
                                                        <i class="ti ti-send"></i></a>
                                                    </div>
                                                    @endif

                                                    @if($meeting->is_contract_accepted == 1)
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="{{ url('/download-contract').'/'.$meeting->flow_id }}"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white"
                                                            data-bs-toggle="tooltip" data-title="{{ __('Details') }}"
                                                            title="{{ __('Download Contract') }}" target="_blank"><i class="ti ti-download"></i></a>
                                                    </div>
                                                    @endif
                                                    @endcan
                                                    @can('Delete Training')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' =>
                                                        ['meeting.destroy', $meeting->id]]) !!}

                                                        <a href="#!" class="mx-3 btn btn-sm   align-items-center text-white show_confirmdlt" data-bs-toggle="tooltip" title='Delete'>
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
<div class="modal" tabindex="-1" role="dialog" id="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:900px !important; margin-left:-65px !important;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Send Contract to <span id="contractor_name"></span></h5>
                <button type="button" id="close_button" class="close btn btn-primary" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!--<div class="col-4">-->
                    <!--    <label>Template name</label>-->
                    <!--    <input class="form-control" id="template_name">-->
                    <!--</div>-->

                    <!--<div class="col-4">-->
                    <!--    <label>Template description</label>-->
                    <!--    <input class="form-control" id="template_description">-->
                    <!--</div>-->

                    <div class="col-md-4">

                        <!--<select class="form-control" id="selected_doc">-->
                        <!--    <option value="">Please select a Doc</option>-->
                        <!--    <option value="Air_Doc.docx">Dynamic Doc</option>-->
                        <!--</select>-->

                        <select class="form-control" id="selected_template">
                            <opiton selected>Select a template</opiton>
                        </select>

                    </div>

                    <!--<div class="col-md-4">-->
                    <!--    <label for="upload" class="file-upload-label">Upload the Doc file</label>-->
                    <!--    <input type="file" id="fileInput" class="form-control file-upload" accept=".doc, .docx">-->
                    <!--    <input type="hidden" id="base64Output">-->

                    <!--</div>-->

                    <div class="col-4">
                        <!--<button onclick="createTemplate()" class="mt-2 btn btn-info">Send Contract</button>-->
                        <!--<button onclick="sendEventContract()" class=" btn btn-info">Send Contract</button>-->
                        <button onclick="sendContract()" class=" btn btn-info">Send Contract</button>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<div class="modals"><!-- Place at bottom of page --></div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<style>
    .cursor {
        cursor: pointer;
    }

    .modals {
        display: none;
        position: fixed;
        z-index: 1100;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: rgba(255, 255, 255, .8) url('https://thesectoreight.com/public/img/loader.gif') 50% 50% no-repeat;
    }

    body.loading .modals {
        overflow: hidden;
    }

    body.loading .modals {
        display: block;
    }
</style>
@endsection
@push('script-page')
<script>
    $body = $("body");
    var event_id_number = '';
    var template_id = '';
    var template_version_id = "";
    var document_id = "";
    let loadCount = 0;

    allTemplates();

    function setContractorDetails(con_name, event_id) {

        $("#contractor_name").text(con_name);
        event_id_number = event_id;
        console.log('check---------------------', con_name, event_id)
    }


    function sendContract() {

        var template_id = $("#selected_template").val();

        if (template_id == "") {

            alert("Please select a template first")
            return
        }

        $body.addClass("loading");

        $.ajax({
            url: "<?= url('send-event-contract') ?>",
            type: 'POST',
            data: {
                "template_id": template_id,
                "event_id_number": event_id_number,
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                console.log('send-event-contract------', data);
                $body.removeClass("loading");
                let result = JSON.parse(data);
                console.log('send-event-contract------', result);
                $(".close").trigger("click");
                if (result.code == 200) {
                    $("#selected_template").val("")

                    setTimeout(() => {
                        show_toastr('Success', result.data + " to " + result.email, 'success');
                    }, 300);

                    // alert(result.data+" to "+ result.email);
                } else {
                    alert("Somethingh happen wrong on server side. Please try again")
                }

            },
            error: function() {
                alert(' server error---' + error);
                $body.removeClass("loading");
            }
        });
    }


    function allTemplates() {

        let organization_id = "<?= $settings['organization_id'] ?>";
        // $body.addClass("loading");
        const template_list_settings = {
            async: true,
            crossDomain: true,
            url: `https://api.airslate.io/v1/organizations/${organization_id}/templates?per_page=100000`,
            method: 'GET',
            headers: {
                Accept: 'application/json',
                Authorization: 'Bearer ' + "<?= $token_value ?>"
            }
        };

        $.ajax(template_list_settings).done(function(response) {

            // $body.removeClass("loading");
            console.log('template_list_settings----', response);


            let template_option_html = `<option value="">Select a template</option>`;
            if (response.data.length > 0) {

                for (let template of response.data) {

                    template_option_html += ` <option value="${template.id}">${template.name}</option>`;
                }


            }

            $("#selected_template").html(template_option_html);
        });
    }


    function sendEventContract() {

        var doc_seleceted = $("#selected_doc").val();

        if (doc_seleceted == "") {

            alert("Please select a Doc first")
            return
        }



        $.ajax({
            url: "<?= url('send-event-contract') ?>",
            type: 'POST',
            data: {
                "event_id_number": event_id_number,
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                console.log('send-event-contract------', data);

                let result = JSON.parse(data);

                if (result.code == 200) {
                    alert(result.data);
                } else {
                    alert("Somethingh happen wrong on server side. Please try again")
                }

            }
        });
    }





    function createTemplate() {

        let template_name = $("#template_name").val();
        let template_description = $("#template_description").val();

        template_name = "template-" + Date.now() + Math.floor(Math.random() * 1000);
        template_description = "template-description -" + Date.now() + Math.floor(Math.random() * 1000);
        if (template_name == '') {


            alert("Template name is required");
            return;
        }

        if (template_description == '') {


            alert("Template description is required");
            return;
        }

        let data = {
            name: template_name,
            description: template_description,
            redirect_url: "https://thesectoreight.com/send-contract"
        }

        console.log('start-----', data)


        //   Create template
        // $body.addClass("loading");
        const create_template_settings = {
            async: true,
            crossDomain: true,
            url: 'https://api.airslate.io/v1/organizations/82391828-2300-0000-0000D981/templates',
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                Authorization: 'Bearer ' + "<?= $token_value ?>"
            },
            processData: false,
            data: JSON.stringify(data)
        };

        console.log('start-----')

        $.ajax(create_template_settings).done(function(response) {
            console.log('Create Template-', response);

            template_id = response.id
            //   template_id = "CCBC8875-8700-0000-0000BA29";
            uploadDocToTemplate();
            //   allTemplates();
        });
    }



    $('#fileInput').on('change', function(event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // var base64String = e.target.result;
                var base64String = e.target.result.split(',')[1];
                $('#base64Output').val(base64String);
                console.log('Base64 String:', base64String);
            };
            reader.readAsDataURL(file);
        }
    });


    // Upload Doc To Template


    function uploadDocToTemplate() {

        const organization_id = '82391828-2300-0000-0000D981';
        const base64Content = $("#base64Output").val(); // Replace with your actual base64 content

        if (template_id == '') {

            alert("Please select a template");
            return
        }

        if (base64Content == '') {

            alert("Please upload a Doc");
            return
        }

        const url = `https://api.airslate.io/v1/organizations/${organization_id}/templates/${template_id}/documents`;

        // const data = {
        //     "name": "W-9.pdf",
        //     "type": "PDF",
        //     "content": base64Content
        // };

        const data = {
            "name": "NDA.pdf",
            "type": "DOC_GENERATION",
            "content": base64Content
        };

        $.ajax({
            url: url,
            type: 'POST',
            headers: {
                'Authorization': 'Bearer ' + "<?= $token_value ?>",
                'Content-Type': 'application/json'
            },
            data: JSON.stringify(data),
            success: function(response) {
                console.log('uploadDocToTemplate --Response:', response);
                document_id = response.id;
                getTemplateVersions();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    function getTemplateVersions() {

        const settings = {
            async: true,
            crossDomain: true,
            url: `https://api.airslate.io/v1/organizations/82391828-2300-0000-0000D981/templates/${template_id}/versions`,
            method: 'GET',
            headers: {
                Accept: 'application/json',
                Authorization: 'Bearer ' + "<?= $token_value ?>",
            }
        };

        $.ajax(settings).done(function(response) {
            console.log(response);

            template_version_id = response.data[0].id;

            publishTemplateVersion();
        });
    }

    function publishTemplateVersion() {

        const settings = {
            async: true,
            crossDomain: true,
            url: `https://api.airslate.io/v1/organizations/82391828-2300-0000-0000D981/templates/${template_id}/versions/${template_version_id}/publish`,
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                Authorization: 'Bearer ' + "<?= $token_value ?>",
            },
            processData: false,
            data: '{\n  "description": "Version 2 after edits"\n}'
        };

        $.ajax(settings).done(function(response) {
            console.log('publishTemplateVersion-----', response);
            runWorkflow()
        });
    }


    function runWorkflow() {
        console.log("run work flow---")

        $.ajax({
            url: `https://api.airslate.io/v1/organizations/82391828-2300-0000-0000D981/templates/${template_id}/flows`,
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + "<?= $token_value ?>",
                'Content-Type': 'application/json'
            },
            data: JSON.stringify({
                documents: [{
                    "id": `${document_id}`,
                    "fields": [{
                        "name": "EmployeeName",
                        "value": $("#contractor_name").text()
                    }]
                }],
                invites: [],
                share_links: [{
                    auth_method: 'none',
                    signer_identity: 'test@lotusus.com',
                    expire: 14400,
                    step_name: 'Recipient 1'
                }],
                webhooks: [{
                    event_name: 'flow.completed',
                    callback: {
                        url: 'https://thesectoreight.com/testing'
                    }
                }]
            }),
            success: function(response) {
                console.log('Success workflow:', response);
                alert(response.share_links[0].url)
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
            }
        });

    }

    updateContractStatus();
    setInterval(() => {
        updateContractStatus();
    }, 5000);

    function updateContractStatus() {

        console.log('updateContractStatus------')
        $.ajax({
            url: "<?= url('cron-get-contract') ?>",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}"
            },
            success: function(data) {
                // console.log('data----'  , data)

                // console.log(val)

            }
        });
    }


    $('select[name="drop_status"]').on('change', function() {
        var val = $(this).val();
        var id = $(this).attr('data-id');
        var url = "{{route('event.changeagreementstat')}}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "status": val,
                'id': id,
                "_token": "{{ csrf_token() }}"
            },
            success: function(data) {
                console.log(data)
                if (data == 1) {

                    show_toastr('Primary', 'Event Status Updated Successfully', 'success');
                    location.reload();
                } else {
                    show_toastr('Success', 'Event Status is not updated', 'danger');

                }
            }
        });
    })


    updateContractStatus();
    setInterval(() => {
        updateContractStatus();
    }, 5000);

    function updateContractStatus() {

        console.log('updateContractStatus------')
        // $.ajax({
        //     url: "<?= url('cron-get-contract') ?>",
        //     type: 'POST',
        //     data: {
        //         "_token": "{{ csrf_token() }}"
        //     },
        //     success: function(data) {
        //         // console.log('data----'  , data)

        //         // console.log(val)

        //     }
        // });
    }


    /*  $(document).on('change', 'select[name=parent]', function() {

         var parent = $(this).val();

         getparent(parent);
     });

     function getparent(bid) {

         $.ajax({
             url: '{{ route("meeting.getparent") }}',
             type: 'POST',
             data: {
                 "parent": bid,
                 "_token": "{{ csrf_token() }}",
             },
             success: function(data) {
                 console.log(data);
                 $('#parent_id').empty();
                 {
                     {
                         $('#parent_id').append('<option value="">{{__("Select Parent")}}</option>');
                     }
                 }
                 $.each(data, function(key, value) {
                     $('#parent_id').append('<option value="' + key + '">' + value + '</option>');
                 });
             }
         });
     } */
</script>
@endpush