<ul class="nav nav-group-sub" data-submenu-title="Menu levels">
    @foreach($childs as $child)
        @if(count($child->childs))
            <li class="nav-item nav-item-submenu {{ in_array($child->menu_cd, $activeMenus) ? 'nav-item-expanded nav-item-open' : ''}}"><a href="#" class="nav-link"><i class="{{ $child->menu_image ? $child->menu_image : 'icon-circles'}}"></i> {{$child->menu_nm}}</a>
                @include('menu.child-menu',['childs' => $child->childs])
            </li>
        @else
            <li class="nav-item"><a href="{{ url($child->menu_url) }}" class="nav-link {{ in_array($child->menu_cd, $activeMenus) ? 'active' : ''}}"><i class="{{ $child->menu_image ? $child->menu_image : 'icon-circles'}}"></i> {{$child->menu_nm}}</a></li>
        @endif
    @endforeach
</ul>