@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/product/index.css') }}">
<script src="{{ asset('js/product/index.js') }}"></script>
<div class="container mt-2">
    <!-- ############## ENCABEZADO ################### -->
    <!-- Formulario de búsqueda y ordenamiento -->
    <form action="{{ route('product.index') }}" method="get" class="row justify-content-between" id="searchForm">
        <!-- Título -->
        <div class="col-3 col-md-6 d-flex justify-content-start">
            <h2 class="fs-2">{{__('Products')}}</h2>
        </div>
        <!-- Barra de búsqueda -->
        <div class="col-9 col-md-6 mb-2 align-items-center">
            <div class="d-flex flex-sm-row">
                <div class="input-group">
                    <input type="search" name="search" class="form-control mr-2 flex-grow-1" id="input-search"
                        placeholder="{{__('Type for quick search or press for deep search')}}"
                        value="{{ request('search') }}">
                    <button class="input-group-text btn-search">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- ######## FILTROS ########## -->
        <!-- Ordenar por... -->
        <div class="col-6 col-md-3">
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-filter"></i></span>
                <select name="order_by" class="form-control form-control-sm" id="orderBySelect">
                    <option value="" disabled selected>{{__('Order by')}}</option>
                    <option value="id" {{ request('order_by') == 'id' ? 'selected' : '' }}>{{__('Default')}}</option>
                    <option value="name_product" {{ request('order_by') == 'name_product' ? 'selected' : '' }}>{{__('Name Product')}}</option>
                    <option value="brand" {{ request('order_by') == 'brand' ? 'selected' : '' }}>
                        {{__('Brand')}}</option>
                    <option value="category" {{ request('order_by') == 'category' ? 'selected' : '' }}>
                        {{__('Category')}}</option>
                    <option value="price" {{ request('order_by') == 'price' ? 'selected' : '' }}>{{__('Price')}}
                    </option>
                    <option value="stock" {{ request('order_by') == 'stock' ? 'selected' : '' }}>
                        {{__('Stock')}}</option>
                </select>
            </div>
        </div>
        <!-- Ascendente o descendente -->
        <div class="col-6 col-md-3">
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-sort"></i></span>
                <select name="order_direction" class="form-control form-control-sm" id="orderDirectionSelect">
                    <option value="" disabled selected>{{__('Direction')}}</option>
                    <option value="asc" {{ request('order_direction') == 'asc' ? 'selected' : '' }}>{{__('Ascending')}}
                    </option>
                    <option value="desc" {{ request('order_direction') == 'desc' ? 'selected' : '' }}>
                        {{__('Descending')}}</option>
                </select>
            </div>
        </div>
        <div class="col-0 col-md-3"></div>

        <!-- Botón modal "Nuevo usuario" -->
        <div class="col-12 col-md-3 d-flex justify-content-end mt-2 mt-md-0 mb-2 mb-md-0">
            <button type="button" class="btn btn-sm btn-outline-success w-100" data-bs-toggle="modal"
                data-bs-target="#newProductModal">
                <i class="fa-solid fa-square-plus"></i>
                {{__('New Product')}}
            </button>
        </div>
    </form>

    @if(isset($message_empty))
    <div class="alert alert-danger mt-2" role="alert">
        <i class="fa-solid fa-exclamation-triangle"></i> {{ $message_empty }}
        <form action="{{ route('product.index') }}" method="get" class="d-flex flex-sm-row mt-2">
            <input type="hidden" name="search">
            <button class="btn btn-link"><i class="fa-solid fa-rotate"></i> {{__('Reload')}} </button>
        </form>
    </div>
    @else
    <div class="table-responsive">
        <table class="table table-sm table-hover text-center align-middle" id="table-content">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{__('Product')}}</th>
                    <th scope="col">{{__('Brand')}}</th>
                    <th scope="col">{{__('Category')}}</th>
                    <th scope="col">{{__('Price')}}</th>
                    <th scope="col">{{__('Stock')}}</th>
                    <th scope="col">{{__('Image')}}</th>
                    <th colspan="3">{{__('Actions')}}</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td class="text-nowrap text-truncate">{{ $product->name_product }}</td>
                    <td class="text-nowrap text-truncate">{{ $product->brand }}</td>
                    <td class="text-nowrap text-truncate">{{ $product->category }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <div class="image-prod-container card rounded">
                                @if($product->image == NULL )
                                <img src="{{ asset('resources/image-default.png') }}" class="img-fluid">
                                @else
                                <img src="{{ asset('uploads/product/'.$product->image) }}" class="img-fluid">
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-outline-secondary btn-sm"><i
                                class="fa-solid fa-eye"></i></a>
                    </td>
                    <td>
                        <a href="{{ route('product.edit',$product->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                    </td>
                    <td>
                        <!-- Formulario / Botón para eliminar usuario -->
                        <form action="{{ route('product.destroy',$product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btnDelete btn-sm btn-outline-danger"
                                data-title="{{__('Are you sure to delete this product?')}}"
                                data-text="{{__('This action cannot be undone')}}"
                                data-confirm-button-text="{{__('Yes, delete it')}}"
                                data-cancel-button-text="{{__('Cancel')}}"><i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
        <!-- Mensaje rápido para tabla vacía -->
        <div class="alert alert-danger" id="message-empty">
            {{__('no matches in the 10 records shown, for a deeper search press the button with the icon')}}
            <i class="fa-solid fa-search"></i>
        </div>
        <div class="d-flex align-items-center justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
    @endif
</div>

<!-- Modal de registro de usuario -->
<div class="modal fade" id="newProductModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    {{__('New Product')}}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario de registro (nuevo usuario) -->
                <form method="POST" action="{{ route('product.store') }}" id="newProductForm" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    @include('product.create')
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{__('Close')}}
                </button>
                <button type="submit" class="btn btn-success" form="newProductForm">{{__('Save')}}</button>
            </div>
        </div>
    </div>
</div>

<!-- Script para abrir el modal automáticamente si hay errores -->
@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var newProductModal = new bootstrap.Modal(document.getElementById('newProductModal'));
        newProductModal.show();
    });
</script>
@endif
<!-- Script para mostrar mensaje de Alerta -->
<script>
    // Valores para mensajes de alerta
    var icon = @json('success');
    @if(session()->has('store'))
    var sessionType = @json(session('store')); // Su session es 'store'
    var alertTitle = @json(__('Product added successfully')); // Título del mensaje
    @elseif(session()->has('update'))
    var sessionType = @json(session('update')); // Su session es 'update'
    var alertTitle = @json(__('Product updated successfully')); // Título del mensaje
    @elseif(session()->has('delete'))
    var sessionType = @json(session('delete')); // Su session es 'delete'
    var alertTitle = @json(__('Product deleted successfully')); // Título del mensaje
    @endif
</script>

@endsection