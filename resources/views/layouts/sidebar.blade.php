    <!-- Main sidebar -->
    <div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

        <!-- Sidebar mobile toggler -->
        <div class="sidebar-mobile-toggler text-center">
            <a href="#" class="sidebar-mobile-main-toggle">
                <i class="icon-arrow-left8"></i>
            </a>
            Navigasi
            <a href="#" class="sidebar-mobile-expand">
                <i class="icon-screen-full"></i>
                <i class="icon-screen-normal"></i>
            </a>
        </div>
        <!-- /sidebar mobile toggler -->


        <!-- Sidebar content -->
        <div class="sidebar-content">
            
            <!-- User menu -->
            <div class="sidebar-user-material">
                <div class="sidebar-user-material-body">
                    <div class="card-body text-center">
                        <a href="#">
                            <!--<img src="{{ asset('') }}{{ Auth::user()->image }}" class="img-fluid rounded-circle shadow-1 mb-3" width="80" height="80" alt="" style="background:#fff">-->
            
                            @php
                            if (Auth::user()->image != NULL) {
                                $strImage = Auth::user()->image;
                            }else{
                                $strImage = '/images/favicon.ico';
                            }
                            @endphp

                            <!--<img src="{{ asset('') }}{{ $strImage }}" class="img-fluid rounded-circle shadow-1 mb-3" width="80" height="80" alt="" style="background:#fff">-->
							
							@if (Auth::user()->image == NULL)                                     
                                <img class="img-fluid rounded-circle shadow-1 mb-3" src="{{ asset('/images/favicon.ico') }}" width="80" height="80" alt="" style="background:#fff">
                            @else
                                <img class="img-fluid rounded-circle shadow-1 mb-3" src="{{ asset('/storage/file/image/') }}/{{ Auth::user()->image }}" width="80" height="80" style="background: #fff" alt="" style="background:#fff">
                            @endif
                        </a>
                        <h6 class="mb-0 text-white text-shadow-dark">{{ Auth::user()->user_nm }}</h6>
                        <span class="font-size-sm text-white text-shadow-dark">{{ Auth::user()->user_id }}</span>
                    </div>
                                                
                    <div class="sidebar-user-material-footer">
                        <a href="#user-nav" class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle" data-toggle="collapse"><span>Akun</span></a>
                    </div>
                </div>

                <div class="collapse" id="user-nav">
                    <ul class="nav nav-sidebar">
                        <li class="nav-item">
                            <a href="/my-profile" class="nav-link">
                                <i class="icon icon-user"></i>
                                <span>Profil</span>
                            </a>
                        </li>
                        {{--
						<li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="icon-comment-discussion"></i>
                                <span>Messages</span>
                                <span class="badge bg-success-400 badge-pill align-self-center ml-auto"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="icon-cog5"></i>
                                <span>Account settings</span>
                            </a>
                        </li>
						--}}
                        <li class="nav-item">
                            <a href="#" class="nav-link"  onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <i class="icon-switch2"></i>
                                <span>{{ __('Logout') }}</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /user menu -->

            
            <!-- Main navigation -->
            <div class="card card-sidebar-mobile">
                <ul class="nav nav-sidebar" data-nav-type="accordion">

                    <!-- Main -->
                    {{--
					<li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs">Main</div> 
                        <i class="icon-menu" title="Main"></i>
                    </li>
					--}}
                    <li class="nav-item">
                        <a href="/" class="nav-link">
                            <i class="icon icon-home2"></i>
                            <span>
                                Dashboard
                                {{-- <span class="d-block font-weight-normal opacity-50">Message</span> --}}
                            </span>
                        </a>
                    </li>

                    @php
                    $Menu = new App\Http\Controllers\MenuController;
                    @endphp
                    @include('menu.menu',['activeMenus'=> $Menu->getActiveMenus() ,'menus' => $Menu->getMenuSide()])

                    <!-- /main -->                        
                </ul>
            </div>
            <!-- /main navigation -->

        </div>
        <!-- /sidebar content -->
        
    </div>
    <!-- /main sidebar -->