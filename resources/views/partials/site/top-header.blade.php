<header class="top-header th10 d-none d-lg-block d-md-block" id="top-header-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-7 col-7">
                <div class="list-inline">
                    <a href="#">
                        <i class="fa fa-map-marker"></i>
                        {{$entreprise->ADRESSE ?? 'Abidjan, Plateau'}}
                    </a>
                    <a href="mailto:{{$entreprise->ADR_EMAIL ?? 'info@bhci.ci'}}" class="d-none-768">
                        <i class="fa fa-envelope"></i>
                        {{$entreprise->ADR_EMAIL ?? 'info@bhci.ci'}}
                    </a>
                    <a href="tel:{{$entreprise->CONTACT1 ?? '+225 20 25 39 38'}}" class="d-none-768">
                        <i class="fa fa-phone"></i>
                        {{$entreprise->CONTACT1 ?? '+225 20 25 39 38'}}
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-5 col-5">
                <ul class="top-social-media pull-right">
                    <li>
                        @if(empty($us->ID_UTILISATEUR))
                            <a href="{{route('cnxPage_A')}}" class="sign-in">
                            <i class="fa fa-sign-in"></i> Connexion </a>
                        @else
                            @if ($us->ID_PROFIL>0 && $us->ID_PROFIL != Help::$CLIENT)
                                <a href="{{route('tdb')}}" class="sign-in">
                                <i class="fa fa-user"></i> BONJOUR, {{$us->PRENOMS ?? ''}} </a>
                            @else
                                <a href="{{route('tdbc')}}" class="sign-in">
                                <i class="fa fa-user"></i> BONJOUR, {{$us->PRENOMS ?? ''}} </a>
                            @endif
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
