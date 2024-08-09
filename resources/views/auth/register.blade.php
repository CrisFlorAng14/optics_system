@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
<div class="container mt-3">
    <div class="d-flex align-items-center justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <p class="fs-2 text-center mb-0">{{__('Register')}}</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <!-- ############### NOMBRE COMPLETO ################ -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                            <!-- Nombre(s) -->
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="{{__('Name')}}(s)" value="{{ old('name') }}">
                            
                            <!-- Primer apellido -->
                            <input type="text" name="first_lastname"
                                class="form-control @error('first_lastname') is-invalid @enderror"
                                placeholder="{{__('First Last Name')}}" value="{{ old('first_lastname')}}">
                            
                            <!-- Segundo apellido -->
                            <input type="text" name="second_lastname"
                                class="form-control"
                                placeholder="{{__('Second Last Name')}}" value="{{ old('second_lastname') }}">
                                
                            <!-- Mensajes de error para el nombre completo -->
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @error('first_lastname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- ################ --- FECHA DE NACIMIENTO ################## -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-cake-candles"></i></span>
                            <!-- Día de nacimiento -->
                            <select name="day" class="form-select @error('day') is-invalid @enderror">
                                <option value="" disabled selected>{{__('Day')}}</option>
                                @for ($i = 1; $i <= 31; $i++) 
                                    <option value="{{ $i }}" {{ old('day') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            <!-- Mes de nacimiento -->
                            <select name="month" class="form-select @error('month') is-invalid @enderror">
                                <option value="" disabled selected>{{__('Month')}}</option>
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ old('month') == $m ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $m)->format('M') }}
                                    </option>
                                @endforeach
                            </select>
                            <!-- Año de nacimiento -->
                            <select name="year" class="form-select @error('year') is-invalid @enderror">
                                <option value="" disabled selected>{{__('Year')}}</option>
                                @for ($i = now()->year ; $i >= Carbon\Carbon::now()->year -100; $i--)
                                    <option value="{{ $i }}" {{ old('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>

                            @error('day')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @error('month')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @error('year')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        <!-- ############### TELÉFONO ############### -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                placeholder="Phone Number" pattern="[0-9]{10}"
                                value="{{ old('phone') }}"
                                title="{{__('Enter a phone number, Ex: 7771234567')}}">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- ############### CREDENCIALES ################ -->
                        <!-- Correo electrónico -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="{{__('Email')}}" value="{{ old('email') }}" 
                                aria-label="{{__('Email')}}" aria-describedby="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- Contraseña -->
                        <div class="row">
                            <div class="col-md-6 col-12 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                        placeholder="{{__('Password')}}" aria-label="{{__('Password')}}" aria-describedby="password"
                                        require-autocomplete="new-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-12 mb-3">
                                <!-- Confirmar contraseña -->
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="{{__('Confirm password')}}" aria-label="{{__('Confirm Password')}}"
                                        aria-describedby="password_confirmation" require_autocomplete="new-password">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn text-center w-100 mb-2">{{__('Register')}}</button>
                        <!-- ¿Tienes cuenta? -->
                         <p class="fs-6 text-secondary text-center">{{__('Already have an account?')}} 
                            <a href="{{ route('login') }}" class="btn-login">{{__('Login')}}</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection