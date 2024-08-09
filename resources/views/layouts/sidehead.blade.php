<link rel="stylesheet" href="{{ asset('css/sidehead.css') }}">
<nav class="navbar navbar-expand-md navbar-light shadow-sm sticky-top mb-0">
    <div class="container">
        @guest
        <!-- Logo -->
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('resources/imagotipo.png') }}" alt="Logo" height="40">
        </a>
        @else
        <!-- Botón para colapsar barra lateral -->
        <button type="button" id="sidebarCollapse" class="btn">
            <i class="fas fa-caret-left"></i>
        </button>
        @endguest
        <!-- Botón para dispositivos pequeños -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Links de autenticación e inicio -->
                @guest
                @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link px-2" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @endif

                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link px-2" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif

                <li class="nav-item">
                    <a href="" class="nav-link px-2">{{__('Contact')}}</a>
                </li>
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link px-2" href="#" role="button" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="mx-1"><i class="fa-solid fa-caret-down"></i></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <!-- Cerrar sesión -->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<!-- Script para alternar el botón para colapsar la barra de navegación lateral -->
<script>
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $(this).toggleClass('collapsed');
            // Si el elemento está colapsado
            if ($(this).hasClass('collapsed')) {
                // Se muestra el icono con flecha a la derecha
                $(this).html('<i class="fa-solid fa-caret-right"></i>');
            } else {
                // Sino, se muestra el icono con flecha a la izquierda
                $(this).html('<i class="fa-solid fa-caret-left"></i>');
                
            }
        });
    });
</script>