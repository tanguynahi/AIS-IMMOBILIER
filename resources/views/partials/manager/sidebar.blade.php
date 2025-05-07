<nav id="sidebar" class="nav-sidebar">
    <div id="dismiss">
        <i class="fa fa-close"></i>
    </div>
    <div class="sidebar-inner">
        <div class="sidebar-logo">
            <img src="{{ asset($entreprise->LOGO ?? Help::$LOGO) }}" alt="sidebarlogo">
        </div>
        <div class="sidebar-navigation">
            @if (Help::optAutorise(['PRO', 'RED', 'CAT', 'SER', 'APR', 'FAG', 'AGT', 'ZZZ'], $us->ID_UTILISATEUR))
            <ul class="menu-list">
                <li>
                    <a href="#" class="pt0">Fichiers<em class="fa fa-chevron-down"></em></a>
                    <ul>
                        @if (Help::optAutorise(['PRO', 'ZZZ'], $us->ID_UTILISATEUR))
                        <li><a href="{{route('banniereList')}}">Bannières </a></li>
                        @endif
                        @if (Help::optAutorise(['PRO', 'ZZZ'], $us->ID_UTILISATEUR))
                        <li><a href="{{route('proprieteList')}}">Propriétés </a></li>
                        @endif
                        @if (Help::optAutorise(['RED', 'ZZZ'], $us->ID_UTILISATEUR))
                        <li><a href="{{route('redevanceList')}}">Redevances </a></li>
                        @endif
                        @if (Help::optAutorise(['CAT', 'ZZZ'], $us->ID_UTILISATEUR))
                        <li><a href="{{route('categorieList')}}">Categories</a></li>
                        @endif
                        @if (Help::optAutorise(['SER', 'ZZZ'], $us->ID_UTILISATEUR))
                        <li><a href="{{route('serviceList')}}">Services</a></li>
                        @endif
                        @if (Help::optAutorise(['APR', 'ZZZ'], $us->ID_UTILISATEUR))
                        <li><a href="{{route('aproposList')}}">A Propos</a></li>
                        @endif
                        @if (Help::optAutorise(['FAG', 'ZZZ'], $us->ID_UTILISATEUR))
                        <li><a href="{{route('fonctionList')}}">Fonctions</a></li>
                        @endif
                        @if (Help::optAutorise(['AGT', 'ZZZ'], $us->ID_UTILISATEUR))
                        <li><a href="{{route('agentList')}}">Agents/Personnels</a></li>
                        @endif
                    </ul>
                </li>
            </ul>
            @endif
            <ul class="menu-list">
                <hr>
                <li class="@if (request()->routeIs('tdb')) active @endif">
                    <a href="{{ route('tdb') }}">&nbsp;Tableau de bord </a>
                </li>
                @if (Help::optAutorise(['MSG', 'ZZZ'], $us->ID_UTILISATEUR))
                <li class="@if (request()->routeIs('messageList')) active @endif">
                    <a href="{{route('messageList')}}">&nbsp;Messages </a>
                </li>
                @endif
                @if (Help::optAutorise(['DEM', 'ZZZ'], $us->ID_UTILISATEUR))
                <li class="@if (request()->routeIs('demVisitList') || request()->routeIs('demandeForm')) active @endif">
                    <a href="{{route('demVisitList')}}">&nbsp;Demandes </a>
                </li>
                @endif
                @if (Help::optAutorise(['PSP', 'ZZZ'], $us->ID_UTILISATEUR))
                <li class="@if (request()->routeIs('prospectList')) active @endif">
                    <a href="{{route('prospectList')}}">&nbsp;Prospect </a>
                </li>
                @endif
                @if (Help::optAutorise(['CLI', 'ZZZ'], $us->ID_UTILISATEUR))
                <li class="@if (request()->routeIs('clientList') || request()->routeIs('clientForm')
                    || request()->routeIs('affDetail') || request()->routeIs('affFormCli')) active @endif">
                    <a href="{{route('clientList')}}">&nbsp;Client </a>
                </li>
                @endif
                @if (Help::optAutorise(['AFF', 'ZZZ'], $us->ID_UTILISATEUR))
                <li class="@if (request()->routeIs('affaireList') || request()->routeIs('affaireForm')) active @endif">
                    <a href="{{route('affaireList')}}">&nbsp;Propriétés acquises </a>
                </li>
                @endif
                @if (Help::optAutorise(['FAC', 'ZZZ'], $us->ID_UTILISATEUR))
                <li class="@if (request()->routeIs('liaisonList') || request()->routeIs('liaisonForm')) active @endif">
                    <a href="{{route('liaisonList')}}">&nbsp;Facturation </a>
                </li>
                @endif
                @if (Help::optAutorise(['REG', 'ZZZ'], $us->ID_UTILISATEUR))
                <li class="@if (request()->routeIs('paiementList') || request()->routeIs('paiemForm')) active @endif">
                    <a href="{{route('paiementList')}}">&nbsp;Suivis des Paiements </a>
                </li>
                @endif
                @if (Help::optAutorise(['PAR', 'ACC', 'ZZZ'], $us->ID_UTILISATEUR))
                <li class="@if (request()->routeIs('entrepriseInfos')) active @endif">
                    <a href="{{ route('entrepriseInfos') }}">&nbsp;Configurations </a>
                </li>
                @endif
            </ul>
        </div>
        <div class="sidebar-logo"><a href="{{ route('deconnexion') }}">&nbsp;Deconnexion </a></div>
        <div class="get-in-touch" class="text-center">
            <div style="color: black" class="text-center"> IMMOBILIER-STORE. <br /> © 2024 Tous droits reservés.</div>
        </div>
    </div>
</nav>
