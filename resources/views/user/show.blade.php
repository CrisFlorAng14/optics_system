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

                    <div class="d-flex align-items-center justify-content-center">
                        <!-- Botones de control -->
                        <button type="button" class="btn mx-1 btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#updateUser">
                            <i class="fa-solid fa-user-pen"></i>
                            {{__('Edit')}}
                        </button>
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn mx-1 btn-outline-danger btnDelete"
                                data-title="{{__('Are you sure to delete this user?')}}"
                                data-text="{{__('This action cannot be undone')}}"
                                data-confirm-button-text="{{__('Yes, delete it')}}"
                                data-cancel-button-text="{{__('Cancel')}}">
                                <i class="fa-solid fa-user-xmark"></i>
                                {{__('Delete')}}
                            </button>
                        </form>
                    </div>
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


<!-- Modal para actualización de usuario -->
<div class="modal fade" id="updateUser" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    {{__('Modify '. $user->name )}}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('user.update', $user->id) }}" id="updateUserForm{{ $user->id }}"
                    role="form" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    @include('user.form')
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{__('Cancel')}}
                </button>
                <button type="submit" class="btn btn-primary" form="updateUserForm{{ $user->id }}">{{__('Save')}}</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Si session(modal) es para actualizar, existe el ID y hay errores -> mostrar el modal de actualización
        @if (session('modal') == 'update' && $errors->any())
            var updateUserModal = new bootstrap.Modal(document.getElementById('updateUser'));
            updateUserModal.show();
        @endif
    });

    // Valores para mensajes de alerta
    @if(session()->has('update'))
        var sessionType = @json(session('update')); // Su session es 'update'
        var alertTitle = @json(__('User updated successfully')); // Título del mensaje
    @elseif (session()->has('delete'))
        var sessionType = @json(session('delete')); // Su session es 'delete'
        var alertTitle = @json(__('User deleted successfully')); // Título del mensaje
    @endif
</script>
@endsection