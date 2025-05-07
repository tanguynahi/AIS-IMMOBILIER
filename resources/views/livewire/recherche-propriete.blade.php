<div>
    <div class="properties-section-body">
        <div class="container">
            <br />
            <p>{!!$str ?? ''!!}</p>
            <div class="row">
                <div class="col-lg-4 col-md-12" wire:ignore>
                    <div class="sidebar-left">
                        <div class="widget advanced-search">
                            <h3 class="sidebar-title">Recherche Avancée</h3>
                            <div class="s-border"></div>
                            <div class="m-border"></div>
                            <form method="post" action="#">
                                @csrf
                                <div class="form-group">
                                    <label>Types </label>
                                    <select class="selectpicker search-fields" id="all_status" wire:model.defer="all_status">
                                        <option value="0">Tous</option>
                                        @foreach ($types as $v)
                                            <option value="{{$v->ID_TYPE_PROPRIETE}}">{{$v->LIB_TYPE}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Categories </label>
                                    <select class="selectpicker search-fields" id="all_categories" wire:model.defer="all_categories">
                                        <option value="0">Tous</option>
                                        @foreach ($categories as $v)
                                            <option value="{{ $v->ID_CATEGORIES ?? 0}}">
                                                {{ $v->LIB_CATEGORIE }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" hidden>
                                    <label>Pays </label>
                                    <select class="form-control" id="IDPays">
                                        <option value="0" selected disabled>Choisir pays..</option>
                                        @foreach ($pays as $p)
                                            <option value="{{$p->ID_PAYS ?? 0}}" @if($idPays==$p->ID_PAYS) selected @endif>
                                                {{$p->LIB_PAYS ?? 'xxxx'}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Ville </label>
                                    <select class="selectpicker search-fields" id="city" wire:model.defer="city">
                                        <option value="0">Toutes..</option>
                                        @foreach ($villes as $v)
                                            <option value="{{$v->ID_VILLE}}">
                                                {{$v->LIB_VILLE ?? 'xxxx'}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Pièce </label>
                                            <select class="selectpicker search-fields" id="nb_pieces" wire:model.defer="nb_pieces">
                                                <option value="0">Toutes</option>
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
                                            <select class="selectpicker search-fields" id="annee_const" wire:model.defer="annee_const">
                                                <option value="0">Toutes </option>
                                                @foreach ($annees as $v)
                                                    <option value="{{$v->ANNEE_CONST_ID}}">{{$v->LIB_ANNEE_CONST}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="range-slider clearfix form-group">
                                    <label>Superficie</label>
                                    <div data-min="0" data-max="10000" data-min-name="min_area"
                                        data-max-name="max_area"
                                        data-unit="m²"
                                        class="range-slider-ui ui-slider"
                                        aria-disabled="false">
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="range-slider clearfix form-group mb-30">
                                    <label>Prix</label>
                                    <div data-min="0" data-max="150000000" data-min-name="min_price"
                                        data-max-name="max_price"
                                        data-unit="XOF"
                                        class="range-slider-ui ui-slider"
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
                                            <div class="accordion-body mb-20">
                                                <h3 class="sidebar-title">Filtres</h3>
                                                <div class="s-border"></div>
                                                <div class="m-border"></div>
                                                <div class="checkbox checkbox-theme checkbox-circle">
                                                    <input type="checkbox" id="checkbox2" wire:model.defer="wifi">
                                                    <label for="checkbox2">WIFI </label>
                                                </div>
                                                <div class="checkbox checkbox-theme checkbox-circle">
                                                    <input type="checkbox" id="checkbox3" wire:model.defer="piscine">
                                                    <label for="checkbox3">PISCINE </label>
                                                </div>
                                                <div class="checkbox checkbox-theme checkbox-circle">
                                                    <input type="checkbox" id="checkbox4" wire:model.defer="cuisine_equip">
                                                    <label for="checkbox4">CUSINE EQUIPE </label>
                                                </div>
                                                <div class="checkbox checkbox-theme checkbox-circle">
                                                    <input type="checkbox" id="checkbox1" wire:model.defer="clim">
                                                    <label for="checkbox1">CLIMATISATION </label>
                                                </div>
                                                <div class="checkbox checkbox-theme checkbox-circle">
                                                    <input type="checkbox" id="checkbox7" wire:model.defer="parking">
                                                    <label for="checkbox7">PARKING </label>
                                                </div>
                                                <div class="checkbox checkbox-theme checkbox-circle">
                                                    <input type="checkbox" id="checkbox5" wire:model.defer="securite">
                                                    <label for="checkbox5">SECURITE </label>
                                                </div>
                                                <div class="checkbox checkbox-theme checkbox-circle">
                                                    <input type="checkbox" id="checkbox6" wire:model.defer="salle_sport">
                                                    <label for="checkbox6">SALLE DE SPORT </label>
                                                </div>
                                            </div>
                                            <div class="form-group mb-0">
                                                <button class="search-button" type="button" wire:click="liveSEARCH">Appliquer </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if(count($recent)>0)
                            <div class="widget recent-properties" hidden>
                                <h3 class="sidebar-title">Propriétés Recentes</h3>
                                <div class="s-border"></div>
                                <div class="m-border"></div>
                                @foreach ($recent as $key => $value)
                                    <div class="d-flex mb-3 recent-posts-box">
                                        <a class="pr-3" href="{{ route('detailP',['idPropriete'=>$value->ID_PROPRIETES]) }}">
                                            <img src="{{asset($value->IMG_DEFAULT ?? 'assets/img/properties/small-properties-1.png')}}"
                                            class="flex-shrink-0 me-3">
                                        </a>
                                        <div class="detail align-self-center">
                                            <h5>
                                                <a href="{{ route('detailP',['idPropriete'=>$value->ID_PROPRIETES]) }}">
                                                {{ $value->LIB_PROPRIETE ?? 'designation' }}</a>
                                            </h5>
                                            <div class="listing-post-meta">
                                                @if ($value->EN_PROMOTION == true)
                                                    <s style="color: #8888; font-size: 80%">
                                                    {{ Help::formatNombre($value->PRIX_HT ?? '0', true) }}</s>
                                                    <b style="font-size: 80%">(-{{ $value->POURCENT_PROMO ?? '0.0' }}%)</b>&nbsp;
                                                    <span>{{ Help::formatNombre($value->PRIX_PROMO ?? '0', true) }}</span>
                                                    <br />
                                                @else
                                                    {{ Help::formatNombre($value->PRIX_HT ?? '0', true) }}
                                                @endif
                                                 | <i class="fa fa-calendar"></i> {{$value->ANNEE ?? 'année'}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @if(count($nombres)>0)
                            <div class="posts-by-category widget">
                                <h3 class="sidebar-title">Categories</h3>
                                <div class="s-border"></div>
                                <div class="m-border"></div>
                                <ul class="list-unstyled list-cat">
                                    @foreach($nombres as $key => $env)
                                        <li>
                                            <a href="{{route('listByCategories',['type'=>0, 'idCategories'=>$env->ID_CATEGORIES, 'act'=>'ls'])}}">
                                            {{$env->LIB_CATEGORIE ?? 'libelle'}} <span>({{$env->Nb ?? 'x'}})</span></a>
                                        </li>
                                    @endforeach
                                </ul>
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
                    </div>
                </div>
                <div class="col-lg-8 col-md-12">
                    <div class="option-bar">
                        <div class="row">
                            <div class="col-lg-6 col-8">
                                <div class="sorting-options2">
                                    <h3 class="sidebar-title">{{count($result) ?? 0}} Propriété(s)</h3>
                                    <div class="s-border"></div>
                                    <div class="m-border"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-4">
                                <div class="sorting-options">
                                    <a class="change-view-btn active-view-btn">
                                    <i class="fa fa-th-large"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if(count($result)>0)
                            @foreach($result as $key => $p)
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="property-box-6">
                                        <div class="property-photo">
                                            <img src="{{asset($p->IMG_DEFAULT ?? 'assets/img/properties/properties-11.png')}}"
                                            class="img-fluid w-100">
                                            <div class="tag">{{ $p->LIB_TYPE ?? 'vente/location' }}</div>
                                            <div class="property-inner">
                                                <div class="property-info">
                                                    <br />
                                                    <h4 class="properties-name">
                                                        <a href="{{ route('detailP',['idPropriete'=>$p->ID_PROPRIETES]) }}">
                                                        {{ $p->LIB_PROPRIETE ?? 'designation' }} |
                                                        {{ $p->LIB_CATEGORIE ?? 'Categ' }}</a>
                                                    </h4>
                                                    @if ($p->EN_PROMOTION == true)
                                                        <div class="">
                                                            <span style="font-size: 130%">
                                                            {{ Help::formatNombre($p->PRIX_PROMO ?? '0', true) }}</span>
                                                            <s style="color: red">
                                                            {{ Help::formatNombre($p->PRIX_HT ?? '0', true) }}</s>
                                                            <span style="color: green">(-{{ $p->POURCENT_PROMO ?? '0.0' }}%)</span>
                                                        </div>
                                                    @else
                                                        <div class="">
                                                            <span style="font-size: 130%; color: red">
                                                            {{ Help::formatNombre($p->PRIX_HT ?? '0', true) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="property-inner">
                                            <div class="property-info">
                                                <p class="location">
                                                    <a href="{{ route('detailP',['idPropriete'=>$p->ID_PROPRIETES]) }}">
                                                        <i class="fa fa-map-marker"></i>
                                                        {{ Help::strCut($p->ADRESSE ?? 'adresse', 0, 40, '...') }}
                                                    </a>
                                                </p>
                                                <ul class="facilities-list clearfix">
                                                    <li @if ($p->ID_TYPE!==1) hidden @endif>
                                                        <i class="flaticon-room"></i> {{ $p->NB_PIECES ?? 'x' }} Pièce(s)
                                                    </li>
                                                    <li @if ($p->ID_TYPE!==1) hidden @endif>
                                                        <i class="flaticon-bed"></i> {{ $p->NB_CHAMBRES ?? 'x' }} Chambre(s)
                                                    </li>
                                                    <li @if ($p->ID_TYPE!==1) hidden @endif>
                                                        <i class="flaticon-bathroom"></i> {{$p->NB_SALLE_DE_BAIN ?? 'beds'}} Bain(s)
                                                    </li>
                                                    <li>
                                                        <i class="flaticon-area"></i> {{ $p->SUPERFICIE ?? 'xxx' }} m²
                                                    </li>
                                                    <li @if ($p->ID_TYPE!==1) hidden @endif>
                                                        <i class="flaticon-car"></i> {{ $p->NB_GARAGE ?? 'parking' }} Garage(s)
                                                    </li>
                                                    @if(isset($p->SECURITE) && $p->SECURITE>0)
                                                        <li  @if ($p->ID_TYPE!==1) hidden @endif><i class="flaticon-sell"></i>Securite </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="team-hover-content">
                                            <div class="property-photo">
                                                <img src="{{asset($p->IMG_DEFAULT ?? 'assets/img/properties/properties-11.png')}}"
                                                class="img-fluid w-100">
                                            </div>
                                            <div class="property-info">
                                                <h4 class="properties-name">
                                                    <a href="{{ route('detailP',['idPropriete'=>$p->ID_PROPRIETES]) }}">
                                                    {{ $p->LIB_PROPRIETE ?? 'designation' }} |
                                                    {{ $p->LIB_CATEGORIE ?? 'Categ' }}</a>
                                                </h4>
                                                <p class="location">
                                                    <a href="{{ route('detailP',['idPropriete'=>$p->ID_PROPRIETES]) }}">
                                                        <i class="fa fa-map-marker"></i> {{ $p->ADRESSE ?? 'Adresse' }}
                                                    </a>
                                                </p>
                                            </div>
                                            <ul class="member-socials clearfix">
                                                <li @if ($p->ID_TYPE!==1) hidden @endif>
                                                    <i class="flaticon-room"></i> {{ $p->NB_PIECES ?? 'x' }} Pièce(s)
                                                </li>
                                                <li @if ($p->ID_TYPE!==1) hidden @endif>
                                                    <i class="flaticon-bed"></i> {{ $p->NB_CHAMBRES ?? 'x' }} Chambre(s)
                                                </li>
                                                <li @if ($p->ID_TYPE!==1) hidden @endif>
                                                    <i class="flaticon-bathroom"></i> {{$p->NB_SALLE_DE_BAIN ?? 'beds'}} Bain(s)
                                                </li>
                                                <li>
                                                    <i class="flaticon-area"></i> {{ $p->SUPERFICIE ?? 'xxx' }} m²
                                                </li>
                                                <li @if ($p->ID_TYPE!==1) hidden @endif>
                                                    <i class="flaticon-car"></i> {{ $p->NB_GARAGE ?? 'parking' }} Garage(s)
                                                </li>
                                                @if(isset($p->SECURITE) && $p->SECURITE>0)
                                                    <li @if ($p->ID_TYPE!==1) hidden @endif><i class="flaticon-sell"></i>Securite </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    {{-- {{ $result->links() }} --}}
                    <br />
                </div>
            </div>
        </div>
    </div>
</div>


@script
<script>
    $("#all_status").on('change', function() {
        v1 = $("#all_status").val();
        v2 = $("#city").val();
        v3 = $("#all_categories").val();
        v4 = $("#nb_pieces").val();
        v5 = $("#annee_const").val();
        $wire.dispatch('updateWireChps', { p1: v1, p2: v2, p3: v3, p4: v4, p5: v5});
    });
    $("#city").on('change', function() {
        v1 = $("#all_status").val();
        v2 = $("#city").val();
        v3 = $("#all_categories").val();
        v4 = $("#nb_pieces").val();
        v5 = $("#annee_const").val();
        $wire.dispatch('updateWireChps', { p1: v1, p2: v2, p3: v3, p4: v4, p5: v5});
    });
    $("#all_categories").on('change', function() {
        v1 = $("#all_status").val();
        v2 = $("#city").val();
        v3 = $("#all_categories").val();
        v4 = $("#nb_pieces").val();
        v5 = $("#annee_const").val();
        $wire.dispatch('updateWireChps', { p1: v1, p2: v2, p3: v3, p4: v4, p5: v5});
    });
    $("#nb_pieces").on('change', function() {
        v1 = $("#all_status").val();
        v2 = $("#city").val();
        v3 = $("#all_categories").val();
        v4 = $("#nb_pieces").val();
        v5 = $("#annee_const").val();
        $wire.dispatch('updateWireChps', { p1: v1, p2: v2, p3: v3, p4: v4, p5: v5});
    });
    $("#annee_const").on('change', function() {
        v1 = $("#all_status").val();
        v2 = $("#city").val();
        v3 = $("#all_categories").val();
        v4 = $("#nb_pieces").val();
        v5 = $("#annee_const").val();
        $wire.dispatch('updateWireChps', { p1: v1, p2: v2, p3: v3, p4: v4, p5: v5});
    });
    $(".range-slider-ui").each(function () {
        var minRangeValue = $(this).attr('data-min');
        var maxRangeValue = $(this).attr('data-max');
        var minName = $(this).attr('data-min-name');
        var maxName = $(this).attr('data-max-name');
        var unit = $(this).attr('data-unit');
        $(this).append("" +
            "<span class='min-value'></span> " +
            "<span class='max-value'></span>" +
            "<input class='current-min' style='display: none;' name='"+minName+"' wire:model='"+minName+"'>" +
            "<input class='current-max' style='display: none;' name='"+maxName+"' wire:model='"+maxName+"'>"
        );
        $(this).slider({
            range: true,
            min: minRangeValue,
            max: maxRangeValue,
            values: [minRangeValue, maxRangeValue],
            slide: function (event, ui) {
                event = event;
                var currentMin = parseInt(ui.values[0], 10);
                var currentMax = parseInt(ui.values[1], 10);
                $(this).children(".min-value").text( currentMin + " " + unit);
                $(this).children(".max-value").text(currentMax + " " + unit);
                $(this).children(".current-min").val(currentMin);
                $(this).children(".current-max").val(currentMax);
                @this.set(minName, currentMin);
                @this.set(maxName, currentMax);
            }
        });
        var currentMin = parseInt($(this).slider("values", 0), 10);
        var currentMax = parseInt($(this).slider("values", 1), 10);
        $(this).children(".min-value").text( currentMin + " " + unit);
        $(this).children(".max-value").text(currentMax + " " + unit);
        $(this).children(".current-min").val(currentMin);
        $(this).children(".current-max").val(currentMax);
    });
</script>
@endscript
