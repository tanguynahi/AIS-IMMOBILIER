<div class="dashboard-nav">
    <div class="dashboard-inner">
        <h4>MENU</h4>
        <ul>
            <li class="@if (request()->routeIs('tdbc')) active @endif">
                <a href="{{ route('tdbc') }}"><i class="flaticon-dashboard"></i>Tableau de bord </a>
            </li>
            <li class="@if (request()->routeIs('messageListCli') || request()->routeIs('messageDetailCli') 
                || request()->routeIs('messageNouveauCli')) ) active @endif">
                <a href="{{route('messageListCli')}}">
                    <i class="flaticon-mail"></i>Boite de reception
                    <span class="nav-tag">{{ Help::cliNbNonLu($us->ADR_EMAIL) ?? 0 }}</span>
                </a>
            </li>
        </ul>
        <ul>
            <li class="@if (request()->routeIs('demClientList') || request()->routeIs('demCliForm')) active @endif">
                <a href="{{route('demClientList')}}"><i class="flaticon-calendar"></i>Mes Demandes </a>
            </li>
            <li class="@if (request()->routeIs('proprieteGet') || request()->routeIs('affaireCliForm')
                || request()->routeIs('paiementAffList') || request()->routeIs('documentForm')) active @endif">
                <a href="{{route('proprieteGet')}}"><i class="flaticon-empire-state-building"></i>Propriétés Acquis</a>
            </li>
        </ul>
        <ul>
            <li class="@if (request()->routeIs('paiemCliForm') || request()->routeIs('filePaiementList') ||
                request()->routeIs('documentForm') || request()->routeIs('paiemClientList')) active @endif">
                <a href="{{route('paiemClientList')}}">
                    <i class="fa fa-credit-card"></i>Paiements
                </a>
            </li>
            <li class="@if (request()->routeIs('mesInfosCli')) active @endif">
                <a href="{{route('mesInfosCli')}}"><i class="flaticon-male"></i>Mes Informations </a>
            </li>
        </ul>
        <ul>
            <li class="@if (request()->routeIs('nouvPaiement',['id'=>0])) active @endif">
                <a href="{{route('nouvPaiement',['id'=>0])}}"><i class="flaticon-plus"></i>Nouveau Paiement</a>
            </li>
        </ul>
        <ul><li><a href="{{ route('deconnexion') }}"><i class="flaticon-logout"></i>Deconnexion </a></li></ul>
    </div>
</div>
