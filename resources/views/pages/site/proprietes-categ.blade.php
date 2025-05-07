@extends('layouts.s_template', ['titre'=>$titre])
@section('content')
    @include('partials.site.sub-banner',['element'=>'Catalogue Propriétés'])
    <div class="properties-section-body">
        <div class="container">
            <br />
            <p id="filtre">Propriété(s) de la categorie {!!$str ?? ''!!}</p>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <div class="option-bar">
                        <div class="row">
                            <span class="sort">Trier Par: </span>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>TYPE </label>
                                        <select class="selectpicker search-fields" id="typeID">
                                            <option value="0">Tous</option>
                                            @foreach ($types as $v)
                                            <option value="{{$v->ID_TYPE_PROPRIETE}}">{{$v->LIB_TYPE}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>CATEGORIE </label>
                                        <select class="selectpicker search-fields" id="categorieID">
                                            <option value="0">Tous</option>
                                            @foreach ($categories as $v)
                                                <option value="{{ $v->ID_CATEGORIES }}" @if($idCategories==$v->ID_CATEGORIES) selected @endif>
                                                {{ $v->LIB_CATEGORIE }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="zrList">
                        @if(count($result)>0)
                            @foreach($result as $key => $p)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="property-box-3">
                                        <img src="{{asset($p->IMG_DEFAULT ?? 'assets/img/properties/properties-14.png')}}"
                                        class="img-fluid w-100" style="height: 380px; width:665px">
                                        <div class="tag">{{ $p->LIB_TYPE ?? 'vente/location' }}</div>
                                        <div class="ling-section">
                                            <h3>
                                                <a href="{{ route('detailP',['idPropriete'=>$p->ID_PROPRIETES]) }}">
                                                {{ $p->LIB_PROPRIETE ?? 'designation' }} |
                                                {{ $p->LIB_CATEGORIE ?? 'Categ' }}</a>
                                            </h3>
                                            @if ($p->EN_PROMOTION == true)
                                                <div class="">
                                                    <span style="font-size: 130%; color:greenyellow">
                                                    <b>{{ Help::formatNombre($p->PRIX_PROMO ?? '0', true) }}</b></span>
                                                    <s style="color:black">
                                                    <b>{{ Help::formatNombre($p->PRIX_HT ?? '0', true) }}</s></b>
                                                    <span style="color: white">(-{{ $p->POURCENT_PROMO ?? '0.0' }}%)</span>
                                                </div>
                                            @else
                                                <div class="">
                                                    <span style="font-size: 130%; color: greenyellow">
                                                    <b>{{ Help::formatNombre($p->PRIX_HT ?? '0', true) }}</b>
                                                    </span>
                                                </div>
                                            @endif
                                            <ul class="member-socials clearfix">
                                                <li>
                                                    <i class="flaticon-room"></i> {{ $p->NB_PIECES ?? 'x' }} Pièce(s)
                                                </li>
                                                <li>
                                                    <i class="flaticon-bed"></i> {{ $p->NB_CHAMBRES ?? 'x' }} Chambre(s)
                                                </li>
                                                <li>
                                                    <i class="flaticon-bathroom"></i> {{$p->NB_SALLE_DE_BAIN ?? 'beds'}} Bain(s)
                                                </li>
                                                <li>
                                                    <i class="flaticon-area"></i> {{ $p->SUPERFICIE ?? 'xxx' }} m²
                                                </li>
                                                <li>
                                                    <i class="flaticon-car"></i> {{ $p->NB_GARAGE ?? 'parking' }} Garage(s)
                                                </li>
                                                @if(isset($p->SECURITE) && $p->SECURITE>0)
                                                    <li><i class="flaticon-sell"></i>Securite </li>
                                                @endif
                                            </ul>
                                            <a href="{{ route('detailP',['idPropriete'=>$p->ID_PROPRIETES]) }}"
                                            class="read-more-btn">Details</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="option-bar">
                                &nbsp;
                                <p class="text-center">
                                    <i class="fa fa-angle-double-left"></i>
                                    Aucune Propriété trouvées
                                    <i class="fa fa-angle-double-right"></i>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $("#typeID").on('change', function() { ajaxSearch(); });
        $("#categorieID").on('change', function() { ajaxSearch(); });
        function ajaxSearch() {
            var idtype = $("#typeID").val();
            var idCategorie = $("#categorieID").val();
            var url = "{{ route('listByCategories', ['type' => ':IDType', 'idCategories'=>':IDCategories', 'ajax']) }}";
            url = url.replace(":IDType", idtype);
            url = url.replace(":IDCategories", idCategorie);
            $('#filtre').text('Visualisation Propriété par Type & Par Categorie');
            $.ajax({
                type: "get",
                url: url,
                contentType: "application/json",
                success: function(data) {
                    $('#zrList').empty();
                    if (data.length > 0) {
                        data.forEach((p) => {
                            var ROUTE = "{{route('detailP',['idPropriete'=>':ID_PROPRIETES']) }}";
                            ROUTE = ROUTE.replace(':ID_PROPRIETES', p.ID_PROPRIETES);
                            var IMG = "{{asset(':IMG_DEFAULT' ?? 'assets/img/properties/properties-14.png')}}";
                            var str = p.IMG_DEFAULT;
                            IMG = IMG.replace(':IMG_DEFAULT', str.substring(1));
                            var PRIX_HT = new Intl.NumberFormat().format(p.PRIX_HT);
                            var PRIX_PROMO = new Intl.NumberFormat().format(p.PRIX_PROMO);
                            var valeur =
                            `<div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="property-box-3">
                                    <img src="${ IMG }"
                                    class="img-fluid w-100" style="height: 380px; width:665px">
                                    <div class="tag">${ p.LIB_TYPE ?? 'vente/location' }</div>
                                    <div class="ling-section">
                                        <h3>
                                            <a href="${ ROUTE }">
                                            ${ p.LIB_PROPRIETE ?? 'designation' } |
                                            ${ p.LIB_CATEGORIE ?? 'Categ' }</a>
                                        </h3>`;
                                        if (p.EN_PROMOTION == true){
                                            valeur += `<div class="">
                                                <span style="font-size: 130%; color:greenyellow">
                                                <b>${ PRIX_PROMO } XOF</b></span>
                                                <s style="color:black">
                                                <b>${ PRIX_HT } XOF</s></b>
                                                <span style="color: white">(-${ p.POURCENT_PROMO ?? '0.0' }%)</span>
                                            </div>`;
                                        }else{
                                            valeur += `<div class="">
                                                <span style="font-size: 130%; color: greenyellow">
                                                <b>${ PRIX_HT } XOF</b></span>
                                            </div>`;
                                        }
                                        valeur += `<ul class="member-socials clearfix">
                                            <li>
                                                <i class="flaticon-room"></i> ${ p.NB_PIECES ?? 'x' } Pièce(s)
                                            </li>
                                            <li>
                                                <i class="flaticon-bed"></i> ${ p.NB_CHAMBRES ?? 'x' }$ Chambre(s)
                                            </li>
                                            <li>
                                                <i class="flaticon-bathroom"></i> ${p.NB_SALLE_DE_BAIN ?? 'beds'} Bain(s)
                                            </li>
                                            <li>
                                                <i class="flaticon-area"></i> ${ p.SUPERFICIE ?? 'xxx' } m²
                                            </li>
                                            <li>
                                                <i class="flaticon-car"></i> ${ p.NB_GARAGE ?? 'parking' } Garage(s)
                                            </li>`;
                                            if(p.SECURITE>0){
                                                valeur += `<li><i class="flaticon-sell"></i>Securite </li>`;
                                            }
                                        valeur += `</ul>
                                        <a href="${ ROUTE }"
                                        class="read-more-btn">Details</a>
                                    </div>
                                </div>
                            </div>`;
                            $('#zrList').append(valeur);
                        });
                    }else{
                        var valeur =
                        `<div class="option-bar">
                            &nbsp;
                            <p class="text-center">
                                <i class="fa fa-angle-double-left"></i>
                                Aucune Propriété trouvées
                                <i class="fa fa-angle-double-right"></i>
                            </p>
                        </div>`;
                        $('#zrList').append(valeur);
                    }
                }, error: function(data) { console.log(data); alert('Erreur interne du serveur !'); }
            });
        }
    </script>
@endsection
