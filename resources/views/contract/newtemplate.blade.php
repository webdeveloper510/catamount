{{ Form::open(['route' => 'contracts.store', 'method' => 'post', 'enctype' => 'multipart/form-data','id'=>'formdata'] )  }}
<div class="row">
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('name', __('Contract Name'),['class'=>'form-label']) }}
            {{ Form::text('name', '', array('class' => 'form-control','required'=>'required')) }}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('subject', __('Subject'),['class'=>'form-label']) }}
            {{ Form::text('subject', '', array('class' => 'form-control','required'=>'required')) }}
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            {{ Form::label('client_name', __('Staff Name'),['class'=>'form-label']) }}
            {{ Form::select('client_name', $client,null, array('class' => 'form-control select2','required'=>'required')) }}
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            {{Form::label('atttachment',__('Upload File'),['class'=>'form-label']) }}
            <input type="file" name="atttachment" id="atttachment" class="form-control">

        </div>
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{__('Close')}}</button>
    <button type="submit" class="btn  btn-primary">{{__('Create')}}</button>

</div>
{{ Form::close() }}
