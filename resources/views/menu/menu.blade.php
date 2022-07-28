@foreach($menus as $menu)
    @if(count($menu->childs))
        <li class="nav-item nav-item-submenu {{ in_array($menu->menu_cd, $activeMenus) ? 'nav-item-expanded nav-item-open' : ''}}">
            <a href="#" class="nav-link {{ $menu->menu_url == request()->path() ? 'active' : ''}}"><i class="{{ $menu->menu_image ? $menu->menu_image : 'icon-circles'}}"></i> <span>{{ $menu->menu_nm }}</span></a>
            @include('menu.child-menu',['childs' => $menu->childs])
        </li>
    @else
        <li class="nav-item"><a href="{{ url($menu->menu_url) }}" class="nav-link {{ $menu->menu_url == request()->path() ? 'active' : ''}}"><i class="{{ $menu->menu_image ? $menu->menu_image : 'icon-circles'}}"></i> <span>{{$menu->menu_nm}}</span></a></li>
    @endif
@endforeach

