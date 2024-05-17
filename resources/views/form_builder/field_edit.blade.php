{{ Form::model($form_field, array('route' => array('form.field.update', $form->id, $form_field->id), 'method' => 'post')) }}
<div class="row" id="frm_field_data">
    <div class="col-12 form-group">
        {{ Form::label('name', __('Question Name'),['class'=>'form-label']) }}
        {{ Form::text('name', null, array('class' => 'form-control','required'=>'required')) }}
    </div>
    <div class="col-12 form-group">
        {{ Form::label('type', __('Type'),['class'=>'form-label']) }}
        {{ Form::select('type', $types,null, array('class' => 'form-control','required'=>'required')) }}
    </div>
    <div class="modal-footer">
        <button type="button" class="btn  btn-light"
            data-bs-dismiss="modal">Close</button>
            {{Form::submit(__('Update'),array('class'=>'btn btn-primary '))}}
    </div>
</div>
{{ Form::close() }}
