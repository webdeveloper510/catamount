<div class="row">
    <div class="col-lg-12 half-col">
        <div class="">
            <dl class="row">
                <dt class="col-md-6"><span class="h6  mb-0">{{__('Event')}}</span></dt>
                @if($meeting->attendees_lead != 0)
                <dd class="col-md-6"><span
                        class="">{{ !empty($meeting->attendees_leads->leadname)?$meeting->attendees_leads->leadname:'--' }}</span>
                </dd>
                @else
                <dd class="col-md-6"><span class="">{{$meeting->eventname}}</span></dd>
                @endif

                <dt class="col-md-6"><span class="h6  mb-0">{{__(' Date')}}</span></dt>
                <dd class="col-md-6"><span class="">
                        @if($meeting->start_date == $meeting->end_date)
                        {{ \Auth::user()->dateFormat($meeting->start_date) }}
                        @else
                        {{ \Auth::user()->dateFormat($meeting->start_date) }} -
                        {{ \Auth::user()->dateFormat($meeting->end_date) }}
                        @endif
                    </span></dd>

                <dt class="col-md-6"><span class="h6  mb-0">{{__(' Time')}}</span></dt>
                <dd class="col-md-6"><span class="">
                        @if($meeting->start_time == $meeting->end_time)
                        --
                        @else
                        {{date('h:i A', strtotime($meeting->start_time))}} -
                        {{date('h:i A', strtotime($meeting->end_time))}}
                        @endif
                    </span>
                </dd>

                <dt class="col-md-6"><span class="h6  mb-0">{{__('Guest Count')}}</span></dt>
                <dd class="col-md-6"><span class="">{{$meeting->guest_count}}</span></dd>

                <dt class="col-md-6"><span class="h6  mb-0">{{__('Venue')}}</span></dt>
                <dd class="col-md-6"><span class="">{{$meeting->venue_selection}}</span></dd>

                <dt class="col-md-6"><span class="h6  mb-0">{{__('Function')}}</span></dt>
                <dd class="col-md-6"><span class="">{{$meeting->function}}</span></dd>

                <dt class="col-md-6"><span class="h6  mb-0">{{__('Event Type')}}</span></dt>
                <dd class="col-md-6"><span class="">{{$meeting->type}}</span></dd>

                <dt class="col-md-6"><span class="h6 text-sm mb-0">{{__('Assigned Staff')}}</span></dt>
                <dd class="col-md-6"><span class="">{{ $name }}</span></dd>

                <dt class="col-md-6"><span class="h6 text-sm mb-0">{{__('Created')}}</span></dt>
                <dd class="col-md-6"><span class="">{{\Auth::user()->dateFormat($meeting->created_at)}}</span>
                </dd>
            </dl>
        </div>

    </div>

    <div class="w-100 text-end pr-2">
        @can('Edit Meeting')
        <div class="action-btn bg-info ms-2">
            <a href="{{ route('meeting.edit',$meeting->id) }}"
                class="mx-3 btn btn-sm d-inline-flex align-items-center text-white" data-bs-toggle="tooltip"
                data-title="{{__('Edit Call')}}" title="{{__('Edit')}}"><i class="ti ti-edit"></i>
            </a>
        </div>
        @endcan
    </div>
</div>