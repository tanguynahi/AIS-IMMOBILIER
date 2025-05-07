<nav id="sidebar" class="nav-sidebar">
    <div id="dismiss">
        <i class="fa fa-close"></i>
    </div>
    <div class="sidebar-inner">
        <div class="sidebar-logo">
            <a href="{{route('home')}}">
                <img src="{{ asset($entreprise->LOGO ?? Help::$LOGO) }}" alt="sidebarlogo">
            </a>
        </div>
        <div class="sidebar-navigation">
            <h3 class="heading">Pages</h3>
            <ul class="menu-list">
                <li>
                    <a href="#" class="pt0">
                        Catégories <em class="fa fa-chevron-down"></em>
                    </a>
                    <ul>
                        @foreach ($categories as $key => $value)
                            <li>
                                <a href="{{route('listByCategories',['type'=>0, 'idCategories'=>$value->ID_CATEGORIES, 'act'=>'ls'])}}">
                                    {{ $value->LIB_CATEGORIE ?? 'categorie' }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li>
                    <a href="{{route('serviceOur')}}"
                        aria-haspopup="true" aria-expanded="false">
                        Services
                    </a>
                </li>
                <li>
                    <a href="{{route('aproposUs')}}"
                        aria-haspopup="true" aria-expanded="false">
                        A Propos
                    </a>
                </li>
                <li>
                    <a href="{{route('contactUs')}}"
                        aria-haspopup="true" aria-expanded="false">
                        Contact
                    </a>
                </li>
                <li>
                    <li class="nav-item">
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
                    <li class="nav-item" hidden>
                        @if(!isset($us->ID_UTILISATEUR) && $us->ID_UTILISATEUR<=0)
                            <a href="{{route('registerAccount')}}" class="nav-link link-color" title="Creer un compte">
                            <i class="fa fa-plus"></i> Compte</a>
                        @endif
                    </li>
                </li>
            </ul>
        </div>
        <div class="get-in-touch">
            <h3 class="heading">Entrer en contact</h3>
            <div class="get-in-touch-box d-flex">
                <i class="flaticon-phone"></i>
                <div class="detalis">
                    <a href="tel:{{$entreprise->CONTACT1 ?? '+225 20 25 39 38'}}">{{$entreprise->CONTACT1 ?? '+225 20 25 39 38'}}</a>
                </div>
            </div>
            <div class="get-in-touch-box d-flex">
                <i class="flaticon-mail"></i>
                <div class="detalis">
                    <a href="mailto:{{$entreprise->ADR_EMAIL ?? 'info@bhci.ci'}}">{{$entreprise->ADR_EMAIL ?? 'info@bhci.ci'}}</a>
                </div>
            </div>
        </div>
        <div class="get-social">
            <h3 class="heading">Reseaux</h3>
            <a href="{{$entreprise->URLFBK ?? '#'}}" class="facebook-bg">
                <i class="fa fa-facebook"></i>
            </a>
            <a href="{{$entreprise->URLTWT ?? '#'}}" class="twitter-bg">
                <i class="fa fa-twitter"></i>
            </a>
            <a href="{{$entreprise->URLLINK ?? '#'}}" class="linkedin-bg">
                <i class="fa fa-linkedin"></i>
            </a>
        </div>
    </div>
</nav>
