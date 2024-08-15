@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/product/show.css') }}">
<div class="container mt-2">
    <div class="row">
        <div class="col-4 mb-2">
            <a href="{{ route('product.index') }}" class="w-100 btn btn-secondary">
                <i class="fa-solid fa-rotate-left"></i>
                {{__('Back')}}
            </a>
        </div>
        <div class="col-4">
            <a href="{{ route('product.edit',$product->id) }}" class="w-100 btn btn-primary">
                <i class="fa-solid fa-pen"></i>
                {{__('Edit')}}
            </a>
        </div>
        <div class="col-4">
            <a href="" class="w-100 btn btn-danger">
                <i class="fa-solid fa-trash"></i>
                {{__('Delete')}}
            </a>
        </div>
        <!-- ######### IMAGEN ####### -->
        <!-- Imagen del producto -->
        <div class="col-12 col-md-5">
            <div class="d-flex justify-content-center px-0 px-md-5">
                <div class="image-container card rounded border-0">
                    <img id="image-preview" class="img-fluid"
                        src="{{ $product->image ? asset('uploads/product/'.$product->image) : asset('resources/image-default.png') }}">
                </div>
            </div>
        </div>
        <!-- ########### DATOS DEL PRODUCTO ######### -->
        <div class="col-12 col-md-7 mt-2 mt-md-0 mb-2">
            <div class="card">
                <div class="card-body">
                    <!-- Nombre del producto -->
                    <h2 class="fs-3 fw-semibold">{{$product->name_product }}</h2>
                    <div class="d-flex align-items-start justify-content-start">
                        <h3 class="fs-5 fw-normal t-brand">{{ $product->brand }}</h3>
                        <h3 class="fs-5 fw-normal text-secondary mx-5">{{ $product->category }}</h3>
                    </div>
                    <!-- Precio del archivo -->
                    <div class="d-flex flex-row align-items-center">
                        <p class="fw-normal fs-2 text-dark">
                            ${{ number_format(floor($product->price), 0, '.', ',') }}
                        </p>
                        <div class="mb-4">
                            <span class="fs-6">
                                @if(fmod($product->price,1) == 0)
                                00
                                @else
                                {{ substr(str_replace(floor($product->price), '', $product->price), 1) }}
                                @endif
                            </span>
                        </div>
                    </div>
                    <!-- Stock o cantidad disponible -->
                    <p class="fw-normal text-dark t-stock">{{__('Available: ')}} <strong>{{ $product->stock }}</strong></p>
                    <!-- Descripción -->
                    <p class="fw-semibold text-dark mb-0">{{__('Description')}}</p>
                    <p class="fw-normal text-dark fs-6 mb-0">{!! nl2br(e($product->description)) !!}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection