@extends('layouts.admin')
@section('page-title')
{{__('Lead Client')}}
@endsection
@section('title')
<div class="page-header-title">
    {{__('Lead Client')}}
</div>
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
<li class="breadcrumb-item"><a href="{{ route('siteusers') }}">{{__('Clients')}}</a></li>
<li class="breadcrumb-item"><a href="{{ route('lead_customers') }}">{{__('Lead Clients')}}</a></li>
<li class="breadcrumb-item">{{__('Client Details')}}</li>
@endsection
@section('action-btn')

@endsection
@section('content')
<div class="container-field">
    <div id="wrapper">

        <div id="page-content-wrapper">
            <div class="container-fluid xyz p0">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="useradd-1" class="card">
                            <div class="card-body table-border-style">
                                <div class="row align-items-center">
                                    <div class="table-responsive">
                                        <table class="table datatable" id="datatable">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="sort" data-sort="name">{{__('Name')}}</th>
                                                    <th scope="col" class="sort" data-sort="budget">{{__('Training Type')}}</th>
                                                    <th scope="col" class="sort">{{__('Attendees')}}</th>
                                                    <th scope="col" class="sort">{{__('Event Date')}}</th>
                                                    <th scope="col" class="sort">{{__('Converted to event')}}</th>
                                                    <th scope="col" class="sort">{{__('Created On')}}</th>
                                                    <th scope="col" class="sort">{{__('Lead Details')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($leads as $lead)
                                                <tr>
                                                    <td>
                                                        {{ ucfirst($lead->name) }}
                                                    </td>
                                                    <td><b> {{ ucfirst($lead->type) }}</b></td>
                                                    <td>
                                                        <span class="budget">{{ $lead->guest_count }}</span>
                                                    </td>
                                                    <td>{{\Auth::user()->dateFormat($lead->start_date)}}</td>
                                                    <td>{{ ($lead->converted_to == 0 ? 'No': 'Yes') }}</td>
                                                    <td>{{\Auth::user()->dateFormat($lead->created_at)}}</td>
                                                    <td class="text-end">
                                                        @can('Show Lead')
                                                        <div class="action-btn bg-warning ms-2">
                                                            <a href="javascript:void(0);" data-size="md" data-url="{{ route('lead.show',$lead->id) }}" data-bs-toggle="tooltip" title="{{__('Quick View')}}" data-ajax-popup="true" data-title="{{__('View Lead Details')}}" class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
                                                                <i class="ti ti-eye"></i>
                                                            </a>
                                                        </div>
                                                        @endcan
                                                    </td>

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
                        <div class="col-lg-6">
                            <div class="card" id="useradd-1">
                                <div class="card-body table-border-style">
                                    <h3>Attachments</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <th>Attachment</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                                @foreach (@$docs as $doc)
                                                @if(Storage::disk('public')->exists($doc->filepath))
                                                <tr>
                                                    <td>{{$doc->filename}}</td>
                                                    <td><a href="{{ Storage::url('app/public/'.$doc->filepath) }}" download style="color: teal;" title="Download">View Document<i class="fa fa-download"></i></a>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card" id="useradd-1">
                                <div class="card-body table-border-style">
                                    <h3>Notes</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <th>Notes</th>
                                                <th>Created By</th>
                                                <th>Date</th>
                                            </thead>
                                            <tbody>
                                                @foreach(@$notes as $note)
                                                <tr>
                                                    <td>{{ucfirst($note->notes)}}</td>
                                                    <td>{{(App\Models\User::where('id',$note->created_by)->first()->name)}}
                                                    </td>
                                                    <td>{{\Auth::user()->dateFormat($note->created_at)}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
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

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body table-border-style">
                                    <h3>Add Notes/Comments</h3>
                                    <form method="POST" id="addnotes">
                                        @csrf
                                        <label for="notes">Notes</label>
                                        <input type="text" class="form-control" name="notes" required>
                                        <input type="submit" value="Submit" class="btn btn-primary mt-4" style=" float: right;">
                                    </form>
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
                        show_toastr('Primary', 'Note added.', 'success');
                        location.reload();
                    }
                });

            });
        });
    </script>
    @endpush