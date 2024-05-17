@extends('layouts.admin')
@section('page-title')
    {{ __('User') }}
@endsection
@section('title')
    {{ __('Staff') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Staff') }}</li>

@endsection
@section('action-btn')
    @can('Create User')
        <a href="#" data-url="{{ route('user.create') }}" data-size="md" data-ajax-popup="true" data-bs-toggle="tooltip"
            title="{{ __('Create') }}"data-title="{{ __('Create Staff Member') }}" class="btn btn-sm btn-primary btn-icon">
            <i class="ti ti-plus"></i>
        </a>
    @endcan
@endsection
@section('filter')
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive overflow_hidden">
                        <table id="datatable" class="table align-items-center datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="username">{{ __('Avatar') }}</th>
                                    <!-- <th scope="col" class="sort" data-sort="username">{{ __('User Name') }}</th> -->
                                    <th scope="col" class="sort" data-sort="name">{{ __('Name') }}</th>
                                    <th scope="col" class="sort" data-sort="email">{{ __('Email') }}</th>
                                    @if (\Auth::user()->type != 'super admin')
                                        <th scope="col" class="sort" data-sort="title">{{ __('Type') }}</th>
                                        <th scope="col" class="sort" data-sort="isactive">{{ __('Status') }}</th>
                                    @endif
                                    @if (Gate::check('Edit User') || Gate::check('Delete User'))
                                        <th class="text-end" scope="col">{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $profile = \App\Models\Utility::get_file('upload/profile/');
                                @endphp
                               
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <span class="avatar">
                                                <a href="{{ $profile }}{{ !empty($user->avatar) ? $user->avatar : 'avatar.png' }}"
                                                    target="_blank">
                                                <img class="rounded-circle" width="25%"
                                                    @if ($user->avatar) src="{{ $profile }}{{ !empty($user->avatar) ? $user->avatar : 'avatar.png' }}" @else src="{{ $profile . 'avatar.png' }}" @endif
                                                    alt="{{ $user->name }}">
                                                </a>
                                            </span>
                                        </td>
                                        <!-- <td class="budget">
                                            <a href="#" data-size="md" data-url="{{ route('user.show', $user->id) }}"
                                                data-ajax-popup="true" data-title="{{ __('User Details') }}"
                                                class="action-item text-primary">
                                                {{ ucfirst($user->username) }}
                                            </a>
                                        </td> -->
                                        <td>
                                            <span class="budget"> {{ ucfirst($user->name) }} </span>
                                        </td>
                                        <td>
                                            <span class="budget">{{ $user->email }}</span>
                                        </td>
                                        @if (\Auth::user()->type != 'super admin')
                                            <td>
                                                {{ ucfirst($user->type) }}
                                            </td>
                                            <td>
                                                @if ($user->is_active == 1)
                                                    <span
                                                        class="badge bg-success p-2 px-3 rounded">{{ __('Active') }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-danger p-2 px-3 rounded">{{ __('In Active') }}</span>
                                                @endif
                                            </td>
                                        @endif
                                        @if (Gate::check('Edit User') || Gate::check('Delete User'))
                                            <td class="text-end">
                                                @if (\Auth::user()->type == 'super admin')
                                                    @can('Manage Plan')
                                                        <div class="action-btn bg-secondary ms-2">
                                                            <a href="#"
                                                                class="mx-3 btn btn-sm d-inline-flex align-items-center text-white"
                                                                data-size="md"
                                                                data-url="{{ route('plan.upgrade', $user->id) }}"
                                                                data-ajax-popup="true" data-bs-toggle="tooltip"
                                                                data-title="{{ __('Upgrade Plan') }}"
                                                                title="{{ __('Upgrade Plan') }}">
                                                                <i class="ti ti-trophy"></i>
                                                            </a>
                                                        </div>
                                                    @endcan
                                                @endif
                                                <div class="action-btn bg-success ms-2">
                                                    <a href="#"
                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center text-white"
                                                        data-size="md"
                                                        data-url="{{ route('user.reset', \Crypt::encrypt($user->id)) }}"
                                                        data-ajax-popup="true" title="{{ __('Reset Password') }}"
                                                        data-bs-toggle="tooltip" data-title="{{ __('Reset Password') }}">
                                                        <i class="ti ti-key"></i>
                                                    </a>
                                                </div>
                                                @can('Show User')
                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="#" data-size="md"
                                                            data-url="{{ route('user.show', $user->id) }}"
                                                            data-bs-toggle="tooltip" title="{{ __('Details') }}"
                                                            data-ajax-popup="true" data-title="{{ __('User Details') }}"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white">
                                                            <i class="ti ti-eye"></i>
                                                        </a>
                                                    </div>
                                                @endcan
                                                @can('Edit User')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="{{ route('user.edit', $user->id) }}"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white"
                                                            data-bs-toggle="tooltip"
                                                            title="{{ __('Edit') }}"data-title="{{ __('Edit User') }}"><i
                                                                class="ti ti-edit"></i></a>
                                                    </div>
                                                @endcan
                                                @can('Delete User')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['user.destroy', $user->id]]) !!}
                                                        <a href="#!"
                                                            class="mx-3 btn btn-sm align-items-center text-white show_confirm"
                                                            data-bs-toggle="tooltip" title='Delete'>
                                                            <i class="ti ti-trash"></i>
                                                        </a>
                                                        {!! Form::close() !!}
                                                    </div>
                                                @endcan
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
