<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>{{ $titre ?? 'Realestate' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.site.css')
</head>

<body>

    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PTNPV7L" height="0" width="0"
        style="display:none;visibility:hidden"></iframe>
    </noscript>
    <div class="page_loader"></div>

    <div class="coming-soon coming-soon-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="coming-soon-inner">
                        <a href="{{route('home')}}">
                            <img src="{{ asset(Help::$VALID_IMG) }}" alt="logo" style="height: 30%; width: 30%">
                        </a>
                        <h6 style="font-size: 200%" class="text-uppercase">Félicitations <br />
                            Votre compte a été crée avec succès.
                        </h6>
                        <div class="coming-form clearfix">
                            <a href="{{route('home')}}" class="btn btn-theme" type="button">Accueil</a>
                            @if($act>0)
                                <a href="{{route('formdemande',['idPropriete'=>$act])}}" class="btn btn-theme" type="button">
                                Poursuivre</a>
                            @else
                                <a href="#" class="btn btn-theme" type="button">Accedez à mon compte</a>
                            @endif
                        </div>
                        <ul class="social-list clearfix">
                            <li><a href="#" class="facebook"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#" class="twitter"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.site.js')
</body>

</html>
