@php
    $settings = App\Models\Utility::settings();
    $plansettings = App\Models\Utility::plansettings();

@endphp
{{ Form::open(['route' => ['invoice.storeitem', $invoice->id]]) }}
<div class="row">
    @if (isset($plansettings['enable_chatgpt']) && $plansettings['enable_chatgpt'] == 'on')
        <div class="text-end">
            <a href="#" data-size="md" class="btn btn-sm btn-primary " data-ajax-popup-over="true" data-size="md"
                data-title="{{ __('Generate content with AI') }}" data-url="{{ route('generate', ['invoice item']) }}"
                data-toggle="tooltip" title="{{ __('Generate') }}">
                <i class="fas fa-robot"></span><span class="robot">{{ __('Generate With AI') }}</span></i>
            </a>
        </div>
    @endif
    <div class="form-group col-md-6">
        {{ Form::label('item', __('Item'), ['class' => 'form-label']) }}
        {{ Form::select('item', $items, null, ['class' => 'form-control', 'required' => 'required']) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('quantity', __('Quantity'), ['class' => 'form-label']) }}
        {{ Form::number('quantity', null, ['class' => 'form-control quantity', 'required' => 'required']) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('price', __('Price'), ['class' => 'form-label']) }}
        {{ Form::number('price', null, ['class' => 'form-control price', 'required' => 'required', 'stage' => '0.01']) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('discount', __('Discount'), ['class' => 'form-label']) }}
        {{ Form::number('discount', null, ['class' => 'form-control discount']) }}
    </div>
    <div class="form-group col-md-12">
        {{ Form::label('tax', __('Tax'), ['class' => 'form-label']) }}
        {{ Form::hidden('tax', null, ['class' => 'form-control taxId']) }}
        <div class="row">
            <div class="col-md-12">
                <div class="tax"></div>
            </div>
        </div>
    </div>
    <div class="form-group col-md-12">
        {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
        {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '2']) !!}
    </div>
    <div class="col-md-12">
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
            {{ Form::submit(__('Create'), ['class' => 'btn btn-primary']) }}
        </div>
    </div>
</div>
{{ Form::close() }}
