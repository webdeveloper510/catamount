<div class="row">
    <div class="col-lg-12">
            <div class="">
            {{ Form::open(array('route' => 'meeting.event_info','method' =>'post')) }}
                <dl class="row">

                    <dt class="col-md-6"><span class="h6 text-md mb-0">{{__('Name')}}</span></dt>
                    <dd class="col-md-6"> 
                        <input type = "text" name="name" class="form-control" value = "{{ $meeting->name }}" disabled>
                    </dd>
                    <dt class="col-md-6"><span class="h6 text-md mb-0">{{__('Email')}}</span></dt>
                    <dd class="col-md-6">
                        <input type = "text" name="email" class="form-control" value = "{{ $meeting->email }}" >
                    </dd>

                </dl>
            {{Form::submit(__('Share'),array('class'=>'btn btn-primary'))}}
            </div>

    </div>
</div>

