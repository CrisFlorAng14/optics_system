@extends('layouts.app')
@section('title',__('Dashboard'))
@section('content')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">

<div class="container text-center d-flex justify-content-center align-items-center mt-3 mt-md-5 dashboard">
    <div class="d-flex flex-wrap justify-content-center align-items-center">
        <div class="row mx-5 justify-content-center align-items-center">
            
            <a href="{{ route('user.index') }}" class="col-sm-3 mb-3 mx-md-2 btn btn-lg btn-block p-4 d-button"
                style="background-color:#006CE5;">
                <i class="fa-solid fa-users"></i><br>
                {{__('Users')}}
            </a>
            
            <a href="{{ route('product.index') }}" class="col-sm-3 mb-3 mx-md-2 btn btn-lg btn-block p-4 d-button"
                style="background-color:#0A97A5;">
                <i class="fa-solid fa-glasses"></i><br>
                {{__('Products')}}
            </a>

            <a href="" class="col-sm-3 mb-3 mx-md-2 btn btn-lg btn-block p-4 d-button"
                style="background-color:#696969;">
                <i class="fa-solid fa-boxes"></i><br>
                {{__('Inventory')}}
            </a>

            <a href="" class="col-sm-3 mb-3 mx-md-2 btn btn-lg btn-block p-4 d-button"
                style="background-color:#F12F2F;">
                <i class="fa-solid fa-chart-line"></i><br>
                {{__('Reports')}}
            </a>
            
            <a href="" class="col-sm-3 mb-3 mx-md-2 btn btn-lg btn-block p-4 d-button"
                style="background-color:#DEA70C;">
                <i class="fa-solid fa-images"></i><br>
                {{__('Covers')}}
            </a>
            
            <a href="" class="col-sm-3 mb-3 mx-md-2 btn btn-lg btn-block p-4 d-button"
                style="background-color:#0E8318;">
                <i class="fa-solid fa-circle-dollar-to-slot"></i><br>
                {{__('Sales')}}
            </a>
            
            <a href="" class="col-sm-3 mb-3 mx-md-2 btn btn-lg btn-block p-4 d-button text-break"
                style="background-color:#E200E2;">
                <i class="fa-solid fa-store"></i><br>
                {{__('Points')}}
            </a>

            <a href="" class="col-sm-3 mb-3 mx-md-2 btn btn-lg btn-block p-4 d-button"
                style="background-color:#E55300;">
                <i class="fa-solid fa-comments"></i><br>
                {{__('Blog')}}
            </a>

            <a href="" class="col-sm-3 mb-3 mx-md-2 btn btn-lg btn-block p-4 d-button text-break"
                style="background-color:#6000E2;">
                <i class="fa-solid fa-calendar-days"></i><br>
                {{__('Calendar')}}
            </a>
            
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    $('.btn-lg').hover(
        function() {
            // Al pasar el mouse sobre el elemento
            $(this).css('--original-color', $(this).css('background-color'));
            $(this).css('--original-background-color', $(this).css('color'));

            $(this).css('background-color', $(this).css('color'));
            $(this).css('color', $(this).css('--original-color'));
            $(this).css('border', 'solid 1px ' + $(this).css('--original-color'));
        },
        function() {
            // Al quitar el mouse del elemento
            $(this).css('background-color', $(this).css('--original-color'));
            $(this).css('color', $(this).css('--original-background-color'));
            $(this).css('border', 'solid 1px ' + $(this).css('--original-background-color'));
        }
    );
});
</script>
@endsection