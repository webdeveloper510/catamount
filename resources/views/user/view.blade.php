<div class="col-lg-12 order-lg-1">
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <small class="h6 text-md mb-3 mb-md-0">{{__('User Name')}} </small>
                </div>
                <div class="col-md-5">
                    <span class="text-md">{{ $user->username }}</span>
                </div>
                <div class="col-md-3 text-md-end">
                    @php
                    $profile=\App\Models\Utility::get_file('upload/profile/');

                    @endphp
                    <img src="{{(!empty($user->avatar))? ($profile.$user->avatar): ($profile.'avatar.png')}}"
                        width="50px;">

                </div>
                <div class="col-md-4 mt-1">
                    <small class="h6 text-md mb-3 mb-md-0">{{__('Name')}} </small>
                </div>
                <div class="col-sm-5  mt-1">
                    <span class="text-md">{{ $user->name }}</span>
                </div>


                <div class="col-md-4  mt-1">
                    <small class="h6 text-md mb-3 mb-md-0">{{__('Email')}}</small>
                </div>
                <div class="col-md-5  mt-1">
                    <span class="text-md">{{ $user->email }}</span>
                </div>
                <div class="col-md-4  mt-1">
                    <small class="h6 text-md mb-3 mb-md-0">{{__('Phone')}}</small>
                </div>
                <div class="col-md-5  mt-1">
                    <span class="text-md">{{ $user->phone }}</span>
                </div>
                <div class="col-md-4  mt-1">
                    <small class="h6 text-md mb-3 mb-md-0">{{__('Gender')}}</small>
                </div>
                <div class="col-md-5  mt-1">
                    <span class="text-md">{{ $user->gender }}</span>
                </div>
                <div class="col-md-4  mt-1">
                    <small class="h6 text-md mb-3 mb-md-0">{{__('Role')}}</small>
                </div>
                <div class="col-md-5  mt-1">
                    <span class="text-md">{{ $user->type }}</span>
                </div>
                <div class="col-md-4  mt-1">
                    <small class="h6 text-md mb-3 mb-md-0">{{__('Created At :')}} </small>
                </div>
                <div class="col-md-5  mt-1">
                    <span class="text-md">{{\Auth::user()->dateFormat($user->created_at )}}</span>
                </div>
                <div class="col-sm-4  mt-1">
                    <small class="h6 text-md mb-3 mb-md-0">{{__('Status')}}</small>
                </div>
                <div class="col-md-5  mt-1">
                    @if ($user->is_active == 1)
                    <span class="badge bg-success p-2 px-3 rounded">{{ __('Active') }}</span>
                    @else
                    <span class="badge bg-danger p-2 px-3 rounded">{{ __('In Active') }}</span>
                    @endif
                </div>
            </div>
        </li>
    </ul>
    <div class=" text-end ">
        @can('Edit User')
        <div class="action-btn bg-info ms-2">
            <a href="{{ route('user.edit',$user->id) }}" data-bs-toggle="tooltip" title="{{__('Edit')}}"
                class="mx-3 btn btn-sm d-inline-flex align-items-center text-white"><i class="ti ti-edit"></i>
            </a>
        </div>
        @endcan
    </div>
</div>
<style>
.list-group-flush .list-group-item {
    background: none;
}
</style>