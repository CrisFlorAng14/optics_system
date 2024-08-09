@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/user/show.css') }}">
<div class="container py-3">
    <!-- ######## PERFIL DE USUARIO ############## -->
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="flex-shrink-0 rounded-circle overflow-hidden">
                            @if($user->photo == NULL)
                            <img src="{{ asset('resources/user-default.jpg') }}" class="img-fluid">
                            @else
                            <img src="" class="img-fluid">
                            @endif
                        </div>
                    </div>
                    <h5 class="mt-3 mb-0">{{ $user->name }}</h5>
                    <p class="fw-normal fs-6 text-secondary">{{__('Role')}}</p>

                    <!-- Botones de control -->
                    <a href="" class="btn btn-outline-primary">
                        <i class="fa-solid fa-user-pen"></i>
                        {{__('Edit')}}
                    </a>
                    <a href="" class="btn btn-outline-danger">
                        <i class="fa-solid fa-user-slash"></i>
                        {{__('Delete')}}
                    </a>
                </div>
            </div>
        </div>

        <!-- ######### INFORMACIÓN DEL USUARIO ########### -->
        <div class="col-12 col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-body-secondary">
                <h3 class="fs-4 py-2">{{__('General Info')}}</h3>
                </div>
                <div class="card-body">
                    <!-- Nombre completo -->
                    <div class="row">
                        <div class="col-sm-3 mb-0">
                            <p class="fw-normal fs-6 text-secondary mb-0">{{__('Full Name')}}</p>
                        </div>
                        <div class="col-sm-9 mb-0">
                            <p class="fw-semibold fs-6 text-dark mb-0">
                                {{ $user->name .' '. $user->first_lastname .' '. $user->second_lastname }}
                            </p>
                        </div>
                    </div>
                    <hr>
                    <!-- Correo electrónico -->
                    <div class="row">
                        <div class="col-sm-3 mb-0">
                            <p class="fw-normal fs-6 text-secondary mb-0">{{__('Email')}}</p>
                        </div>
                        <div class="col-sm-9 mb-0">
                            <p class="fw-semibold fs-6 text-dark mb-0">
                                {{ $user->email }}
                            </p>
                        </div>
                    </div>
                    <hr>
                    <!-- Teléfono -->
                    <div class="row">
                        <div class="col-sm-3 mb-0">
                            <p class="fw-normal fs-6 text-secondary mb-0">{{__('Phone')}}</p>
                        </div>
                        <div class="col-sm-9 mb-0">
                            <p class="fw-semibold fs-6 text-dark mb-0">
                                {{ $user->phone }}
                            </p>
                        </div>
                    </div>
                    <hr>
                    <!-- Nacimiento -->
                    <div class="row">
                        <div class="col-sm-3 mb-0">
                            <p class="fw-normal fs-6 text-secondary mb-0">{{__('Birthdate')}}</p>
                        </div>
                        <div class="col-4 col-md-2 mb-0">
                            <p class="fw-semibold fs-6 text-dark mb-0">
                                {{ $user->birthdate }}
                            </p>
                        </div>
                        <div class="col-5 col-md-3 mb-0">
                            <p class="sw-semibold text-secondary mb-0">
                                <span style="margin-right: 2rem;">|</span>{{__($age .' years') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection