@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/inventory/index.css') }}">
<script src="{{ asset('js/inventory/index.js') }}"></script>
<div class="container mt-2">
    <!-- ############## ENCABEZADO ################### -->
    <!-- Formulario de búsqueda y ordenamiento -->
    <form action="{{ route('inventory.index') }}" method="get" class="row justify-content-between" id="searchForm">
        <!-- Título -->
        <div class="col-3 col-md-6 d-flex justify-content-start">
            <h2 class="fs-2">{{__('Inventory')}}</h2>
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
        <div class="col-4">
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-filter"></i></span>
                <select name="order_by" class="form-control form-control-sm" id="orderBySelect">
                    <option value="" disabled selected>{{__('Order by')}}</option>
                    <option value="name_product" {{ request('order_by') == 'name_product' ? 'selected' : '' }}>
                        {{__('Name Product')}}</option>
                    <option value="fk_idProduct" {{ request('order_by') == 'fk_idProduct' ? 'selected' : '' }}>
                        {{__('ID Product')}}</option>
                    <option value="id" {{ request('order_by') == 'id' ? 'selected' : '' }}>
                        {{__('ID Inventory')}}</option>
                </select>
            </div>
        </div>
        <!-- Ascendente o descendente -->
        <div class="col-4">
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
        <!-- Tipo de inventario -->
        <div class="col-4">
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-tag"></i></span>
                <select name="filter" class="form-control form-control-sm" id="filterTypeSelect">
                    <option value="" disabled selected>{{__('Type')}}</option>
                    <option value="receipts">{{__('Receipts')}}</option>
                    <option value="shipments">{{__('Shipments')}}</option>
                    <option value="buys">{{__('Buys')}}</option>
                    <option value="devolutions">{{__('Devolution')}}</option>
                    <option value="sales">{{__('Sales')}}</option>
                    <option value="wastes">{{__('Wastes')}}</option>
                </select>
            </div>
        </div>
    </form>

    <!-- ########### FORMULARIO DE REGISTRO DE INVENTARIO ############ -->
    <div class="row">
        <div class="col-12">
            <div class="card mt-2 px-5 py-3">
                <form action="{{ route('inventory.store') }}" method="POST" id="newInventoryForm">
                    @csrf
                    <!-- Selección del producto -->
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-boxes-packing"></i></span>
                        <select class="form-control @error('fk_idProduct') is-invalid @enderror" name="fk_idProduct">
                            <option value="" disabled {{ old('fk_idProduct') == '' ? 'selected' : '' }}>
                                {{ __('Select a product') }}</option>
                            @foreach($products as $product)
                            <option value="{{ $product->id }}"
                                {{ old('fk_idProduct') == $product->id ? 'selected' : '' }}>
                                {{ $product->id .'. '.$product->name_product }}
                            </option>
                            @endforeach
                        </select>

                        @error('fk_idProduct')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Tipo de inventario (Entrada o Salida) -->
                    <div class="mt-3">
                        <div class="row mx-0 mx-md-5 px-0">
                            <div class="col-12">
                                <div class="d-flex flex-wrap justify-content-between">
                                    <!-- Tipo compra -->
                                    <div class="form-check mx-0 mx-md-2 px-0 px-md-0">
                                        <input type="radio" name="type" id="buy"
                                            class="form-check-input @error('type') is-invalid @enderror" value="buy"
                                            {{ old('type') == 'buy' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="buy">{{ __('Buy') }}</label>
                                    </div>
                                    <!-- Tipo venta -->
                                    <div class="form-check mx-0 mx-md-2 px-0 px-md-0">
                                        <input type="radio" name="type" id="sale"
                                            class="form-check-input @error('type') is-invalid @enderror" value="sale"
                                            {{ old('type') == 'sale' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sale">{{ __('Sale') }}</label>
                                    </div>
                                    <!-- Tipo devolución -->
                                    <div class="form-check mx-0 mx-md-2 px-0 px-md-0">
                                        <input type="radio" name="type" id="devolution"
                                            class="form-check-input @error('type') is-invalid @enderror"
                                            value="devolution" {{ old('type') == 'devolution' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="devolution">{{ __('Devolution') }}</label>
                                    </div>
                                    <!-- Tipo desecho -->
                                    <div class="form-check mx-0 mx-md-2 px-0 px-md-0">
                                        <input type="radio" name="type" id="waste"
                                            class="form-check-input @error('type') is-invalid @enderror" value="waste"
                                            {{ old('type') == 'waste' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="waste">{{ __('Waste') }}</label>
                                    </div>
                                </div>

                                @error('type')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- Botón para registro de inventario -->
                    <div class="mt-2">
                        <button type="submit" class="btn btn-outline-success w-100" form="newInventoryForm">
                            <i class="fa-solid fa-square-plus"></i>
                            {{__('Add to Inventory')}}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- ######### CONTENIDO DE REGISTROS ########## -->
    <!-- Mensaje si no hay registros que coincidan -->
    @if(isset($message_empty))
    <div class="alert alert-danger mt-2" role="alert">
        <i class="fa-solid fa-exclamation-triangle"></i> {{ $message_empty }}
        <form action="{{ route('inventory.index') }}" method="get" class="d-flex flex-sm-row mt-2">
            <input type="hidden" name="search">
            <button class="btn btn-link"><i class="fa-solid fa-rotate"></i> {{__('Reload')}} </button>
        </form>
    </div>
    @else
    <!-- Tabla de registros -->
    <div class="table-responsive mt-2">
        <table class="table table-sm table-hover text-center align-middle" id="table-content">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{__('Image')}}</th>
                    <th>{{__('Product')}}</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach($inventories as $inventory)
                @if($loop->first || $inventories[$loop->index - 1]->fk_idProduct != $inventory->fk_idProduct)
                <!-- Fila principal que muestra el nombre del producto -->
                <tr data-bs-toggle="collapse" data-bs-target="#collapse{{ $inventory->fk_idProduct }}"
                    aria-expanded="false" aria-controls="collapse{{ $inventory->fk_idProduct }}" class="product-row">
                    <td>{{ $inventory->fk_idProduct }}</td>
                    <td id="img-content">
                        <div class="image-prod-container">
                            @if($inventory->image)
                            <img src="{{ asset('uploads/product/'.$inventory->image) }}" class="img-fluid">
                            @else
                            <img src="{{ asset('resources/image-default.png') }}" class="img-fluid">
                            @endif
                        </div>
                    </td>
                    <td class="text-truncate text-nowrap">{{ $inventory->name_product }}</td>
                </tr>
                @endif
                <!-- Fila colapsable que muestra los tipos y botones -->
                @if($loop->first || $inventories[$loop->index - 1]->fk_idProduct != $inventory->fk_idProduct)
                <tr class="collapse" id="collapse{{ $inventory->fk_idProduct }}">
                    <td colspan="3" class="p-0">
                        <table class="table table-sm table-hover mb-0">
                            @foreach($inventories->where('fk_idProduct', $inventory->fk_idProduct) as $item)
                            <tr>
                                <td class="col-6 text-start align-middle">
                                    @switch($item->type)
                                        @case('buy')
                                            <p class="text-dark fw-normal fs-6 mb-0">{{__('Buy')}}</p>
                                        @break
                                        @case('devolution')
                                            <p class="text-dark fw-normal fs-6 mb-0">{{__('Devolution')}}</p>
                                        @break
                                        @case('sale')
                                            <p class="text-dark fw-normal fs-6 mb-0">{{__('Sale')}}</p>
                                        @break
                                        @case('waste')
                                            <p class="text-dark fw-normal fs-6 mb-0">{{__('Waste')}}</p>
                                        @break
                                    @endswitch
                                </td>
                                <td class="col-6 text-end align-middle">
                                    <button class="btn btn-sm btn-success me-2">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                    <button class="btn btn-sm btn-secondary me-2">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
        <!-- Mensaje rápido para tabla vacía -->
        <div class="alert alert-danger" id="message-empty">
            {{__('no matches in the 10 records shown, for a deeper search press the button with the icon')}}
            <i class="fa-solid fa-search"></i>
        </div>
        <div class="d-flex align-items-center justify-content-center">
            {{ $inventories->links() }}
        </div>
    </div>
    @endif
</div>

@if(session('exists'))
<script>
    var icon = @json('success')
    // Valores para mensajes de alerta
    @if(session()->has('store'))
        var sessionType = @json(session('store')); // Su session es 'store'
        var alertTitle = @json(__('Row added successfully')); // Título del mensaje
    @elseif(session()->has('update'))
        var sessionType = @json(session('update')); // Su session es 'update'
        var alertTitle = @json(__('Row updated successfully')); // Título del mensaje
    @elseif (session()->has('delete'))
        var sessionType = @json(session('delete')); // Su session es 'delete'
        var alertTitle = @json(__('Row deleted successfully')); // Título del mensaje
    @elseif (session()->has('exists'))
        var sessionType = @json(session('exists'));
        var alertTitle = @json(__('Row already exists')); // Título del mensaje
        var icon = @json('warning')
    @endif
</script>
@endif

@endsection