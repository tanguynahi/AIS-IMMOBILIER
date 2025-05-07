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
                    @if (Help::optAutorise(['PRO', 'ZZZ'], $us->ID_UTILISATEUR))
                    <li class="nav-item sp">
                        <a class="nav-link link-color" href="{{route('banniereList')}}">Banières </a>
                    </li>
                    @endif
                    @if (Help::optAutorise(['PRO', 'ZZZ'], $us->ID_UTILISATEUR))
                    <li class="nav-item sp">
                        <a class="nav-link link-color" href="{{route('proprieteList')}}">Propriétés </a>
                    </li>
                    @endif
                    @if (Help::optAutorise(['RED', 'ZZZ'], $us->ID_UTILISATEUR))
                    <li class="nav-item sp">
                        <a class="nav-link link-color" href="{{route('redevanceList')}}">Redevances </a>
                    </li>
                    @endif
                    @if (Help::optAutorise(['CAT', 'ZZZ'], $us->ID_UTILISATEUR))
                    <li class="nav-item sp">
                        <a href="{{route('categorieList')}}" class="nav-link link-color">Categories</a>
                    </li>
                    @endif
                    @if (Help::optAutorise(['SER', 'APR', 'FAG', 'AGT', 'ZZZ'], $us->ID_UTILISATEUR))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Fichier
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            @if (Help::optAutorise(['SER', 'ZZZ'], $us->ID_UTILISATEUR))
                            <li><a class="dropdown-item" href="{{route('serviceList')}}">Services</a></li>
                            @endif
                            @if (Help::optAutorise(['APR', 'ZZZ'], $us->ID_UTILISATEUR))
                            <li><a class="dropdown-item" href="{{route('aproposList')}}">A Propos</a></li>
                            @endif
                            @if (Help::optAutorise(['FAG', 'ZZZ'], $us->ID_UTILISATEUR))
                            <li><a class="dropdown-item" href="{{route('fonctionList')}}">Fonctions</a></li>
                            @endif
                            @if (Help::optAutorise(['AGT', 'ZZZ'], $us->ID_UTILISATEUR))
                            <li><a class="dropdown-item" href="{{route('agentList')}}">Agents/Personnels</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    <li class="nav-item sp">
                        <a href="{{route('tdb')}}" class="nav-link h-icon">
                        <i class="fa fa-user"></i> BONJOUR, {{$us->PRENOMS ?? ''}} </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
