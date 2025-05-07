<!DOCTYPE html>
<html lang="fr">

<head>
    <title>{{ $titre ?? 'Real Estate' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.site.css')
</head>

<body>

    @php $entreprise = Help::Infos() @endphp
    
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PTNPV7L" height="0" width="0"
        style="display:none;visibility:hidden"></iframe>
    </noscript>
    <div class="page_loader"></div>

    @include('partials.site.header')
    @include('partials.site.sidebar')

    @yield('content')

    @include('partials.site.footer')
    @include('partials.site.js')

    @yield('js')
</body>

</html>
