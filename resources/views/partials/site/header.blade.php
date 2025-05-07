<header class="main-header sticky-header header-with-top{{$topheader ?? ''}}" id="main-header-2">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand logos" href="{{route('home')}}">
                <img src="{{ asset($entreprise->LOGO ?? Help::$LOGO) }}" alt="logo">
            </a>
            <button class="navbar-toggler" id="drawer" type="button">
                <span class="fa fa-bars"></span>
            </button>
            <div class="navbar-collapse collapse w-100 justify-content-end" id="navbar">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="{{route('home')}}" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Accueil
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Catégories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            @foreach ($categories as $key => $value)
                                <li>
                                    <a class="dropdown-item"
                                    href="{{route('listByCategories',['type'=>0, 'idCategories'=>$value->ID_CATEGORIES, 'act'=>'ls'])}}">
                                    {{ $value->LIB_CATEGORIE ?? 'categorie' }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{route('serviceOur')}}" aria-haspopup="true" aria-expanded="false">
                            Services
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{route('aproposUs')}}" aria-haspopup="true" aria-expanded="false">
                            A Propos
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{route('contactUs')}}" aria-haspopup="true" aria-expanded="false">
                            Contact
                        </a>
                    </li>
                    <li class="nav-item sp">
                        @if(!isset($us->ID_UTILISATEUR) && $us->ID_UTILISATEUR<=0)
                            <a href="{{route('cnxPage_A')}}" class="nav-link h-icon">
                            <i class="fa fa-user"></i> Connexion </a>
                        @else
                            @if ($us->ID_PROFIL>0 && $us->ID_PROFIL != Help::$CLIENT)
                                <a href="{{route('tdb')}}" class="nav-link h-icon">
                                <i class="fa fa-user"></i> BONJOUR, {{$us->PRENOMS ?? ''}} </a>
                            @else
                                <a href="{{route('tdbc')}}" class="nav-link h-icon">
                                <i class="fa fa-user"></i> BONJOUR, {{$us->PRENOMS ?? ''}} </a>
                            @endif
                        @endif
                    </li>
                    <li class="nav-item sp" hidden>
                        @if(!isset($us->ID_UTILISATEUR) && $us->ID_UTILISATEUR<=0)
                        <a href="{{route('registerAccount')}}" class="nav-link link-color" title="Creer un compte">
                        <i class="fa fa-plus"></i> Compte</a>
                        @endif
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
