<!DOCTYPE html>
<html lang="fr">

<head>
    <title>{{ $titre ?? 'Real Estate' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    @include('partials.site.css')
</head>

<body>

    @php $entreprise = Help::Infos() @endphp

    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PTNPV7L" height="0" width="0"
        style="display:none;visibility:hidden"></iframe>
    </noscript>
    <div class="page_loader"></div>

    @include('partials.site.top-header')
    @include('partials.site.headerIndex')
    @include('partials.site.sidebar')

    <div class="banner" id="banner">
        <div id="carouselExampleFade" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @php (int) $n = 0; @endphp
                @foreach($bannieres as $key => $value)
                @php (int) $n++; @endphp
                    <div class="carousel-item banner-max-height item-bg @if($n==1) active @endif">
                        <img class="d-block w-100 h-100" src="{{($value->PATH_BAN ?? 'img/banner/img-1.png')}}" alt="banner">
                    </div>
                @endforeach
                <div class="carousel-caption d-flex h-100">
                    <div class="carousel-content container">
                        <div class="text-center bi-3">
                            <div class="clearfix">
                                <h3>Trouver une Propriété</h3>
                                <p hidden> Nos services : La Construction - rénovation immobilière - Vente de terrain -
                                    Architecture d’intérieur et décoration
                                </p>
                            </div>
                            <div class="clearfix"></div>
                            <form method="post" action="{{route('searchG')}}">
                                @csrf
                                <div class="inline-search-area isa-4 clearfix">
                                    <div class="row">
                                            <div class="col-xl-2 col-lg-2 col-sm-4 col-6 search-col">
                                                <div class="form-group">
                                                    <select class="selectpicker search-fields" name="all_status">
                                                        <option value="0">Tous types</option>
                                                        @foreach ($types as $v)
                                                            <option value="{{$v->ID_TYPE_PROPRIETE}}">{{$v->LIB_TYPE}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-2 col-sm-4 col-6 search-col">
                                                <div class="form-group">
                                                    <select class="selectpicker search-fields" name="all_categories">
                                                        <option value="0">Toutes categories</option>
                                                        @foreach ($categories as $v)
                                                            <option value="{{ $v->ID_CATEGORIES ?? 0}}">
                                                                {{ $v->LIB_CATEGORIE }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-2 col-sm-4 col-6 search-col">
                                                <div class="form-group">
                                                    <select class="selectpicker search-fields" name="nb_pieces">
                                                        <option value="0">Toutes pièces</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                        <option>6</option>
                                                        <option>7</option>
                                                        <option>8</option>
                                                        <option>9</option>
                                                        <option>10</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-2 col-sm-4 col-6 search-col">
                                                <div class="form-group">
                                                    <select class="selectpicker search-fields" name="annee_const">
                                                        <option value="0">Toutes les années </option>
                                                        @foreach ($annees as $v)
                                                            <option value="{{$v->ANNEE_CONST_ID}}">{{$v->LIB_ANNEE_CONST}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-2 col-sm-4 col-6 search-col">
                                                <div class="form-group">
                                                    <select class="selectpicker search-fields" name="city">
                                                        <option value="0">Toutes les villes</option>
                                                        @foreach ($villes as $v)
                                                            <option value="{{ $v->ID_VILLE ?? 0}}">
                                                                {{ $v->LIB_VILLE }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-2 col-sm-4 col-6 search-col">
                                                <button class="btn button-theme btn-search w-100" type="submit">
                                                    <strong>Rechercher</strong>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </form>

                            <form method="post" action="{{route('searchG')}}">
                                @csrf
                                <div class="inline-search-area isa-3 clearfix">
                                    <div class="row clearfix">
                                            <div class="col-md-6 col-sm-6 col-6">
                                                <div class="form-group">
                                                    <select class="selectpicker search-fields" name="all_status">
                                                        <option value="0">Tous types</option>
                                                        @foreach ($types as $v)
                                                            <option value="{{$v->ID_TYPE_PROPRIETE}}">{{$v->LIB_TYPE}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-6">
                                                <div class="form-group">
                                                    <select class="selectpicker search-fields" name="all_categories">
                                                        <option value="0">Toutes categories</option>
                                                        @foreach ($categories as $v)
                                                            <option value="{{ $v->ID_CATEGORIES ?? 0}}">
                                                                {{ $v->LIB_CATEGORIE }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-6">
                                                <div class="form-group">
                                                    <select class="selectpicker search-fields" name="nb_pieces">
                                                        <option value="0">Toutes pièces</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                        <option>6</option>
                                                        <option>7</option>
                                                        <option>8</option>
                                                        <option>9</option>
                                                        <option>10</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-6">
                                                <div class="form-group">
                                                    <select class="selectpicker search-fields" name="annee_const">
                                                        <option value="0">Toutes les années </option>
                                                        @foreach ($annees as $v)
                                                            <option value="{{$v->ANNEE_CONST_ID}}">{{$v->LIB_ANNEE_CONST}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-6">
                                                <div class="form-group">
                                                    <select class="selectpicker search-fields" name="city">
                                                        <option value="0">Toutes les villes</option>
                                                        @foreach ($villes as $v)
                                                            <option value="{{ $v->ID_VILLE ?? 0}}">
                                                                {{ $v->LIB_VILLE }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-6">
                                                <button class="btn button-theme btn-search w-100" type="submit">
                                                    <strong>Rechercher</strong>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <style>
           .promo-badge {
                display: inline-block;
                padding: 15px 25px;
                background-color: #ff5733;
                color: #fff;
                font-weight: bold;
                font-size: 1rem;
                border-radius: 50px;
                box-shadow: 0px 5px 15px rgba(255, 87, 51, 0.4);
                position: relative;
                overflow: hidden;
                cursor: pointer;
                animation: bounceAnimation 2s infinite;
            }

            .promo-badge:before {
                position: absolute;
                top: -10px;
                right: -10px;
                background-color: #ffc107;
                color: #000;
                padding: 5px 10px;
                font-size: 0.8rem;
                font-weight: bold;
                border-radius: 50%;
                animation: pulseAnimation 1.5s infinite;
            }

            .promo-badge:hover {
                background-color: #e14e2a;
                box-shadow: 0px 8px 20px rgba(225, 78, 42, 0.6);
            }

            @keyframes bounceAnimation {

                0%,
                100% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.05);
                }
            }

            @keyframes pulseAnimation {

                0%,
                100% {
                    transform: scale(1);
                    opacity: 1;
                }

                50% {
                    transform: scale(1.2);
                    opacity: 0.8;
                }
            }
    </style>
    @if (count($proprietes) > 0)
    <div class="featured-properties content-area-16 bg-grea-3 slide-box-2">
         <div class="row mbt-2">

            <div class="col-12 col-lg-12 col-sm-12 col-md-12  ">
                       <span class="promo-badge text-uppercase  text-center">
                           Avec BMI-WFS, sécurisez votre investissement immobilier en toute sérénité — nous vous accompagnons à
                           chaque étape pour garantir votre succès.
                       </span>
                   </div>
        </div>
        <div class="container">
            <div class="main-title-4">
                <h2 data-title="Propriétés Chic">Nos Propriétés</h2>
            </div>
        </div>
        <div class="container">
            <div class="row">
                @foreach ($proprietes as $key => $p)
                <div class="col-lg-4 col-md-6 col-sm-12 filtr-item" data-category="{{ $p->ID_CATEGORIES ?? 0 }}">
                    <a href="{{ route('detailP',['idPropriete'=>$p->ID_PROPRIETES]) }}">
                        <div class="property-box-4">
                            <div class="property-photo">
                                <img class="img-fluid w-100"
                                src="{{ asset($p->IMG_DEFAULT ?? 'assets/img/properties/properties-1.png') }}"
                                alt="{{ $p->LIB_PROPRIETE ?? 'designation' }}">
                                <div class="tag">{{ $p->LIB_TYPE ?? 'vente/location' }}</div>
                                @if ($p->EN_PROMOTION == true)
                                    <div class="listing-badges">
                                        <span class="featured">
                                            {{ Help::strCut($p->LIB_TYPE ?? 'type', 0, 5, '.') }}
                                            (-{{ $p->POURCENT_PROMO ?? '0.0' }}%)
                                        </span>
                                    </div>
                                    <div class="plan-price">
                                        <span style="font-size: 130%">
                                        {{ Help::formatNombre($p->PRIX_PROMO ?? '0', true) }}</span>
                                        <s style="color: black">{{ Help::formatNombre($p->PRIX_HT ?? '0', true) }}</s>
                                    </div>
                                @else
                                    <div class="plan-price">
                                        <span style="font-size: 130%;">
                                        {{ Help::formatNombre($p->PRIX_HT ?? '0', true) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="detail">
                                <div class="heading">
                                    <h3>
                                        <a href="{{ route('detailP',['idPropriete'=>$p->ID_PROPRIETES]) }}"
                                            title="{{ $p->LIB_PROPRIETE ?? 'designation' }} | {{ $p->LIB_CATEGORIE ?? 'Categ' }}">
                                            @php $libel = $p->LIB_PROPRIETE ?? 'designation' .'|'. $p->LIB_CATEGORIE ?? 'Categ' @endphp
                                            {{ Help::strCut($libel ?? 'designation', 0, 30, '...') }}
                                        </a>
                                    </h3>
                                    <div class="location">
                                        <a href="{{ route('detailP',['idPropriete'=>$p->ID_PROPRIETES]) }}">
                                            <i class="fa fa-map-marker"></i>{{ $p->ADRESSE ?? 'Adresse' }}
                                        </a>
                                    </div>
                                </div>
                                <div class="properties-listing clearfix">
                                    <ul class="facilities-list clearfix">
                                        <li><i class="flaticon-area"></i>&nbsp;{{ $p->SUPERFICIE ?? 'xxx' }} m² </li>
                                        <li @if ($p->ID_TYPE!==1) hidden @endif><i class="flaticon-bed"></i> {{ $p->NB_CHAMBRES ?? 'x' }}&nbsp;<span>Chambre(s)</span></li>
                                        <li @if ($p->ID_TYPE!==1) hidden @endif><i class="flaticon-bathroom"></i> {{ $p->NB_SALLE_DE_BAIN ?? 'x' }}&nbsp;<span>Salle(s) bain</span> </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    @if (count($categories) > 0)
        <div class="services content-area bg-grea-3" hidden>
            <div class="container">
                <div class="main-title-5 ">
                    <h1>Que <span>recherchez-vous ?</span></h1>
                    <div class="title-border mb-4">
                        <div class="title-border-inner"></div>
                        <div class="title-border-inner"></div>
                        <div class="title-border-inner"></div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($categories as $key => $value)
                        <div class="col-lg-4 col-md-6">
                            <div class="service-info-4">
                                {!! $value->ICONS_CATEGORIE ?? '' !!}
                                <h3>{{ $value->LIB_CATEGORIE ?? 'titre' }}</h3>
                                <p>{{ $value->DESCRIPTION_CATEGORIE ?? 'description' }}</p>
                                <a href="{{route('listByCategories',['type'=>0,'idCategories'=>$value->ID_CATEGORIES, 'act'=>'ls'])}}"
                                    class="read-more">Acceder
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if(count($envedettes)>0)
        <div class="popular-places-section content-area-3">
            <div class="container">
                <div class="main-title-5">
                    <h1>Classement Par <span>Categorie</span></h1>
                    <div class="title-border">
                        <div class="title-border-inner"></div>
                        <div class="title-border-inner"></div>
                        <div class="title-border-inner"></div>
                    </div>
                </div>
                <div class="row">
                    @if(count($envedettes)==5)
                        @php (int) $n = 0; @endphp
                        <div class="col-lg-7 col-md-12 col-sm-12">
                            <div class="row">
                                @foreach($envedettes as $key => $env)
                                    @php $n++; @endphp
                                    @if($n<5)
                                        <div class="col-sm-6">
                                            <div class="popular-places">
                                                <div class="popular-places-inner">
                                                    <div class="popular-places-overflow">
                                                        <div class="popular-places-photo">
                                                            <img class="img-fluid w-100"
                                                            src="{{ asset($env->PATH_CATEGORIE ?? 'assets/img/popular-places/popular-places-3.png') }}">
                                                        </div>
                                                        <div class="info">
                                                            <h3>
                                                                <a href="{{route('listByCategories',['type'=>0, 'idCategories'=>$env->ID_CATEGORIES, 'act'=>'ls'])}}">
                                                                {{$env->LIB_CATEGORIE ?? 'libelle'}}</a>
                                                            </h3>
                                                            <p>{{$env->Nb ?? 'x'}} Propriété(s)</p>
                                                        </div>
                                                        @if(strlen($env->Nb)<2)
                                                            <div class="new">0{{$env->Nb ?? 'New'}}</div>
                                                        @else
                                                            <div class="new">{{$env->Nb ?? 'New'}}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-12 col-sm-12">
                            <div class="popular-places">
                                <div class="popular-places-inner">
                                    <div class="popular-places-overflow">
                                        <div class="popular-places-photo">
                                            <div class="popular-places-photodd">
                                                <img class="img-fluid big-img w-100"
                                                    src="{{ asset($envedettes[4]->PATH_CATEGORIE ?? 'assets/img/popular-places/popular-places-6.png') }}">
                                            </div>
                                        </div>
                                        <div class="info">
                                            <h3>
                                                <a href="{{route('listByCategories',['type'=>0, 'idCategories'=>$envedettes[4]->ID_CATEGORIES, 'act'=>'ls'])}}">
                                                {{$envedettes[4]->LIB_CATEGORIE ?? 'libelle'}}</a>
                                            </h3>
                                            <p>{{$envedettes[4]->Nb ?? 'x'}} Propriété(s)</p>
                                        </div>
                                        @if(strlen($env->nb)<2)
                                            <div class="new">0{{$envedettes[4]->Nb ?? 'New'}}</div>
                                        @else
                                            <div class="new">{{$envedettes[4]->Nb ?? 'New'}}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="row">
                                @foreach($envedettes as $key => $env)
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="popular-places">
                                            <div class="popular-places-inner">
                                                <div class="popular-places-overflow">
                                                    <div class="popular-places-photo">
                                                        <img class="img-fluid w-100"
                                                        src="{{ asset($env->PATH_CATEGORIE ?? 'assets/img/popular-places/popular-places-3.png') }}">
                                                    </div>
                                                    <div class="info">
                                                        <h3>
                                                            <a href="{{route('listByCategories',['type'=>0, 'idCategories'=>$env->ID_CATEGORIES, 'act'=>'ls'])}}">
                                                            {{$env->LIB_CATEGORIE ?? 'libelle'}}</a>
                                                        </h3>
                                                        <p>{{$env->Nb ?? 'x'}} Propriété(s)</p>
                                                    </div>
                                                    @if(strlen($env->Nb)<2)
                                                        <div class="new">0{{$env->Nb ?? 'New'}}</div>
                                                    @else
                                                        <div class="new">{{$env->Nb ?? 'New'}}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    @include('partials.site.counters', ['types'=>$counters, 'agents'=>$agents])

    @include('partials.site.footer')
    @include('partials.site.js')
</body>

</html>
