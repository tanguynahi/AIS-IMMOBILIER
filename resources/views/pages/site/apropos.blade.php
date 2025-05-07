@extends('layouts.s_template', ['titre' => $titre])

@section('content')
    @include('partials.site.sub-banner', ['element' => 'A Propos'])

    @if(count($apropos)>0)
        <div class="about-real-estate  content-area-5 bg-grea-3">
            <div class="container">
                <div class="row">
                    @foreach($apropos as $key => $value)
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="about-text clearfix">
                                <h3>{{$value->TITRE_INFO ?? ''}}</h3>
                                <p>{!!$value->CONTENU_INFO ?? 'desc'!!}</p>
                                {{-- <div class="bottom">
                                    <div class="left">
                                        <h5 class="name">james holler</h5>
                                        <p class="post mb-0">General manager</p>
                                    </div>
                                    <div class="signature float-right"><img src="img/signature.png" alt="signature"></div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="about-img-section">
                                <div class="image-box sssa">
                                    <div class="image-1">
                                        <img src="{{ asset($value->PATH_APROPOS ?? 'assets/img/about-bg.png') }}" class="w-100">
                                    </div>
                                </div>
                                <div class="about-box-Experience">
                                    <img src="{{asset('assets/img/about-shape.png')}}" class="img-fluid">
                                    <div class="content">
                                        <h3>25+</h3>
                                        <p class="mb-0">Ans d'expériences</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if(count($personnes)>0)
        <div class="our-team comon-slick content-area">
            <div class="container">
                <div class="main-title">
                    <h1>Notre Equipe</h1>
                    <p>Notre dynamique equipe pour vous servir 24H/24</p>
                </div>
                <div class="slick row comon-slick-inner"
                    data-slick='{"slidesToShow": 4, "responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}}]}'>
                    @foreach($personnes as $key => $value)
                        <div class="item slide-box">
                            <div class="team-1">
                                <div class="team-thumb">
                                    <a href="#">
                                        <img src="{{($value->PATH_PERS ?? 'img/avatar/avatar-6.png')}}" class="img-fluid">
                                    </a>
                                    <div class="team-social flex-middle">
                                        <div class="team-overlay"></div>
                                        <div class="team-social-inner">
                                            <a rel="nofollow" href="{{$value->URL_FBK ?? '#'}}" class="facebook">
                                                <i class="fa fa-facebook" aria-hidden="true"></i>
                                            </a>
                                            <a rel="nofollow" href="{{$value->URL_TWT ?? '#'}}" class="twitter">
                                                <i class="fa fa-twitter" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="team-info">
                                    <h4> {{$value->PRENOMS_PERS ?? '#'}} {{$value->NOM_PERS ?? '#'}} </h4>
                                    <p>{{$value->LIB_FONCTION ?? ''}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @include('partials.site.counters', ['types'=>$counters, 'agents'=>$agents])
@endsection
