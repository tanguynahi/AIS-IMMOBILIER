@extends('layouts.s_template', ['titre'=>$titre])

@section('content')
    @include('partials.site.sub-banner',['element'=>'Detail Service'])
    <div class="blog-body content-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="blog-1 blog-big">
                        <div class="blog-photo">
                            <img src="{{asset($service->PATH_SERVICE ?? 'assets/img/blog/blog-1.png')}}"
                            alt="blog-img" class="img-fluid w-100">
                        </div>
                        <div class="detail">
                            <h3><a href="#"> {{ $service->LIB_SERVICE ?? 'xxxxx' }} </a></h3>
                            <p> {!! $service->DESCRIPTION_SERVICE ?? '' !!} </p>
                            <br>
                            @if(count($services)>0)
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="blog-tags">
                                            <span>Tags</span>
                                            @foreach($services as $key => $value)
                                                @if($value->ID_SERVICES!=$service->ID_SERVICES)
                                                    <a href="{{route('detailServ',['id'=>$value->ID_SERVICES ?? 0])}}">
                                                    {{$value->LIB_SERVICE ?? 'xxxx'}}</a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="sidebar-right">
                        <!-- Search box -->
                        <div class="widget search-box">
                            <h3 class="sidebar-title">Recherche</h3>
                            <div class="s-border"></div>
                            <div class="m-border"></div>
                            <form class="form-inline form-search" method="GET">
                                <div class="form-group">
                                    <label class="sr-only" for="textsearch2">Recherche</label>
                                    <input type="text" class="form-control" id="textsearch2" placeholder="Trouver une propriété">
                                </div>
                                <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <!-- Recent properties start -->
                        @if(count($recent)>0)
                            <div class="widget recent-properties">
                                <h3 class="sidebar-title">Propriétés Recentes</h3>
                                <div class="s-border"></div>
                                <div class="m-border"></div>
                                @php (int) $n = 0; $occ = count($recent); @endphp
                                @foreach ($recent as $key => $p)
                                    <div class="d-flex @if($n!=$occ) mb-3 @endif recent-posts-box">
                                        <a class="pr-3" href="{{ route('detailP',['idPropriete'=>$p->ID_PROPRIETES]) }}">
                                            <img src="{{($p->IMG_DEFAULT ?? 'assets/img/properties/small-properties-1.png')}}"
                                            class="flex-shrink-0 me-3">
                                        </a>
                                        <div class="detail align-self-center">
                                            <h5>
                                                <a href="{{ route('detailP',['idPropriete'=>$p->ID_PROPRIETES]) }}">
                                                {{ $p->LIB_PROPRIETE ?? 'designation' }}</a>
                                            </h5>
                                            <div class="listing-post-meta">
                                                @if ($p->EN_PROMOTION == true)
                                                    <s style="color: #8888; font-size: 80%">
                                                    {{ Help::formatNombre($p->PRIX_HT ?? '0', true) }}</s>
                                                    <b style="font-size: 80%">(-{{ $p->POURCENT_PROMO ?? '0.0' }}%)</b>&nbsp;
                                                    <span>{{ Help::formatNombre($p->PRIX_PROMO ?? '0', true) }}</span>
                                                    <br />
                                                @else
                                                    {{ Help::formatNombre($p->PRIX_HT ?? '0', true) }}
                                                @endif
                                                | <i class="fa fa-calendar"></i> {{$p->ANNEE ?? 'année'}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <!-- Social links Start -->
                        <div class="widget social-links">
                            <h3 class="sidebar-title">Liens sociaux</h3>
                            <div class="s-border"></div>
                            <div class="m-border"></div>
                            <ul class="social-list clearfix">
                                <li><a href="#" class="facebook-bg"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#" class="twitter-bg"><i class="fa fa-twitter"></i></a></li>
                            </ul>
                        </div>
                        <!-- Tags box Start -->
                        @if(count($categories)>0)
                            <div class="widget-3 tags-box">
                                <h3 class="sidebar-title">Catégories populaires</h3>
                                <div class="s-border"></div>
                                <div class="m-border"></div>
                                <ul class="tags">
                                    @foreach($categories as $key => $value)
                                        <li>
                                            <a href="{{route('listByCategories',['type'=>0, 'idCategories'=>$value->ID_CATEGORIES, 'act'=>'ls'])}}">
                                            {{ $value->LIB_CATEGORIE ?? 'categorie' }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
