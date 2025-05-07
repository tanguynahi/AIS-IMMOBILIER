@extends('layouts.a_template', ['titre' => $titre])

@section('content')
    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Galeries Propriété'])
    <div class="dashboard-list">
        <br />
        <a type="button" onclick="cancel();" class="mb-0" style="margin-left: 20px">
            <i class="fa fa-angle-double-left"></i>&nbsp;<b>Retour</b>
        </a>
        <div class="photo-gallery pg-2">
            <div class="container">
                <div class="main-title text-center">
                    {{-- <h1>Properties Gallery</h1> --}}
                    <br />
                    <p class="mb-30">Galerie image de la propriété <b><u>{{$propriete->LIB_PROPRIETE ?? ''}}</u></b></p>
                    <ul class="list-inline-listing filters filteriz-navigation">
                        <li class="active btn filtr-button filtr" data-filter="all">Tous</li>
                        <li data-filter="1" class="btn btn-inline filtr-button filtr">Image principal</li>
                        <li data-filter="2" class="btn btn-inline filtr-button filtr">Image associée</li>
                        <li data-filter="3" class="btn btn-inline filtr-button filtr">Plan</li>
                    </ul>
                </div>
                <a type="button" onclick="form('{{$propriete->ID_PROPRIETES ?? 0}}');"
                    class="btn btn-outline-primary mb-20" style="margin-left: 20px">
                    <i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter Fichier
                </a>
                <br />
                <div class="row filter-portfolio">
                    @if( (isset($propriete->ID_PROPRIETES) && $propriete->IMG_DEFAULT=='') && count($othersFile)<=0 && count($plan)<=0)
                        <div class="col-lg-12 col-md-12 col-sm-12 filtr-item" data-category="1, 2, 3">
                            <div class="main-title text-center">>
                                <p>
                                    <i class="fa fa-angle-double-left"></i>
                                    Aucun fichiers pour la propriété
                                    <b>{{$propriete->LIB_PROPRIETE ?? ''}}</b>
                                    <i class="fa fa-angle-double-right"></i>
                                </p>
                            </div>
                        </div>
                    @else

                        @if(isset($propriete->ID_PROPRIETES) && $propriete->ID_PROPRIETES>0 && $propriete->IMG_DEFAULT!='')
                            <div class="col-lg-4 col-md-6 col-sm-6 filtr-item" data-category="1">
                                <div class="portfolio-item">
                                    <a href="{{asset($propriete->IMG_DEFAULT ?? 'assets/img/properties/properties-1.png')}}" title="{{$propriete->LIB_PROPRIETE ?? ''}}">
                                        <img src="{{asset($propriete->IMG_DEFAULT ?? 'assets/img/properties/properties-1.png')}}" class="img-fluid">
                                    </a>
                                    <div class="portfolio-content">
                                        <div class="portfolio-content-inner">
                                            <p>{{$propriete->LIB_PROPRIETE ?? ''}}</p>
                                        </div>
                                    </div>
                                </div>
                                <a type="button" onclick="deletedata({{$propriete->ID_PROPRIETES}}, 1)">
                                <div class="tag">Supprimer</div></a>
                            </div>
                        @else
                            <div class="col-lg-12 col-md-12 col-sm-12 filtr-item" data-category="3">
                                <div class="main-title text-center">>
                                    <p>
                                        <i class="fa fa-angle-double-left"></i>
                                        Aucun image princaple pour la propriété
                                        <b>{{$propriete->LIB_PROPRIETE ?? ''}}</b>
                                        <i class="fa fa-angle-double-right"></i>
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if(count($othersFile)>0)
                            @foreach($othersFile as $key => $value)
                                <div class="col-lg-4 col-md-6 col-sm-6 filtr-item" data-category="2">
                                    <div class="portfolio-item">
                                        <a href="{{asset($value->PATH_IMAGES ?? 'assets/img/properties/properties-1.png')}}" title="{{$propriete->LIB_PROPRIETE ?? ''}}">
                                            <img src="{{asset($value->PATH_IMAGES ?? 'assets/img/properties/properties-1.png')}}" alt="gallery-photo" class="img-fluid">
                                        </a>
                                        <div class="portfolio-content">
                                            <div class="portfolio-content-inner">
                                                <p>{{$propriete->LIB_PROPRIETE ?? ''}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <a type="button" onclick="deletedata({{$value->ID_PROP_IMAGES}}, 2)">
                                    <div class="tag">Supprimer</div></a>
                                </div>
                            @endforeach
                        @else
                            <div class="col-lg-12 col-md-12 col-sm-12 filtr-item" data-category="2">
                                <div class="main-title text-center">>
                                    <p>
                                        <i class="fa fa-angle-double-left"></i>
                                        Aucune image associée pour la propriété
                                        <b>{{$propriete->LIB_PROPRIETE ?? ''}}</b>
                                        <i class="fa fa-angle-double-right"></i>
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if(count($plan)>0)
                            @foreach($plan as $key => $value)
                                <div class="col-lg-4 col-md-6 col-sm-6 filtr-item" data-category="3">
                                    <div class="portfolio-item">
                                        <a href="{{asset($value->PATH_PLAN ?? 'assets/img/properties/properties-1.png')}}" title="{{$propriete->LIB_PROPRIETE ?? ''}}">
                                            <img src="{{asset($value->PATH_PLAN ?? 'assets/img/properties/properties-1.png')}}" alt="gallery-photo" class="img-fluid">
                                        </a>
                                        <div class="portfolio-content">
                                            <div class="portfolio-content-inner">
                                                <p>{{$propriete->LIB_PROPRIETE ?? ''}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <a type="button" onclick="deletedata({{$value->ID_PLAN_PROP}}, 3)">
                                    <div class="tag">Supprimer</div></a>
                                </div>
                            @endforeach
                        @else
                            <div class="col-lg-12 col-md-12 col-sm-12 filtr-item" data-category="3">
                                <div class="main-title text-center">>
                                    <p>
                                        <i class="fa fa-angle-double-left"></i>
                                        Aucun plan pour la propriété
                                        <b>{{$propriete->LIB_PROPRIETE ?? ''}}</b>
                                        <i class="fa fa-angle-double-right"></i>
                                    </p>
                                </div>
                            </div>
                        @endif

                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function form(param) {
            var rout = "{{route('galerieForm',['idPropriete'=>':idPropriete'])}}";
            rout = rout.replace(':idPropriete', param)
            window.open(rout, '_self');
        }
        function deletedata(idFile, type) {
            var url = "{{route('galerieDesact',['idFile'=>':idFile', 'type'=>':type'])}}"
            url = url.replace(":type", type);
            url = url.replace(":idFile", idFile);
            if (confirm("Voulez-vous supprimer ce fichier ?")) {
                window.open(url, '_self');
            }
        }
        function cancel() { rout = "{{route('proprieteList')}}"; window.open(rout, '_self'); }
    </script>
@endsection
