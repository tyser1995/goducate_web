@extends('layouts.app-auth', [
'class' => 'main-page'
])
@section('content')
<div class="card login-form">
    <div class="card-header text-center d-none">
        <span class="h1"><b>HRIS</b>-Apps</span>
    </div>
    <div class="card-body">
        <div class="text-center">
            <a href="{{ url('/home') }}">
                <img src="{{ asset('images/logo.webp') }}" style="width:150px"  alt="nologo"/>
            </a>
            <p class="login-box-msg">Sign in to start your session</p>
        </div>
        @include('notification.index')
        <form class="form" method="POST" action="{{ route('login') }}" autocomplete="off">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" required autofocus  placeholder="{{ __('Enter Email') }}">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" required autofocus  placeholder="{{ __('password') }}">
            </div>
        
            <div class="form-group">
                <div class="mb-1" style="display: flex;
                justify-content: space-between;">
                    <p>
                        <a href="{{url('/')}}">I forgot my password</a>
                    </p>
                    <p>
                        <a href="{{route('register')}}" class="text-center">Register a new membership</a>
                    </p>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                <div class="social-auth-links text-center mt-2 mb-3">
                    <a href="#" class="btn btn-block btn-primary d-none">
                        <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                    </a>
                    <a href="{{ route('google.redirect') }}" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Login with Google
                    </a>
                </div>
                <div style="display: flex;
                justify-content: space-between;">
                    <p>
                        <a href="{{url('/home')}}">Return to home</a>
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /.login-box -->
@endsection
