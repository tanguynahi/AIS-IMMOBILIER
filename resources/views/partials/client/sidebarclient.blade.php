<nav id="sidebar" class="nav-sidebar">
    <div id="dismiss">
        <i class="fa fa-close"></i>
    </div>
    <div class="sidebar-inner">
        <div class="sidebar-logo">
            <img src="{{ asset($entreprise->LOGO ?? Help::$LOGO) }}" alt="sidebarlogo">
        </div>
        <div class="sidebar-navigation">
            <h3 class="heading">MENU</h3>
            <ul class="menu-list">
                <li class="@if (request()->routeIs('tdbc')) active @endif">
                    <a href="{{ route('tdbc') }}">&nbsp;Tableau de bord </a>
                </li>
                <li class="@if (request()->routeIs('messageListCli') || request()->routeIs('messageDetailCli')
                    || request()->routeIs('messageNouveauCli')) ) active @endif">
                    <a href="{{route('messageListCli')}}">
                        <i class="flaticon-mail"></i>&nbsp;Boite de reception
                        <span class="nav-tag">{{ Help::cliNbNonLu($us->ADR_EMAIL) ?? 0 }}</span>
                    </a>
                </li>
                <li class="@if (request()->routeIs('demClientList') || request()->routeIs('demCliForm')) active @endif">
                    <a href="{{route('demClientList')}}">&nbsp;Mes Demandes </a>
                </li>
                <li class="@if (request()->routeIs('proprieteGet') || request()->routeIs('affaireCliForm')
                    || request()->routeIs('paiementAffList') || request()->routeIs('documentForm')) active @endif">
                    <a href="{{route('proprieteGet')}}">&nbsp;Propriétés Acquis</a>
                </li>
                <li class="@if (request()->routeIs('paiemCliForm') || request()->routeIs('filePaiementList') ||
                    request()->routeIs('documentForm') || request()->routeIs('paiemClientList')) active @endif">
                    <a href="{{route('paiemClientList')}}">&nbsp;Paiements </a>
                </li>
                <li class="@if (request()->routeIs('mesInfosCli')) active @endif">
                    <a href="{{route('mesInfosCli')}}">&nbsp;Mes Informations </a>
                </li>
            </ul>
        </div>
        <div class="sidebar-logo"><a href="{{route('nouvPaiement',['id'=>0])}}">
            <i class="flaticon-plus"></i>&nbsp;Nouveau Paiement</a>
        </div>
        <div class="sidebar-logo"><a href="{{ route('deconnexion') }}">&nbsp;Deconnexion </a></div>
        <div class="get-in-touch" class="text-center">
            <div style="color: black" class="text-center"> {{$entreprise->RAISON_SOCIALE ?? 'IMMOBILIER-STORE'}}. <br /> © 2024 Tous droits reservés.</div>
        </div>
        <div class="get-social">
            <h3 class="heading">RESEAUX</h3>
            <a href="{{$entreprise->URLFBK ?? '#'}}" class="facebook-bg">
                <i class="fa fa-facebook"></i>
            </a>
            <a href="{{$entreprise->URLTWT?? '#'}}" class="twitter-bg">
                <i class="fa fa-twitter"></i>
            </a>
            <a href="{{$entreprise->URLLINK ?? '#'}}" class="linkedin-bg">
                <i class="fa fa-linkedin"></i>
            </a>
        </div>
    </div>
</nav>
