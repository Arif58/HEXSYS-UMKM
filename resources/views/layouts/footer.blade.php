    <!-- Footer -->
    <div class="navbar navbar-expand-lg navbar-light">
        <div class="text-center d-lg-none w-100">
            <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
                <i class="icon-unfold mr-2"></i>
                {{ configuration("APP_NAME") }}
            </button>
        </div>

        <div class="navbar-collapse collapse" id="navbar-footer">
            <span class="navbar-text">
                {{ configuration("APP_NAME")." ".configuration("INST_NAME") }} &copy; {{ "2020 - ".date('Y') }}
            </span>
            @if (Request::path() == '/')
                {{-- <span class="navbar-text ml-auto">
                    Dashboard Icons made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a>
                </span> --}}
            @endif
			<!--
            <ul class="navbar-nav ml-lg-auto">
                <li class="nav-item"><a href="https://instagram.com" class="navbar-nav-link" target="_blank"><i class="icon-instagram mr-2"></i> Instagram</a></li>
                <li class="nav-item"><a href="https://twitter.com/" class="navbar-nav-link" target="_blank"><i class="icon-twitter mr-2"></i> Twitter</a></li>
            </ul>
			-->
        </div>
    </div>
    <!-- /footer -->
