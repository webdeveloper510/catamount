@php
$settings = App\Models\Utility::settings();
@endphp
{{ Form::open(['url' => 'plan', 'enctype' => 'multipart/form-data']) }}
<div class="row">
    @if (!empty($settings['chatgpt_key']))
    <div class="text-end">
        <a href="#" data-size="md" class="btn btn-sm btn-primary" data-ajax-popup-over="true" data-size="md"
            data-title="{{ __('Generate content with AI') }}" data-url="{{ route('generate', ['plan']) }}"
            data-toggle="tooltip" title="{{ __('Generate') }}">
            <i class="fas fa-robot"></span><span class="robot">{{ __('Generate With AI') }}</span></i>
        </a>
    </div>
    @endif
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control font-style', 'placeholder' => __('Enter Plan Name'), 'required' => 'required']) }}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group ">
            {{ Form::label('price', __('Price'), ['class' => 'form-label']) }}
            {{ Form::number('price', null, ['class' => 'form-control', 'placeholder' => __('Enter Plan Price'), 'step' => '0.01']) }}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group ">
            {{ Form::label('max_user', __('Maximum User'), ['class' => 'form-label']) }}
            {{ Form::number('max_user', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Plan Price')]) }}
            <span class="small"><b>{{ __('Note: "-1" for lifetime') }}</b></span>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group ">
            {{ Form::label('max_account', __('Maximum Account'), ['class' => 'form-label']) }}
            {{ Form::number('max_account', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Maximum Account')]) }}
            <span class="small"><b>{{ __('Note: "-1" for lifetime') }}</b></span>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('max_contact', __('Maximum Contact'), ['class' => 'form-label']) }}
            {{ Form::number('max_contact', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Maximum Contact')]) }}
            <span class="small"><b>{{ __('Note: "-1" for lifetime') }}</b></span>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('duration', __('Duration'), ['class' => 'form-label']) }}
            {!! Form::select('duration', $arrDuration, null, [
                'class' => 'form-control',
                'required' => 'required',
                'placeholder' => __('Enter Duration'),
            ]) !!}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('storage_limit', __('Storage Limit'), ['class' => 'form-label']) }}
            <div class="input-group">
                <input for="storage_limit" name="storage_limit" type="text" class="form-control" value=""
                    required>
                <div class="input-group-append">
                    <span class="input-group-text">
                        MB
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            {{ Form::label('description', __('Description')) }}
            {!! Form::textarea('description', null, [
                'class' => 'form-control',
                'rows' => '2',
                'placeholder' => __('Enter Description'),
            ]) !!}
        </div>
    </div>
    <div class="col-6">
        <div class="custom-control form-switch pt-2">
            <input type="checkbox" class="form-check-input" name="enable_chatgpt" id="enable_chatgpt">
            <label class="custom-control-label form-check-label"
                for="enable_chatgpt">{{ __('Enable Chatgpt') }}</label>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
        {{ Form::submit(__('Create'), ['class' => 'btn btn-primary ']) }}
    </div>
</div>
{{ Form::close() }}
