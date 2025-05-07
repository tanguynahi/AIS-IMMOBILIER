@extends('layouts.s_template', ['titre'=>$titre])

@section('content')
    @include('partials.site.sub-banner',['element'=>'Services'])
    @if(count($services)>0)
        <div class="services services-4 content-area">
            <div class="container">
                <div class="main-title text-center">
                    <h1>Nos Services</h1>
                    <p>Decouvrez nos services.</p>
                </div>
                <div class="row">
                    @php (int) $n = 0; @endphp
                    @foreach($services as $key => $value)
                        @php $n++; @endphp
                        <div class="col-lg-4 col-md-6">
                            <div class="service-info-3 d-flex">
                                <div class="icon">
                                    <i class="flaticon-trust"></i>
                                    {{-- {!! $value->ICONS_SERVICE ?? '' !!} --}}
                                </div>
                                <div class="detail align-self-center">
                                    <h3>{{ $value->LIB_SERVICE ?? 'titre' }}</h3>
                                    <p>{{ Help::strCut($value->DESCRIPTION_SERVICE ?? 'description', 0, 103, '...') }}</p>
                                    <a class="read-more" href="{{route('detailServ',['id'=>$value->ID_SERVICES ?? 0])}}">
                                    Lire Plus..</a>
                                    @if(strlen($n)<2) <h4>0 {{$n ?? 1}}</h4> @else <h4>{{$n ?? 00}}</h4> @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
