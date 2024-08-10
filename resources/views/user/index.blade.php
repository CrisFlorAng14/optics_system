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
        <table class="table table-sm table-hover text-center align-middle">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{__('Full Name')}}</th>
                    <th scope="col">{{__('Birthdate')}}</th>
                    <th scope="col">{{__('Phone')}}</th>
                    <th scope="col">{{__('Email')}}</th>
                    <th scope="col">{{__('Photo')}}</th>
                    <th colspan="3">{{__('Actions')}}</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td class="text-nowrap text-truncate">{{ $user->name.' '.$user->first_lastname.' '.$user->second_lastname }}</td>
                    <td class="text-nowrap">{{ $user->birthdate }}</td>
                    <td class="text-nowrap">{{ $user->phone }}</td>
                    <td class="text-nowrap text-truncate">{{ $user->email }}</td>
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
                        <!-- Formulario / Botón para eliminar usuario -->
                        <form action="{{ route('user.destroy',$user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btnDelete btn-sm btn-outline-danger"
                                data-title="{{__('Are you sure to delete this user?')}}"
                                data-text="{{__('This action cannot be undone')}}"
                                data-confirm-button-text="{{__('Yes, delete it')}}"
                                data-cancel-button-text="{{__('Cancel')}}"><i class="fa-solid fa-trash"></i>
                            </button>
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
                                <!-- Formulario de actualización -->
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
    document.addEventListener('DOMContentLoaded', function() {
        // Si session(modal) es para actualizar, existe el ID y hay errores -> mostrar el modal de actualización
        @if (session('modal') == 'update' && session('user_id') && $errors->any())
            var userId = '{{ session('user_id') }}';
            var updateUserModal = new bootstrap.Modal(document.getElementById('updateUser' + userId));
            updateUserModal.show();
        // Si session(modal) es para agregar y hay errores -> mostrar el modal de registro
        @elseif (session('modal') == 'new' && $errors->any())
            var newUserModal = new bootstrap.Modal(document.getElementById('newUserModal'));
            newUserModal.show();
        @endif
    });

    // Valores para mensajes de alerta
    @if(session()->has('store'))
        var sessionType = @json(session('store')); // Su session es 'store'
        var alertTitle = @json(__('User added successfully')); // Título del mensaje
    @elseif(session()->has('update'))
        var sessionType = @json(session('update')); // Su session es 'update'
        var alertTitle = @json(__('User updated successfully')); // Título del mensaje
    @elseif (session()->has('delete'))
        var sessionType = @json(session('delete')); // Su session es 'delete'
        var alertTitle = @json(__('User deleted successfully')); // Título del mensaje
    @endif
</script>


@endsection
