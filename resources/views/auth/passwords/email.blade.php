@extends('layouts.auth')
@section('title', 'Email Reset Password')
@section('content')
@include('components.flash-message')
<div class="card shadow card-primary">
    <div class="card-header">
        <h4>{{ __('Reset Password') }}</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('password.email') }}" class="needs-validation" novalidate="">
            @csrf
            <div class="form-group">
                <label for="email">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    tabindex="1" required autofocus>
                @error('email')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>
            <a class="text-md mt-4" href="{{ route('login') }}">Kembali ke halaman Login</a>
        </form>
    </div>
</div>
@endsection
