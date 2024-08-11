<link rel="stylesheet" href="{{ asset('css/product/create.css') }}">
<div class="row">
    <div class="col-12">
        <div class="input-group mt-2">
            <!-- Nombre o Título del producto -->
            <span class="input-group-text"><i class="fa-brands fa-product-hunt"></i></span>
            <input type="text" name="name_product" class="form-control @error('name_product') is-invalid @enderror"
                placeholder="{{__('Product Name')}}" aria-label="{{__('Product Name')}}" aria-describedby="name_product"
                value="{{ old('name_product') }}">
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
                value="{{ old('brand') }}">
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
                value="{{ old('category') }}">
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
            <input type="number" name="price" class="form-control no-arrows @error('price') is-invalid @enderror"
                placeholder="{{__('Price')}}" aria-label="{{__('Price')}}" aria-describedby="price"
                value="{{ old('price') }}">
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
            <input type="number" name="stock" class="form-control no-arrows @error('stock') is-invalid @enderror" 
                placeholder="{{__('Stock')}}"
                aria-label="{{__('Stock')}}" aria-describedby="stock" value="{{ old('stock') }}">
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
                    name="description">{{ old('description') }}</textarea>
                <label for="descriptionInput" class="text-secondary">{{__('Enter a description')}}</label>
            </div>
        </div>
    </div>
</div>