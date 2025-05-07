<header class="main-header sticky-header header-with-top2" id="main-header-2">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand logos" href="{{route('home')}}">
                <img src="{{ asset($entreprise->LOGO ?? Help::$LOGO) }}" alt="logo">
            </a>
            <button class="navbar-toggler" id="drawer" type="button">
                <span class="fa fa-bars"></span>
            </button>
            <div class="navbar-collapse collapse w-100 justify-content-end" id="navbar">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item sp">
                        <a href="{{route('mesInfosCli')}}" class="nav-link h-icon">
                        <i class="fa fa-user"></i> BONJOUR, {{$us->PRENOMS ?? ''}} </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
