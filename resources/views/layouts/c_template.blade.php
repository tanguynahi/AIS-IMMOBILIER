<!DOCTYPE html>
<html lang="fr">

<head>
    <title>{{ $titre ?? 'Administration | Realestate' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.site.css')

    @yield('css')
</head>

<body>
    
    @php $entreprise = Help::Infos() @endphp

    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PTNPV7L"
        height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <div class="page_loader"></div>

    @include('partials.client.tdbclientheader')
    @include('partials.client.sidebarclient')

    <div class="dashboard d-flex">
        <div class="container-fluid">
            <div class="row">
                @include('partials.client.tdbclient-nav')
                <div class="dashboard-content">
                    @yield('content')
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="sub-banner-2 text-center">© 2024 WFS-CI.
                            Les marques déposées et marques sont la propriété de leurs propriétaires respectifs.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="full-page-search">
        <button type="button" class="close">×</button>
        <form action="#">
            <input type="search" value="" placeholder="type keyword(s) here" />
            <button type="submit" class="btn btn-sm button-theme">Search</button>
        </form>
    </div>

    @include('partials.site.js')

    @yield('js')

</body>

</html>
