{{Form::model($productTax, array('route' => array('product_tax.update', $productTax->id), 'method' => 'PUT')) }}
<div class="row">
    <div class="col-12">
        <div class="form-group">
            {{Form::label('tax_name',__('Tax Name'),['class'=>'form-label'])}}
            {{Form::text('tax_name',null,array('class'=>'form-control','placeholder'=>__('Enter Account Type')))}}
            @error('tax_name')
            <span class="invalid-tax_name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            {{Form::label('rate',__('Rate'),['class'=>'form-label'])}}
            {{Form::text('rate',null,array('class'=>'form-control','placeholder'=>__('Enter Account Type')))}}
            @error('rate')
            <span class="invalid-rate" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light"
        data-bs-dismiss="modal">Close</button>
        {{Form::submit(__('Update'),array('class'=>'btn  btn-primary '))}}{{Form::close()}}
</div>
{{Form::close()}}
