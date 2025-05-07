<div class="dashboard-nav">
    <div class="dashboard-inner">
        <h4>MENU</h4>
        <ul>
            <li class="@if (request()->routeIs('tdb')) active @endif">
                <a href="{{ route('tdb') }}"><i class="flaticon-dashboard"></i>Tableau de bord </a>
            </li>
            @if (Help::optAutorise(['MSG', 'DEM', 'ZZZ'], $us->ID_UTILISATEUR))
                @if (Help::optAutorise(['MSG', 'ZZZ'], $us->ID_UTILISATEUR))
                <li class="@if (request()->routeIs('messageList') || request()->routeIs('messageDetail')
                    || request()->routeIs('messageNouveau')) ) active @endif">
                    <a href="{{route('messageList')}}">
                        <i class="flaticon-mail"></i>Messages
                        <span class="nav-tag">{{Help::NbNonLu($us->ID_ENTREPRISE) ?? 0}}</span>
                    </a>
                </li>
                @endif
                @if (Help::optAutorise(['DEM', 'ZZZ'], $us->ID_UTILISATEUR))
                <li class="@if (request()->routeIs('demVisitList') || request()->routeIs('demandeForm')) active @endif">
                    <a href="{{route('demVisitList')}}"><i class="flaticon-calendar"></i>Demandes </a>
                </li>
                @endif
            @endif
        </ul>
        @if (Help::optAutorise(['PSP', 'CLI', 'AFF', 'FAC', 'REG', 'ZZZ'], $us->ID_UTILISATEUR))
        <h4>Exploitation</h4>
        <ul>
            @if (Help::optAutorise(['PSP', 'ZZZ'], $us->ID_UTILISATEUR))
            <li class="@if (request()->routeIs('prospectList')) active @endif">
                <a href="{{route('prospectList')}}"><i class="fa fa-users"></i>Prospect </a>
            </li>
            @endif
            @if (Help::optAutorise(['CLI', 'ZZZ'], $us->ID_UTILISATEUR))
            <li class="@if (request()->routeIs('clientList') || request()->routeIs('clientForm')
                || request()->routeIs('affDetail') || request()->routeIs('affFormCli')) active @endif">
                <a href="{{route('clientList')}}"><i class="flaticon-male"></i>Client </a>
            </li>
            @endif
            @if (Help::optAutorise(['AFF', 'ZZZ'], $us->ID_UTILISATEUR))
            <li class="@if (request()->routeIs('affaireList') || request()->routeIs('affaireForm')) active @endif">
                <a href="{{route('affaireList')}}"><i class="fa fa-briefcase"></i>Propriétés acquises </a>
            </li>
            @endif
            @if (Help::optAutorise(['FAC', 'ZZZ'], $us->ID_UTILISATEUR))
            <li class="@if (request()->routeIs('liaisonList') || request()->routeIs('liaisonForm')) active @endif">
                <a href="{{route('liaisonList')}}"><i class="flaticon-bill"></i>Facturation </a>
            </li>
            @endif
            @if (Help::optAutorise(['REG', 'ZZZ'], $us->ID_UTILISATEUR))
            <li class="@if (request()->routeIs('paiementList') || request()->routeIs('paiemForm')) active @endif">
                <a href="{{route('paiementList')}}"><i class="fa fa-credit-card"></i>Suivis des Paiements </a>
            </li>
            @endif
        </ul>
        @endif
        @if (Help::optAutorise(['PAR', 'ACC', 'ZZZ'], $us->ID_UTILISATEUR))
        <ul>
            <li class="@if (request()->routeIs('entrepriseInfos')) active @endif">
                <a href="{{ route('entrepriseInfos') }}">
                <i class="lnr lnr-apartment"></i>Configurations </a>
            </li>
        </ul>
        @endif
        <ul><li><a href="{{ route('deconnexion') }}"><i class="flaticon-logout"></i>Deconnexion </a></li></ul>
    </div>
</div>
