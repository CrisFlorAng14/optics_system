@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/user/index.css') }}">
<div class="container mt-2">
    <!-- ############## ENCABEZADO ################### -->
    <div class="row justify-content-between align-items-center">
        <!-- Título -->
        <div class="col-6 d-flex justify-content-start">
            <h2 class="fs-2">{{__('Users')}}</h2>
        </div>
        <!-- Botón modal "Nuevo usuario" -->
        <div class="col-6 d-flex justify-content-end">
            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#newUserModal">
                <i class="fa-solid fa-user-plus"></i>
                {{__('New User')}}
            </button>
        </div>
    </div>
    <!-- ############## TABLA ############# -->
    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered text-center align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Full Name')}}</th>
                    <th>{{__('Birthdate')}}</th>
                    <th>{{__('Phone')}}</th>
                    <th>{{__('Email')}}</th>
                    <th>{{__('Photo')}}</th>
                    <th colspan="3">{{__('Actions')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name.' '.$user->first_lastname.' '.$user->second_lastname }}</td>
                    <td>{{ $user->birthdate }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="flex-shrink-0 rounded-circle overflow-hidden">
                                @if($user->photo == NULL)
                                <img src="{{ asset('resources/user-default.jpg') }}" class="img-fluid">
                                @else
                                
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('user.show', $user->id) }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i></a>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-primary" 
                            data-bs-toggle="modal" data-bs-target="#updateUser{{ $user->id }}">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                    </td>
                    <td>
                        <form action="" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>

                <!-- Modal para actualizar usuario -->
                <div class="modal fade" id="updateUser{{ $user->id }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                    aria-labelledby="modalTitleId{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTitleId{{ $user->id }}">
                                    {{__('Edit User')}}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('user.update', $user->id) }}" id="updateUserForm{{ $user->id }}" role="form"
                                    enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    @include('user.form')
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    {{__('Close')}}
                                </button>
                                <button type="submit" class="btn btn-primary" form="updateUserForm{{ $user->id }}">{{__('Update')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex align-items-center justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- Modal de registro de usuario -->
<div class="modal fade" id="newUserModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    {{__('New User')}}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario de registro (nuevo usuario) -->
                <form method="POST" action="{{ route('user.store') }}" id="newUserForm" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    @include('user.create')
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{__('Close')}}
                </button>
                <button type="submit" class="btn btn-primary" form="newUserForm">{{__('Save')}}</button>
            </div>
        </div>
    </div>
</div>

<!-- Mostrar ventana modal según el tipo (Registro o Modificación) 
    Entradas: [Errores, Formulario de registro, Formulario de edición]
    Salidas: [Ventana modal según el tipo]
-->
<script>
document.addEventListener('DOMContentLoaded', function () {

    @if($errors->any())
        
        if ({{ $errors->has('name') || $errors->has('email') || $errors->has('phone') || $errors->has('birthdate') }}) {
            const newUserModal = new bootstrap.Modal(document.getElementById('newUserModal'));
            newUserModal.show();
        }
        
        // Si hay errores en los formularios de actualización
        @foreach($users as $user)
            @if($errors->has('updateUser'.$user->id))
                const updateModal = new bootstrap.Modal(document.getElementById('updateUser{{ $user->id }}'));
                updateModal.show();
            @endif
        @endforeach
    @endif
});
</script>



@endsection
