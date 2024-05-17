@extends('layouts.admin')
@section('page-title')
<?php echo $_GET['cat']; ?>{{ __(' Customers') }}
@endsection
@section('title')
<?php echo $_GET['cat']; ?>{{ __(' Customers') }}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item"><a href="{{ route('siteusers') }}">{{ __('Customers') }}</a></li>
<li class="breadcrumb-item"><a href="#"><?php echo $_GET['cat']; ?></a></li>
<li class="breadcrumb-item">{{ __('Customer Details') }}</li>
@endsection
@section('content')
<div class="container-field">
    <div id="wrapper">
        <div id="page-content-wrapper">
            <div class="container-fluid xyz p0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" id="useradd-1">
                            <div class="card-body table-border-style">
                                <div class="row align-items-center ">
                                    <div class="col-md-4 need_half">
                                        <small class="h6  mb-3 mb-md-0">{{__('Name')}} </small>
                                    </div>
                                    <div class="col-md-5 need_half ">
                                        <span class="">{{ $users->name }}</span>
                                    </div>
                                    <div class="col-md-4  mt-1 need_half">
                                        <small class="h6  mb-3 mb-md-0">{{__('Email')}}</small>
                                    </div>
                                    <div class="col-md-5  mt-1 need_half">
                                        <span class="">{{ $users->email }}</span>
                                    </div>
                                    <div class="col-md-4  mt-1 need_half">
                                        <small class="h6  mb-3 mb-md-0">{{__('Phone')}}</small>
                                    </div>
                                    <div class="col-md-5  mt-1 need_half">
                                        <span class="">{{ $users->phone }}</span>
                                    </div>
                                    <div class="col-md-4  mt-1 need_half">
                                        <small class="h6  mb-3 mb-md-0">{{__('Address')}}</small>
                                    </div>
                                    <div class="col-md-5  mt-1 need_half">
                                        <span class="">{{ $users->address }}</span>
                                    </div>
                                    <div class="col-md-4  mt-1 need_half">
                                        <small class="h6  mb-3 mb-md-0">{{__('Category')}}</small>
                                    </div>
                                    <div class="col-md-5  mt-1 need_half">
                                        <span class="">{{ $users->category }}</span>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card" id="useradd-1">
                            <div class="card-body table-border-style">
                                <h3>Attachments</h3>
                                <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <th>Attachment</th>
                                        <!-- <th>Created By</th> -->
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        <?php   
                                            $files = Storage::files('app/public/External_customer/'.$users->id);
                                        ?>
                                        @foreach ($files as $file)
                                        <tr>
                                            <td>{{ basename($file) }}</td>
                                            <td><a href="{{ Storage::url($file) }}" download style="color: teal;"
                                                    title="Download">
                                                    View Document <i class="fa fa-download"></i></a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
</div>
                                <!-- <h3>Attachments</h3>
                                <?php   
                                    $files = Storage::files('app/public/External_customer/'.$users->id);
                                ?>
                                @if(isset($files) && !empty($files))

                                <div class="col-md-12" style="    display: flex;">
                                    @foreach ($files as $file)
                                    <div>
                                        <p>{{ basename($file) }}</p>
                                        <div>

                                            @if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf')
                                            <img src="{{ asset('extension_img/pdf.png') }}" alt="File"
                                                style="max-width: 100px; max-height: 150px;">
                                            @else
                                            <img src="{{ asset('extension_img/doc.png') }}" alt="File"
                                                style="max-width: 100px; max-height: 150px;">
                                            @endif
                                            <a href="{{ Storage::url($file) }}" download style=" position: absolute;">
                                                <i class="fa fa-download"></i></a>

                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif -->
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
                                        <tr><td>{{ $users->notes }}</td>
                                        <td>{{App\Models\User::where('id', $users->created_by)->first()->name}}</td>
                                        <td>{{\Auth::user()->dateFormat($users->created_at)}}</td>
                                    </tr>
                                        @foreach($notes as $note)
                                        <tr>
                                            <td>{{ucfirst($note->notes)}}</td>
                                            <td>{{(App\Models\User::where('id',$note->created_by)->first()->name)}}</td>
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
                                <form action="{{route('upload-info',urlencode(encrypt($users->id)))}}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <label for="customerattachment">Attachment</label>
                                    <input type="file" name="customerattachment" id="customerattachment"
                                        class="form-control" required>
                                    <input type="submit" value="Submit" class="btn btn-primary mt-4"
                                        style="float: right;">
                                </form>
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
                                    <input type="text" class="form-control" name="notes">
                                    <input type="submit" value="Submit"  class="btn btn-primary mt-4"
                                        style=" float: right;">
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
<style>
.list-group-flush .list-group-item {
    background: none;
}
/* body{
    overflow-y: clip;
} */
</style>
@push('script-page')
<script>
$(document).ready(function() {
    $('#addnotes').on('submit', function(e) {
        e.preventDefault();
        var id = <?php echo  $users->id; ?>;
        var notes = $('input[name="notes"]').val();
        var createrid = <?php echo Auth::user()->id ;?>;
        $.ajax({
            url: "{{ route('addusernotes', ['id' => $users->id]) }}",
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