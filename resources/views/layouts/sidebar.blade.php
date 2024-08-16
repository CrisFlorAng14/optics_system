<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3><img src="{{ asset('resources/imagotipo.png') }}" alt="" height="40"></h3>
            <strong><img src="{{ asset('resources/isotipo.png') }}" alt="" width="40"></strong>
        </div>

        <ul class="list-unstyled components">
            <li class="{{ request()->is('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}">
                    <i class="fa-solid fa-home"></i>
                    {{__('Home')}}
                </a>
            </li>
            <li class="{{ request()->is('users') ? 'active' : '' }}">
                <a href="{{ route('user.index') }}">
                    <i class="fa-solid fa-users"></i>
                    {{__('Users')}}
                </a>
            </li>
            <li>
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="{{ request()->is('products*') ? 'true' : 'false' }}" class="dropdown-toggle">
                    <i class="fa-solid fa-glasses"></i>
                    {{__('Products')}}
                </a>
                <ul class="collapse list-unstyled {{ request()->is('products*') || request()->is('inventories*') 
                    ? 'show' : '' }}" id="homeSubmenu">
                    <li class="{{ request()->is('products') ? 'active' : '' }}">
                        <a href="{{ route('product.index') }}">
                            {{__('Catalogue')}}
                        </a>
                    </li>
                    <li class="{{ request()->is('inventories') ? 'active' : '' }}">
                        <a href="{{ route('inventory.index') }}">
                            {{__('Inventory')}}
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

</div>


<!-- Obligatorio en esta vista -->
<!-- jQuery CDN - Slim version (=without AJAX) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

<script type="text/javascript">
$(document).ready(function() {
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
    });
});
</script>