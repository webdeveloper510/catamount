@php
$plansettings = App\Models\Utility::plansettings();
@endphp
{{ Form::open(['url' => 'commoncases', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
<div class="row">
    @if (isset($plansettings['enable_chatgpt']) && $plansettings['enable_chatgpt'] == 'on')
    <div class="text-end">
        <a href="#" data-size="md" class="btn btn-sm btn-primary" data-ajax-popup-over="true" data-size="md"
            data-title="{{ __('Generate content with AI') }}" data-url="{{ route('generate', ['case']) }}"
            data-toggle="tooltip" title="{{ __('Generate') }}">
            <i class="fas fa-robot"></span><span class="robot">{{ __('Generate With AI') }}</span></i>
        </a>
    </div>
    @endif
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Name'), 'required' => 'required']) }}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
            {!! Form::select('status', $status, null, ['class' => 'form-control ', 'required' => 'required']) !!}
        </div>
    </div>

    @if ($type == 'account')
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('account', __('Account'), ['class' => 'form-label']) }}
                {!! Form::select('account', $account, $id, ['class' => 'form-control ']) !!}
            </div>
        </div>
    @else
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('account', __('Account'), ['class' => 'form-label']) }}
                {!! Form::select('account', $account, null, ['class' => 'form-control ']) !!}
            </div>
        </div>
    @endif
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('priority', __('Priority'), ['class' => 'form-label']) }}
            {!! Form::select('priority', $priority, null, ['class' => 'form-control ', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('contacts', __('Contact'), ['class' => 'form-label']) }}
            {!! Form::select('contacts', $contact_name, null, ['class' => 'form-control ']) !!}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('type', __('Type'), ['class' => 'form-label']) }}
            {!! Form::select('type', $case_type, null, ['class' => 'form-control ', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('User', __('Assigned User'), ['class' => 'form-label']) }}
            {!! Form::select('user', $user, null, ['class' => 'form-control ']) !!}
        </div>
    </div>

    {{-- <div class="col-6 mb-3 field" data-name="attachments">
        <div class="form-group">
            <div class="attachment-upload">
                <div class="attachment-button">
                    <div class="pull-left">
                        {{ Form::label('User', __('Attachment'), ['class' => 'form-label']) }}
                        {{Form::file('attachments',array('class'=>'form-control'))}}
                        <input type="file"name="attachment" class="form-control mb-3"
                            onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        <img id="blah" width="20%" height="20%" />
                    </div>
                </div>
                <div class="attachments"></div>
            </div>
        </div>
    </div> --}}


<div class="col-12">
    <div class="form-group">
        {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
        {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => __('Enter Description')]) }}
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">Close</button>
    {{ Form::submit(__('Save'), ['class' => 'btn  btn-primary ']) }}{{ Form::close() }}
</div>
</div>
{{ Form::close() }}
