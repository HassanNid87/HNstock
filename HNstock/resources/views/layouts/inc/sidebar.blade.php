<div data-simplebar class="sidebar-menu-scroll">
    <!--- Sidemenu -->
    <div id="sidebar-menu">
        <!-- Left Menu Start -->
        <ul class="metismenu list-unstyled" id="side-menu">
            @foreach (config('routes') as $route)
                <li>
                    <a href="{{ route($route['route']) }}">
                        <i class="uil-{{ $route['icon'] }}"></i>
                        <span>{{ $route['name'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

