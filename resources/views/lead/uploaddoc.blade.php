{{Form::open(array('route' => ['lead.uploaddoc', $id],'method'=>'post','enctype'=>'multipart/form-data' ,'id'=>'formdata'))}}
<div class="row">
    <div class="col-12">
        <div class="form-group">
            {{Form::label('upload',__('Upload'),['class'=>'form-label']) }}
            {{ Form::file('lead_file', ['class' => 'form-control', 'required' => 'required']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">Close</button>
    {{Form::submit(__('Save'),array('class'=>'btn btn-primary '))}}
</div>
{{Form::close()}}