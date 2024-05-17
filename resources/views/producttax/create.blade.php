{{Form::open(array('url'=>'product_tax','method'=>'post'))}}
<div class="row">
    <div class="col-12">
        <div class="form-group">
            {{Form::label('tax_name',__('Tax Name'),['class'=>'form-label']) }}
            {{Form::text('tax_name',null,array('class'=>'form-control','placeholder'=>__('Enter Product Brand'),'required'=>'required'))}}
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            {{Form::label('rate',__('Rate'),['class'=>'form-label']) }}
            {{Form::text('rate',null,array('class'=>'form-control','placeholder'=>__('Enter Product Brand'),'required'=>'required'))}}
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
        {{Form::submit(__('Save'),array('class'=>'btn btn-primary'))}}
    </div>
</div>
{{Form::close()}}
