<style>
.navbar-brand img {
    height: 1.5rem;
    display: block;
}
</style>
<!-- Main navbar -->
<div class="navbar navbar-expand-md navbar-dark navbar-static">

    <!-- Header with logos -->
    <div class="navbar-header navbar-dark d-none d-md-flex align-items-md-center">
        <div class="navbar-brand navbar-brand-md">
            <a href="{{ url('/') }}" class="d-inline-block w-100">
            <img src="{{ asset('/images/logo-brin.png') }}" class="center mx-auto" alt="">
            </a>
        </div>
        <div class="navbar-brand navbar-brand-xs">
            <a href="{{ url('/') }}" class="d-inline-block w-100">
            <img src="{{ asset('/images/favicon.ico') }}"class="mx-auto" alt="">
            </a>
        </div>
    </div>
    <!-- /header with logos -->


    <!-- Mobile controls -->
    <div class="d-flex flex-1 d-md-none">
        <div class="navbar-brand mr-auto">
            <a href="index.html" class="d-inline-block">
                <img src="/{{ configuration('INST_LOGO') }}" alt="">
            </a>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-tree5"></i>
        </button>

        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
    </div>
    <!-- /mobile controls -->


    <!-- Navbar content -->
    <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                    <i class="icon-paragraph-justify3"></i>
                </a>
            </li>
        </ul>
        <span class="navbar-text ml-md-3">
            <span class="badge badge-mark border-white-300 mr-1"></span>
            {{ salam() }}
        </span>

        <span class="navbar-text ml-md-3 mr-md-auto">
        </span>
    </div>
    <!-- /navbar content -->

</div>
<!-- /main navbar -->
