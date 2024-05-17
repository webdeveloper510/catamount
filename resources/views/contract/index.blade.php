@extends('layouts.admin')

@section('page-title')
    {{ __('Contract') }}
@endsection

@section('title')
    {{ __('Contract') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Contracts') }}</li>
@endsection


@section('action-btn')
    @if (\Auth::user()->type == 'owner' && \Auth::user()->type != 'Accountant' && \Auth::user()->type != 'Manager')
        @can('Create Contract')
            <!-- <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="tooltip" data-bs-placement="top"
                title="{{ __('Create') }}" data-ajax-popup="true" data-size="lg" data-title="{{ __('Create New Contract') }}"
                data-url="{{ route('contracts.create') }}"><i class="ti ti-plus text-white"></i></a> -->
                <a href="{{ route('contracts.create') }}" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="tooltip" data-bs-placement="top"
                title="{{ __('Create New Contract') }}" ><i class="ti ti-plus text-white"></i></a>
        @endcan
    @endif
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card table-card">
                <div class="card-header card-body table-border-style">
                    <div class="table-responsive" id="useradd-1">
                        <table id="datatable" class="table datatable align-items-center">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('User') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Created By') }}</th>
                                    <th>{{ __('Date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contracts as $contract)
                                    <tr>
                                     
                                        <td>{{ $contract->name }}</td>
                                        <td>{{ App\Models\User::find($contract->user_id)->first()->name }}</td>
                                        <td>{{ $contract->subject }}</td>
                                      
                                        <td>{{ Auth::user()->name }}</td>
                                        <td>{{ Auth::user()->dateFormat($contract->created_at) }}</td>
                                        <td>
                                            @if ($contract->status == 'accept')
                                                <span
                                                    class="status_badge badge bg-primary  p-2 px-3 rounded">{{ __('Accept') }}</span>
                                            @elseif($contract->status == 'decline')
                                                <span
                                                    class="status_badge badge bg-danger p-2 px-3 rounded">{{ __('Decline') }}</span>
                                            @elseif($contract->status == 'pending')
                                                <span
                                                    class="status_badge badge bg-warning p-2 px-3 rounded">{{ __('Pending') }}</span>
                                            @endif
                                        </td>
                                       
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
