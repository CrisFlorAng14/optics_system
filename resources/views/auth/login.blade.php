@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">

<div class="container-fluid full-width-container d-flex mx-0 px-0">
    <!-- Formulario de Login -->
    <div class="container col-12 col-md-6 form-container">
        <div class="col-12 py-5">
            <p class="fs-1 text-center">{{__('Login')}}</p>
        </div>
        <div class="col-12 px-auto px-md-5">
            <form action="{{ route('login')}}" method="POST">
                @csrf

                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="{{__('Email')}}" aria-label="{{__('Email')}}" aria-describedby="email">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="{{__('Password')}}" aria-label="{{__('Password')}}" aria-describedby="password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-submit w-100 mb-2">{{__('Login')}}</button>

                @if (Route::has('password.request'))
                <div class="text-center">
                    <a class="btn text-secondary btn-forgot" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                </div>
                @endif
                <div class="line-container mt-3 mb-0">
                    <div class="line"></div>
                    <div class="line-text">or</div>
                    <div class="line"></div>
                </div>

                <div class="text-center mt-3">
                    <p>{{__("Don't have account?")}} <a href="{{ route('register')}}" class="btn btn-register">{{__('Register')}}</a></p>
                </div>
            </form>
        </div>
    </div>
    <!-- Imagen de portada -->
    <div class="col-6 d-none d-lg-block image-container">
    <img src="https://visionsindia.in/wp-content/uploads/2024/02/eyeglasses-sunglasses-reflecting-summer-elegance-design-generated-by-ai-e1707298285122.jpg"
        alt="" class="cover-image">
</div>

</div>
@endsection