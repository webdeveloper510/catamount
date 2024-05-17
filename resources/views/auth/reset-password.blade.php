@extends('layouts.auth')
@section('page-title')
    {{ __('Reset Password') }}
@endsection
@section('content')
    <div class="card-body">
        <div class="">
            <h2 class="mb-3 f-w-600"><span class="text-primary">{{ __(' Reset Password!') }}</span>
            </h2>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <div class="form-group mb-3">
                {{ Form::label('E-Mail Address', __('E-Mail Address'), ['class' => 'form-control-label']) }}
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                {{ Form::label('Password', __('Password'), ['class' => 'form-control-label']) }}
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


            <div class="form-group mb-3">
                {{ Form::label('password-confirm', __('Confirm Password'), ['class' => 'form-control-label']) }}
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                    autocomplete="new-password">
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-sm btn-primary btn-icon rounded-pill text-white">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </form>
    </div>
@endsection
