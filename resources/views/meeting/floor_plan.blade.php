<div class="row">
    <div class="col-lg-12">

            <div class="">
                <dl class="row">
                    <dt class="col-md-5"><span class="h6 text-md mb-0">{{__('Name')}}</span></dt>

                    <dt class="col-md-5"><span class="h6 text-md mb-0">{{__('Status')}}</span></dt>
                    
                    <dt class="col-md-5"><span class="h6 text-md mb-0">{{__('Start Date')}}</span></dt>

                    <dt class="col-md-5"><span class="h6 text-md mb-0">{{__('End Date')}}</span></dt>

                    <dt class="col-md-5"><span class="h6 text-md mb-0">{{__('Guest Count')}}</span></dt>

                    <dt class="col-md-5"><span class="h6 text-md mb-0">{{__('Venue')}}</span></dt>

                    <dt class="col-md-5"><span class="h6 text-md mb-0">{{__('Function')}}</span></dt>

                    <dt class="col-md-5"><span class="h6 text-md mb-0">{{__('Event Type')}}</span></dt>

                    <dt class="col-md-5"><span class="h6 text-md mb-0">{{__('Attendees Lead')}}</span></dt>

                    <dt class="col-sm-5"><span class="h6 text-sm mb-0">{{__('Assigned User')}}</span></dt>

                    <dt class="col-sm-5"><span class="h6 text-sm mb-0">{{__('Created')}}</span></dt>
                </dl>
            </div>

    </div>

    <div class="w-100 text-end pr-2">
        @can('Edit Meeting')
        <div class="action-btn bg-info ms-2">
            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center text-white" data-bs-toggle="tooltip"data-title="{{__('Edit Call')}}" title="{{__('Edit')}}"><i class="ti ti-edit"></i>
            </a>
        </div>
        @endcan
    </div>
</div>

