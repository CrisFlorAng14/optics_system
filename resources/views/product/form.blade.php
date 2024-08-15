@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/product/create.css') }}">
<form action="{{ route('product.update',$product->id) }}" method="POST" enctype="multipart/form-data" id="updateProduct">
    @method('PUT')
    @csrf
    <div class="container">
        <div class="row">
            
            <div class="col-5 mt-2">
                <div class="d-flex align-items-start justify-content-start">
                    <a href="{{ route('product.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-rotate-left"></i>
                        {{__('Volver')}}
                    </a>
                    <button type="submit" class="btn btn-success mx-2" form="updateProduct">
                        <i class="fa-solid fa-check"></i>
                        {{__('Save')}}
                    </button>
                </div>
            </div>
            <div class="col-7 mt-2">
                <div class="d-flex align-items-end justify-content-end">
                    <h2 class="fw-2">{{__('Edit product #'.$product->id)}}</h2>
                </div>
            </div>

            <div class="col-12">
                <div class="input-group mt-2">
                    <!-- Nombre o Título del producto -->
                    <span class="input-group-text"><i class="fa-brands fa-product-hunt"></i></span>
                    <input type="text" name="name_product"
                        class="form-control @error('name_product') is-invalid @enderror"
                        placeholder="{{__('Product Name')}}" aria-label="{{__('Product Name')}}"
                        aria-describedby="name_product" value="{{ old('name_product', $product->name_product) }}">
                    @error('name_product')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <!-- Marca del producto -->
            <div class="col-12 col-md-6">
                <div class="input-group mt-2">
                    <span class="input-group-text"><i class="fa-solid fa-tag"></i></span>
                    <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror"
                        placeholder="{{__('Brand')}}" aria-label="{{__('Brand')}}" aria-describedby="brand"
                        value="{{ old('brand', $product->brand) }}">
                    @error('brand')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <!-- Categoría del producto -->
            <div class="col-12 col-md-6">
                <div class="input-group mt-2">
                    <span class="input-group-text"><i class="fa-solid fa-list"></i></span>
                    <input type="text" name="category" class="form-control @error('category') is-invalid @enderror"
                        placeholder="{{__('Category')}}" aria-label="{{__('Category')}}" aria-describedby="category"
                        value="{{ old('category', $product->category) }}">
                    @error('category')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <!-- Precio -->
            <div class="col-12 col-md-6">
                <div class="input-group mt-2">
                    <span class="input-group-text"><i class="fa-solid fa-comment-dollar"></i></span>
                    <input type="number" name="price"
                        class="form-control no-arrows @error('price') is-invalid @enderror"
                        placeholder="{{__('Price')}}" aria-label="{{__('Price')}}" aria-describedby="price"
                        value="{{ old('price', $product->price) }}">
                    @error('price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <!-- Stock o cantidad disponible -->
            <div class="col-12 col-md-6">
                <div class="input-group mt-2">
                    <span class="input-group-text"><i class="fa-solid fa-cubes-stacked"></i></span>
                    <input type="number" name="stock"
                        class="form-control no-arrows @error('stock') is-invalid @enderror"
                        placeholder="{{__('Stock')}}" aria-label="{{__('Stock')}}" aria-describedby="stock"
                        value="{{ old('stock', $product->stock) }}">
                    @error('stock')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <!-- Descripción -->
            <div class="col-12">
                <div class="input-group mt-2">
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="{{__('Enter a description')}}" id="descriptionInput"
                            name="description">{{ old('description', $product->description) }}</textarea>
                        <label for="descriptionInput" class="text-secondary">{{__('Enter a description')}}</label>
                    </div>
                </div>
            </div>
            <!-- imagen -->
            <div class="col-12 col-md-10 justify-content-center mt-2">
                <div class="file-drop-area py-5">
                    <span class="fake-btn">{{ __('Upload file') }}</span>
                    <span class="remove-image-btn btn btn-danger" style="display:none;">{{ __('Remove image') }}</span>
                    <span class="file-msg text-secondary">{{ __('Drag your image here') }}</span>
                    <input class="file-input @error('image') is-invalid @enderror" type="file" name="image" id="imgInput"
                        data-has-image="{{ $product->image ? 'true' : 'false' }}"
                        data-image-url="{{ $product->image ? asset('uploads/product/'.$product->image) : '' }}"
                        data-image-name="{{ $product->image ? $product->image : '' }}">
                    <input type="hidden" name="name_preview" id="inputHidden" value="{{ old('image',$product->image) }}">
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <!-- Previsualización de la imagen -->
            <div class="col-12 col-md-2 mt-2 d-flex justify-content-center">
                <div class="image-container card rounded">
                    <img id="image-preview" class="img-fluid"
                        src="{{ $product->image ? asset('uploads/product/'.$product->image) : asset('resources/image-default.png') }}"
                        alt="{{__('Image preview')}}">
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Script para comportamiento de imagen -->
<script>
    window.imageDefaultUrl = "{{ asset('resources/image-default.png') }}";
    var dropText = @json(__('Drag your image here')); // Título del mensaje
    var dragText = @json(__('Drop your image ')); // Título del mensaje
</script>
<script src="{{ asset('js/product/update.js') }}"></script>
@endsection