@extends('layouts.s_template', ['titre' => $titre])

@push('css')
    <script src="{{ asset('vendor/js/layout.js') }}"></script>
    <link href="{{ asset('vendor/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.mCustomScrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dropzone.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
@endpush

@section('content')
    @include('partials.site.sub-banner', ['element' => 'Detail Propriété'])
    <div class="properties-details-page">
        <br />
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <button type="button" class="btn-6" onclick="demVisite({{ $proprietes->ID_PROPRIETES }});">
                        Faire une demander</button>
                    <div class="heading-properties-3">
                        <div class="clearfix">
                            <br />
                            <div class="pull-left">
                                <h1>{{ $proprietes->LIB_PROPRIETE ?? 'designation' }}</h1>
                            </div>
                            <div class="pull-right">
                                @if ($proprietes->EN_PROMOTION == true)
                                    <h1>
                                        <s style="color: #8888; font-size: 70%">
                                            {{ Help::formatNombre($proprietes->PRIX_HT ?? '0', true) }}</s>
                                        <b style="font-size: 70%">(-{{ $proprietes->POURCENT_PROMO ?? '0.0' }}%)</b>&nbsp;
                                        <span>{{ Help::formatNombre($proprietes->PRIX_PROMO ?? '0', true) }}</span>
                                    </h1>
                                @else
                                    <h1><span>{{ Help::formatNombre($proprietes->PRIX_HT ?? '0', true) }}</span></h1>
                                @endif
                            </div>
                        </div>
                        <div class="clearfix">
                            <div class="pull-left">
                                <p><i class="flaticon-pin"></i> {{ $proprietes->ADRESSE ?? 'adresse' }}</p>
                            </div>
                            <div class="pull-right">
                                <p><span>{{ $proprietes->SUPERFICIE ?? 'superficie' }} m²</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="product-slider-box cds-2 clearfix mb-40">
                        <style>
                            .prod-imag img {
                                width: 550px;
                                height: 520px;
                                object-fit: cover;
                                display: block;
                                border-radius: 5px;
                            }

                            .voire-imag img {
                                width: 50px;
                                height: 150px;
                                object-fit: cover;
                                display: block;
                                border-radius: 5px;
                            }
                        </style>

                        <div class="product-img-slide ">
                            <div class="slider-for prod-imag">
                                <img src="{{ asset($proprietes->IMG_DEFAULT ?? 'assets/img/properties/properties-1.png') }}"
                                    class="img-fluid w-100" alt="slider-photo">
                                @foreach ($files as $key => $value)
                                    <div class="col-lg-4 col-md-6 col-sm-6 filtr-item " data-category="2">
                                        <img src="{{ $value->PATH_IMAGES ?? 'assets/img/properties/properties-2.png' }}"
                                            class="img-fluid w-100">
                                    </div>
                                @endforeach
                            </div>

                            <div class="slider-nav">
                                <div class="thumb-slide ">
                                    <img
                                        src="{{ asset($proprietes->IMG_DEFAULT ?? 'assets/img/properties/properties-1.png') }}">
                                </div>
                                @foreach ($files as $key => $value)
                                    <div class="col-lg-4 col-md-6 col-sm-6 filtr-item voire-imag" data-category="2">
                                        <img src="{{ $value->PATH_IMAGES ?? 'assets/img/properties/properties-2.png' }}"
                                            class="thumb-slide">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="properties-description mb-40">
                        <h3 class="heading-2">Description </h3>
                        <p>{{ $proprietes->DESCRIPTIF ?? 'description' }}</p>
                    </div>

                    @if ($proprietes->ID_TYPE == 1)
                        @if (isset($proprietes->WIFI) ||
                                isset($proprietes->PISCINE) ||
                                isset($proprietes->CUSINE_EQUIPE) ||
                                isset($proprietes->CLIMATISATION) ||
                                isset($proprietes->PARKING) ||
                                isset($proprietes->SECURITE) ||
                                isset($proprietes->SALLE_DE_SPORT))
                            <div class="properties-amenities mb-40">
                                <h3 class="heading-2">Caratéristiques </h3>
                                <div class="row">
                                    @if (
                                        (isset($proprietes->WIFI) && $proprietes->WIFI > 0) ||
                                            (isset($proprietes->PISCINE) && $proprietes->PISCINE > 0) ||
                                            (isset($proprietes->CUSINE_EQUIPE) && $proprietes->CUSINE_EQUIPE > 0))
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                            <ul class="amenities">
                                                @if (isset($proprietes->WIFI) && $proprietes->WIFI > 0)
                                                    <li><i class="fa fa-check"></i>WIFI </li>
                                                @endif
                                                @if (isset($proprietes->PISCINE) && $proprietes->PISCINE > 0)
                                                    <li><i class="fa fa-check"></i>PISCINE </li>
                                                @endif
                                                @if (isset($proprietes->CUSINE_EQUIPE) && $proprietes->CUSINE_EQUIPE > 0)
                                                    <li><i class="fa fa-check"></i>CUSINE EQUIPEE </li>
                                                @endif
                                            </ul>
                                        </div>
                                    @endif
                                    @if (
                                        (isset($proprietes->CLIMATISATION) && $proprietes->CLIMATISATION > 0) ||
                                            (isset($proprietes->PARKING) && $proprietes->PARKING > 0) ||
                                            (isset($proprietes->SECURITE) && $proprietes->SECURITE > 0))
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                            <ul class="amenities">
                                                @if (isset($proprietes->CLIMATISATION) && $proprietes->CLIMATISATION > 0)
                                                    <li><i class="fa fa-check"></i>CLIMATISATION </li>
                                                @endif
                                                @if (isset($proprietes->PARKING) && $proprietes->PARKING > 0)
                                                    <li><i class="fa fa-check"></i>PARKING </li>
                                                @endif
                                                @if (isset($proprietes->SECURITE) && $proprietes->SECURITE > 0)
                                                    <li><i class="fa fa-check"></i>SECURITE </li>
                                                @endif
                                            </ul>
                                        </div>
                                    @endif
                                    @if (isset($proprietes->SALLE_DE_SPORT) && $proprietes->SALLE_DE_SPORT > 0)
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                            <ul class="amenities">
                                                <li><i class="fa fa-check"></i>SALLE DE SPORT </li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endif

                    <div class="floor-plans mb-50">
                        <h3 class="heading-2">Plans</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td><strong>Superficie</strong></td>
                                        <td @if ($proprietes->ID_TYPE !== 1) hidden @endif><strong>Pieces</strong></td>
                                        <td @if ($proprietes->ID_TYPE !== 1) hidden @endif><strong>Chambres</strong></td>
                                        <td @if ($proprietes->ID_TYPE !== 1) hidden @endif><strong>Salles de bain</strong>
                                        </td>
                                        <td @if ($proprietes->ID_TYPE !== 1) hidden @endif><strong>Garage</strong></td>
                                        <td @if ($proprietes->ID_TYPE !== 1) hidden @endif><strong>Année</strong></td>
                                    </tr>
                                    <tr>
                                        <td>{{ $proprietes->SUPERFICIE ?? 'x' }} m²</td>
                                        <td @if ($proprietes->ID_TYPE !== 1) hidden @endif>
                                            {{ $proprietes->NB_PIECES ?? 'x' }}</td>
                                        <td @if ($proprietes->ID_TYPE !== 1) hidden @endif>
                                            {{ $proprietes->NB_CHAMBRES ?? 'x' }}</td>
                                        <td @if ($proprietes->ID_TYPE !== 1) hidden @endif>
                                            {{ $proprietes->NB_SALLE_DE_BAIN ?? 'x' }}</td>
                                        <td @if ($proprietes->ID_TYPE !== 1) hidden @endif>
                                            {{ $proprietes->NB_GARAGE ?? 'x' }}</td>
                                        <td @if ($proprietes->ID_TYPE !== 1) hidden @endif>
                                            {{ $proprietes->ANNEE ?? 'DD/MM/YYYY' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @if (count($plan) > 0)
                            <style>
                                .product-image img {
                                    width: 200px;
                                    height: 200px;
                                    border-radius: 5px;
                                }
                            </style>
                            @foreach ($plan as $key => $value)
                                {{-- <img src="{{($value->PATH_PLAN ?? 'assets/img/floor-plans.png')}}" class="img-fluid w-100"" > --}}
                                <a href="{{ $value->PATH_PLAN }}" target="_target" class="product-image">
                                    <img src="{{ $value->PATH_PLAN ?? 'assets/img/floor-plans.png' }}" class="img-fluid">

                                </a>
                            @endforeach
                        @endif
                    </div>

                    <div class="location mb-50">
                        <input class="form-control" value="5.489826708970218" id="lat" readonly hidden>
                        <input class="form-control" value="-4.053024291992191" id="long" readonly hidden>
                        <div class="map">
                            <h3 class="heading-2">Localisation </h3>
                            <div class="map-content">
                                <div id="singleMap" class="contact-map"
                                    data-latitude="{{ $proprietes->LATITUDE ?? '5.489826708970218' }}"
                                    data-longitude="{{ $proprietes->LONGITUDE ?? '-4.053024291992191' }}"></div>
                            </div>
                        </div>
                    </div>

                    @if (isset($proprietes->URL_VIDEO) && $proprietes->URL_VIDEO != '')
                        <div class="inside-properties mb-50">
                            <h3 class="heading-2">Video </h3>
                            <iframe src="{{ $proprietes->URL_VIDEO ?? 'https://www.youtube.com/embed/5e0LxrLSzok' }}"
                                allowfullscreen=""></iframe>
                        </div>
                    @endif

                </div>

                <div class="col-lg-4 col-md-12">
                    <div class="sidebar-right">

                        <div class="widget advanced-search">
                            <h3 class="sidebar-title">Recherche Avancée</h3>
                            <div class="s-border"></div>
                            <div class="m-border"></div>
                            <form method="post" action="#">
                                @csrf
                                <div class="form-group">
                                    <label>Types </label>
                                    <select class="selectpicker search-fields" id="all_status">
                                        <option value="0">Tous..</option>
                                        @foreach ($types as $v)
                                            <option value="{{ $v->ID_TYPE_PROPRIETE }}">{{ $v->LIB_TYPE }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Categories </label>
                                    <select class="selectpicker search-fields" id="all_categories">
                                        <option value="0">Tous..</option>
                                        @foreach ($categories as $v)
                                            <option value="{{ $v->ID_CATEGORIES }}">{{ $v->LIB_CATEGORIE }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" hidden>
                                    <label>Pays </label>
                                    <select class="form-control" id="IDPays">
                                        <option value="0" selected disabled>Choisir pays..</option>
                                        @foreach ($pays as $p)
                                            <option value="{{ $p->ID_PAYS }}"
                                                @if ($idPays == $p->ID_PAYS) selected @endif>
                                                {{ $p->LIB_PAYS }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Ville </label>
                                    <select class="selectpicker search-fields" id="IDVille">
                                        <option value="0">Toutes..</option>
                                        @foreach ($villes as $v)
                                            <option value="{{ $v->ID_VILLE }}">
                                                {{ $v->LIB_VILLE }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Pièce </label>
                                            <select class="selectpicker search-fields" id="nb_pieces">
                                                <option value="0">Toutes..</option>
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
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Année </label>
                                            <select class="selectpicker search-fields" id="annee_const">
                                                <option value="0">Toutes..</option>
                                                @foreach ($annee as $v)
                                                    <option value="{{ $v->ANNEE_CONST_ID }}">{{ $v->LIB_ANNEE_CONST }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="range-slider clearfix form-group">
                                    <label>Superficie</label>
                                    <div data-min="0" data-max="10000" data-min-name="min_area"
                                        data-max-name="max_area" data-unit="m²" class="range-slider-ui ui-slider"
                                        aria-disabled="false">
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="range-slider clearfix form-group mb-30">
                                    <label>Prix</label>
                                    <div data-min="0" data-max="150000" data-min-name="min_price"
                                        data-max-name="max_price" data-unit="XOF" class="range-slider-ui ui-slider"
                                        aria-disabled="false">
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="accordion accordion-flush other-features mb-30" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                                aria-expanded="false" aria-controls="flush-collapseOne">
                                                Autres Filtres
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                                            aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <h3 class="sidebar-title">Filtres</h3>
                                                <div class="s-border"></div>
                                                <div class="m-border"></div>
                                                <div class="checkbox checkbox-theme checkbox-circle">
                                                    <input type="checkbox" id="checkbox1" name="wifi">
                                                    <label for="checkbox1">WIFI </label>
                                                </div>
                                                <div class="checkbox checkbox-theme checkbox-circle">
                                                    <input type="checkbox" id="checkbox2" name="piscine">
                                                    <label for="checkbox2">PISCINE </label>
                                                </div>
                                                <div class="checkbox checkbox-theme checkbox-circle">
                                                    <input type="checkbox" id="checkbox3" name="cuisine_equip">
                                                    <label for="checkbox3">CUSINE EQUIPE </label>
                                                </div>
                                                <div class="checkbox checkbox-theme checkbox-circle">
                                                    <input type="checkbox" id="checkbox4" name="climatisation">
                                                    <label for="checkbox4">CLIMATISATION </label>
                                                </div>
                                                <div class="checkbox checkbox-theme checkbox-circle">
                                                    <input type="checkbox" id="checkbox5" name="parking">
                                                    <label for="checkbox5">PARKING </label>
                                                </div>
                                                <div class="checkbox checkbox-theme checkbox-circle">
                                                    <input type="checkbox" id="checkbox6" name="securite">
                                                    <label for="checkbox6">SECURITE </label>
                                                </div>
                                                <div class="checkbox checkbox-theme checkbox-circle">
                                                    <input type="checkbox" id="checkbox7" name="salle_sport">
                                                    <label for="checkbox7">SALLE DE SPORT </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <button class="search-button" type="button" onclick="search();">
                                        Recherche </button>
                                </div>
                            </form>
                            <div class="alert alert-2 alert-warning alert-dismissible fade show" role="alert"
                                id="sv-mess" style="display: none;">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>

                        @if (count($recent) > 0)
                            <div class="widget recent-properties">
                                <h3 class="sidebar-title">Propriétés Recentes</h3>
                                <div class="s-border"></div>
                                <div class="m-border"></div>
                                @foreach ($recent as $key => $p)
                                    <div class="d-flex mb-3 recent-posts-box">
                                        <a class="pr-3"
                                            href="{{ route('detailP', ['idPropriete' => $p->ID_PROPRIETES]) }}">
                                            <img src="{{ $p->IMG_DEFAULT ?? 'assets/img/properties/small-properties-1.png' }}"
                                                class="flex-shrink-0 me-3">
                                        </a>
                                        <div class="detail align-self-center">
                                            <h5>
                                                <a href="{{ route('detailP', ['idPropriete' => $p->ID_PROPRIETES]) }}">
                                                    {{ $p->LIB_PROPRIETE ?? 'designation' }}</a>
                                            </h5>
                                            <div class="listing-post-meta">
                                                @if ($p->EN_PROMOTION == true)
                                                    <s style="color: #8888; font-size: 80%">
                                                        {{ Help::formatNombre($p->PRIX_HT ?? '0', true) }}</s>
                                                    <b
                                                        style="font-size: 80%">(-{{ $p->POURCENT_PROMO ?? '0.0' }}%)</b>&nbsp;
                                                    <span>{{ Help::formatNombre($p->PRIX_PROMO ?? '0', true) }}</span>
                                                    <br />
                                                @else
                                                    {{ Help::formatNombre($p->PRIX_HT ?? '0', true) }}
                                                @endif
                                                @if ($p->ID_TYPE == 1)
                                                    | <i class="fa fa-calendar"></i> {{ $p->ANNEE ?? 'année' }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="widget social-links">
                            <h3 class="sidebar-title">Liens réseau</h3>
                            <div class="s-border"></div>
                            <div class="m-border"></div>
                            <ul class="social-list clearfix">
                                <li><a href="#" class="facebook-bg"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#" class="twitter-bg"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#" class="linkedin-bg"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                        <div class="widget social-links">
                            <button type="button" class="btn-6"
                                onclick="demVisite({{ $proprietes->ID_PROPRIETES }});">
                                Faire une demander</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12">
                    @if (count($similar) > 0)
                        <h3 class="heading-2">Propriétés Similaires </h3>
                        <div class="row similar-properties">
                            @foreach ($similar as $key => $p)
                                <div class="col-md-4">
                                    <div class="property-box">
                                        <div class="property-photo">
                                            <a href="{{ route('detailP', ['idPropriete' => $p->ID_PROPRIETES]) }}"
                                                class="property-img">
                                                @if ($p->EN_PROMOTION == true)
                                                    <div class="listing-badges">
                                                        <span class="featured">
                                                            {{ Help::strCut($p->LIB_TYPE ?? 'type', 0, 5, '.') }}
                                                            (-{{ $p->POURCENT_PROMO ?? '0.0' }}%)
                                                        </span>
                                                    </div>
                                                    <div class="price-box">
                                                        <span style="font-size: 130%">
                                                            {{ Help::formatNombre($p->PRIX_PROMO ?? '0', true) }}</span>
                                                        <s style="color: black">
                                                            {{ Help::formatNombre($p->PRIX_HT ?? '0', true) }}</s>
                                                    </div>
                                                @else
                                                    <div class="price-box">
                                                        <span style="font-size: 130%">
                                                            {{ Help::formatNombre($p->PRIX_HT ?? '0', true) }}</span>
                                                    </div>
                                                    <div class="tag">{{ $p->LIB_TYPE ?? 'vente/location' }}</div>
                                                @endif
                                                <img class="d-block w-100"
                                                    src="{{ asset($p->IMG_DEFAULT ?? 'assets/img/properties/properties-1.png') }}">
                                            </a>
                                        </div>
                                        <div class="detail">
                                            <h1 class="title">
                                                <a href="{{ route('detailP', ['idPropriete' => $p->ID_PROPRIETES]) }}">
                                                    {{ $p->LIB_PROPRIETE ?? 'designation' }} |
                                                    {{ $p->LIB_CATEGORIE ?? 'Categ' }}
                                                </a>
                                            </h1>
                                            <div class="location">
                                                <a href="{{ route('detailP', ['idPropriete' => $p->ID_PROPRIETES]) }}">
                                                    <i class="flaticon-pin"></i>{{ $p->ADRESSE ?? 'Adresse' }}
                                                </a>
                                            </div>
                                        </div>
                                        <ul class="facilities-list clearfix">
                                            <li><span>Superficie</span>{{ $p->SUPERFICIE ?? 'xxx' }} m² </li>
                                            <li @if ($proprietes->ID_TYPE !== 1) hidden @endif><span>Pièce(s)</span>
                                                {{ $p->NB_PIECES ?? 'x' }} </li>
                                            <li @if ($proprietes->ID_TYPE !== 1) hidden @endif><span>Chambre(s)</span>
                                                {{ $p->NB_CHAMBRES ?? 'x' }} </li>
                                            <li @if ($proprietes->ID_TYPE !== 1) hidden @endif><span>Année</span>
                                                {{ $p->ANNEE ?? 'yyyy' }} </li>
                                        </ul>
                                        <div class="footer">
                                            {{ Help::strCut($p->DESCRIPTIF ?? 'description', 0, 95, '...') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ Help::$API_KEY_HERE ?? 'API_KEY_HERE' }}&libraries=places">
    </script>
    <script src="{{ asset('site/js/map-add.js') }}"></script>
    <script src="{{ asset('site/js/dashboard.js') }}"></script>

    <script>
        $("#IDPays").on('change', function() {
            var id = $("#IDPays").val();
            var url = "{{ route('donneVilleList', ['IDPays' => ':IDPays']) }}";
            url = url.replace(":IDPays", id);
            $.ajax({
                type: "get",
                url: url,
                contentType: "application/json",
                success: function(data) {
                    console.log(data);
                    $('#IDVille').empty();
                    var valeur = `<option value="" selected disabled>Choisir ville..</option>`;
                    if (data.length > 0) {
                        valeur = `<option value="0">Tous</option>`;
                        data.forEach((d) => {
                            valeur +=
                                ` <option value="${ d.ID_VILLE }">${ d.LIB_VILLE }</option>`;
                        });
                    }
                    $('#IDVille').append(valeur);
                },
                error: function(data) {
                    console.log(data);
                    $("#output").text('Erreur interne du serveur !');
                }
            });
        });

        function demVisite(params) {
            var rout = "{{ route('formdemande', ['idPropriete' => ':idPropriete']) }}";
            rout = rout.replace(':idPropriete', params);
            window.open(rout, '_self');
        }

        function search() {
            var ajaxmess = $('#sv-mess');
            ajaxmess.text("");
            var rout = "{{ route('searchS') }}";
            var actF = "dksj";
            var typP = document.getElementById("all_status").value;
            var cate = document.getElementById("all_categories").value;
            var pays = document.getElementById("IDPays").value;
            var vill = document.getElementById("IDVille").value;
            var nbpi = document.getElementById("nb_pieces").value;
            var anne = document.getElementById("annee_const").value;
            var mina = document.getElementById("min_areaID").value;
            var maxa = document.getElementById("max_areaID").value;
            var minp = document.getElementById("min_priceID").value;
            var maxp = document.getElementById("max_priceID").value;
            var wifi = document.getElementById("checkbox1").checked;
            var pisc = document.getElementById("checkbox2").checked;
            var cuis = document.getElementById("checkbox3").checked;
            var clim = document.getElementById("checkbox4").checked;
            var park = document.getElementById("checkbox5").checked;
            var secu = document.getElementById("checkbox6").checked;
            var sall = document.getElementById("checkbox7").checked;
            var csrf = document.querySelector('meta[name="csrf-token"]').content;
            var csrf_field = '<input type="hidden" name="_token" value=“' + csrf + '”>';
            $('form').append(csrf_field);
            $.ajaxSetup({
                beforeSend: function(xhr, settings) {
                    if (settings.url.indexOf(document.domain) >= 0) {
                        xhr.setRequestHeader("X-CSRF-Token", csrf);
                    }
                }
            });
            $.ajax({
                type: 'post',
                url: rout,
                _token: csrf,
                data: {
                    act: actF,
                    all_status: typP,
                    all_categories: cate,
                    pays: pays,
                    city: vill,
                    nb_pieces: nbpi,
                    annee_const: anne,
                    min_area: mina,
                    max_area: maxa,
                    min_price: minp,
                    max_price: maxp,
                    wifi: wifi,
                    piscine: pisc,
                    cuisine_equi: cuis,
                    clim: clim,
                    parking: park,
                    securite: secu,
                    salle_sport: sall,
                },
                success: function(data) {
                    console.log(data);
                    if (data.code != '200') {
                        $("#sv-mess").show();
                        var valeur = `
                        <div class="alert alert-2 alert-warning alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            ${data.mess}
                        </div>`;
                        $("#sv-mess").append(valeur);
                    } else {
                        var rout = "{{ route('searchP') }}";
                        window.open(rout, '_self');
                    }
                },
                error: function(err) {
                    console.log(err);
                    $("#sv-mess").show();
                    var valeur = `
                    <div class="alert alert-2 alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        Erreur interne du serveur !!!
                    </div>`;
                    $("#sv-mess").append(valeur);
                }
            });

        }
        $(".range-slider-ui").each(function() {
            var minRangeValue = $(this).attr('data-min');
            var maxRangeValue = $(this).attr('data-max');
            var minName = $(this).attr('data-min-name');
            var maxName = $(this).attr('data-max-name');
            var unit = $(this).attr('data-unit');
            $(this).append("" +
                "<span class='min-value'></span> " +
                "<span class='max-value'></span>" +
                "<input class='current-min' style='display: none;' name='" + minName + "' id='" + minName +
                "ID'>" +
                "<input class='current-max' style='display: none;' name='" + maxName + "' id='" + maxName +
                "ID'>"
            );
            $(this).slider({
                range: true,
                min: minRangeValue,
                max: maxRangeValue,
                values: [minRangeValue, maxRangeValue],
                slide: function(event, ui) {
                    event = event;
                    var currentMin = parseInt(ui.values[0], 10);
                    var currentMax = parseInt(ui.values[1], 10);
                    $(this).children(".min-value").text(currentMin + " " + unit);
                    $(this).children(".max-value").text(currentMax + " " + unit);
                    $(this).children(".current-min").val(currentMin);
                    $(this).children(".current-max").val(currentMax);
                }
            });
            var currentMin = parseInt($(this).slider("values", 0), 10);
            var currentMax = parseInt($(this).slider("values", 1), 10);
            $(this).children(".min-value").text(currentMin + " " + unit);
            $(this).children(".max-value").text(currentMax + " " + unit);
            $(this).children(".current-min").val(currentMin);
            $(this).children(".current-max").val(currentMax);
        });
    </script>





    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-submenu.js') }}"></script>
    <script src="{{ asset('assets/js/rangeslider.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.mb.YTPlayer.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.scrollUp.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('assets/js/leaflet.js') }}"></script>
    <script src="{{ asset('assets/js/leaflet-providers.js') }}"></script>
    <script src="{{ asset('assets/js/leaflet.markercluster.js') }}"></script>
    <script src="{{ asset('assets/js/dropzone.js') }}"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.filterizr.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.countdown.js') }}"></script>
    <script src="{{ asset('assets/js/modernizr.custom.js') }}"></script>
    <script src="{{ asset('assets/js/boxes-component.js') }}"></script>
    <script src="{{ asset('assets/js/boxes-core.js') }}"></script>
    <script src="{{ asset('assets/js/maps.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="{{ asset('assets/js/ie10-viewport-bug-workaround.js') }}"></script>
    <!-- Custom javascript -->
    <script src="{{ asset('assets/js/ie10-viewport-bug-workaround.js') }}"></script>


    <!--  Datatable css  -->
    <!-- JAVASCRIPT -->
    {{-- <script src="{{asset('vendor/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script> --}}
    <script src="{{ asset('vendor/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('vendor/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('vendor/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('vendor/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('vendor/js/plugins.js') }}"></script>
    <!-- prismjs plugin -->
    <script src="{{ asset('vendor/libs/prismjs/prism.js') }}"></script>
    <script src="{{ asset('vendor/libs/list.js/list.min.js') }}"></script>
    <script src="{{ asset('vendor/libs/list.pagination.js/list.pagination.min.js') }}"></script>
    <!-- listjs init -->
    <script src="{{ asset('vendor/js/pages/listjs.init.js') }}"></script>
@endsection
