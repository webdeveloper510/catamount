@php
$plansettings = App\Models\Utility::plansettings();
@endphp
{{ Form::open(array('url' => 'contract')) }}

    <div class="row">
        @if (isset($plansettings['enable_chatgpt']) && $plansettings['enable_chatgpt'] == 'on')
        <div class="text-end">
            <a href="#" data-size="md" class="btn btn-sm btn-primary" data-ajax-popup-over="true" data-size="md"
                data-title="{{ __('Generate content with AI') }}" data-url="{{ route('generate', ['contract']) }}"
                data-toggle="tooltip" title="{{ __('Generate') }}">
                <i class="fas fa-robot"></span><span class="robot">{{ __('Generate With AI') }}</span></i>
            </a>
        </div>
        @endif
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('name', __('Contract Name'),['class'=>'form-label']) }}
                {{ Form::text('name', '', array('class' => 'form-control','required'=>'required')) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('client_name', __('User Name'),['class'=>'form-label']) }}
                {{ Form::select('client_name', $client,null, array('class' => 'form-control select2','required'=>'required')) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('subject', __('Subject'),['class'=>'form-label']) }}
                {{ Form::text('subject', '', array('class' => 'form-control','required'=>'required')) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('value', __('Value'),['class'=>'form-label']) }}
                {{ Form::number('value', '', array('class' => 'form-control','required'=>'required','min' => '1')) }}
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                {{ Form::label('type', __('Type'),['class'=>'form-label']) }}
                {{ Form::select('type', $contractType,null, array('class' => 'form-control select2','required'=>'required')) }}
                @if(count($contractType) <= 0)
                    <div class="text-muted text-xs">
                        {{__('Please create new contract type')}} <a href="{{route('contract_type.index')}}">{{__('here')}}</a>.
                    </div>
                @endif
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('date', __('Start Date / End Date'),['class'=>'form-label']) }}
                {{-- {!!Form::date('start_date', null,array('class' => 'form-control','required'=>'required')) !!} --}}
                {{-- <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">With Input
                                Group</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <div class='input-group'>
                            <input type='text' id='pc-daterangepicker-2' class="form-control" placeholder="Select date range" />
                            <span class="input-group-text"><i
                                            class="feather icon-calendar"></i></span>
                        </div>
                    </div>
                </div> --}}
                <div class='input-group'>
                    <input type='text' name="date" id='pc-daterangepicker-2'
                        class="form-control" placeholder="Select date range" />
                    <span class="input-group-text"><i
                            class="feather icon-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('notes', __('Description'),['class'=>'form-label']) }}
                {{ Form::textarea('notes', '', array('class' => 'form-control')) }}
            </div>
        </div>

    </div>



<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{__('Close')}}</button>
    <button type="submit" class="btn  btn-primary">{{__('Create')}}</button>

</div>
{{ Form::close() }}


<script>
document.querySelector("#pc-daterangepicker-2").flatpickr({
    mode: "range"
});
</script>
