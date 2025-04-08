@extends('layouts.app')

@section('content')
<style>
    
    html, body {
    overflow: hidden; /* Prevent scrolling */
   
}
</style>
<div class="container-fluid">
    <div class="row vh-100"> <!-- Use vh-100 to make the row take full viewport height -->
        <!-- Left Side: Image -->
        <div class="col-md-6 d-none d-md-block p-0">
    
            <div class="login-image" style="background-image: url('https://nlmscdnawsbackup.blob.core.windows.net/nlms-cdn/microservice.png'); background-size: cover; background-position: center; height: 100vh; margin-top: 1px;">
                <h1 class="text-white display-4 d-flex justify-content-center align-items-center" style="height: 100%;">Welcome Back!</h1>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <div class="card shadow-lg" style="width: 100%; max-width: 400px; margin-top: -100px;">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h2>{{ __('Login') }}</h2>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Input -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        <!-- Login Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                {{ __('Login') }}
                            </button>
                        </div>

                        <!-- Forgot Password Link -->
                        @if (Route::has('password.request'))
                            <div class="text-center">
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection