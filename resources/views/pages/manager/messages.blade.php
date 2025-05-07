@extends('layouts.a_template', ['titre' => $titre])

@section('content')
    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Messages'])
    <div class="submit-address dashboard-list">
        <h4>Liste des Messages</h4>
        <div class="row">
            <div class="col-lg-12">
                <div class="">
                    <div class="card-body">
                        <div class="listjs-table" id="customerList">
                            <div class="row g-4 mb-0">
                                <div class="col-sm-auto">
                                    <div>
                                        <a type="button" onclick="form();" class="btn btn-outline-primary"
                                            style="margin-left: 20px">
                                            <i class="fa fa-plus"></i>&nbsp;&nbsp;Nouveau message
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="d-flex justify-content-sm-end">
                                        <div class="search-box ms-2">
                                            <input type="text" class="form-control search" placeholder="Recherche...">
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive mb-1">
                                <table class="table align-middle table-nowrap" id="customerTable">
                                    <thead style="color: white">
                                        <tr hidden>
                                            <th data-sort="id"></th>
                                            <th data-sort="customer_name"></th>
                                            <th data-sort="phone"></th>
                                            <th data-sort="date"></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach($messages as $key => $value)
                                        <tr>
                                            <td class="id">
                                                <a href="{{route('messageDetail',['id'=>$value->ID_CONTACT])}}"
                                                    @if ($value->NB_NON_LU>0) style="font-weight: bold;" @endif>
                                                    @if ($value->CONTACT==='')
                                                    <span style="color: grey; font-size: 14px; font-weight: bold;">{{$entreprise->RAISON_SOCIALE ?? "BMI-WFS" }}</span>
                                                    @else {{$value->NOM_PRENOMS ?? ''}} @endif
                                                </a>
                                            </td>
                                            <td class="customer_name">
                                                <a href="{{route('messageDetail',['id'=>$value->ID_CONTACT])}}"
                                                    @if ($value->NB_NON_LU>0) style="font-weight: bold;" @endif>
                                                    {{$value->SUJET ?? ''}}
                                                </a>
                                            </td>
                                            <td class="phone">
                                                <a href="{{route('messageDetail',['id'=>$value->ID_CONTACT])}}"
                                                    @if ($value->NB_NON_LU>0) style="font-weight: bold;" @endif>
                                                    {{Help::dateheureFormate($value->DATECREA ?? 'AAAAMMJJ', '/')}}
                                                </a>
                                            </td>
                                            <td class="date">
                                                <a href="{{route('messageDetail',['id'=>$value->ID_CONTACT])}}"
                                                    @if ($value->NB_NON_LU>0) style="font-weight: bold;" @endif>
                                                    @if ($value->NB_NON_LU>0)
                                                        <b style="color: grey; font-size: 14px">
                                                        {{ $value->NB_NON_LU ?? '0' }}</b> message(s) non lu,
                                                    @endif
                                                    <span style="color: grey; font-size: 14px">
                                                        {{ Help::duration($value->DATECREA) }}
                                                    </span>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="comment-meta">
                                                    <a href="{{route('messageDetail',['id'=>$value->ID_CONTACT])}}">Consulter</a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="noresult" style="display: none">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                            colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                        </lord-icon>
                                        <h5 class="mt-2">Désolé! Aucun résultat trouvé</h5>
                                        <p class="text-muted mb-0">
                                            Nous avons recherché plus de 150 messages.
                                            Nous n'avons trouvé aucun pour votre recherche.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <div class="pagination-wrap hstack gap-2">
                                    <a class="page-item pagination-prev disabled" href="#">
                                        <i class="fa fa-angle-double-left"></i>
                                    </a>
                                    <ul class="pagination listjs-pagination mb-0"></ul>
                                    <a class="page-item pagination-next" href="#">
                                        <i class="fa fa-angle-double-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row pad-20" hidden>
            <div class="col-lg-12">
                @if(count($messages)>0)
                    @php (int) $n = 0; (int) $nb = count($messages); @endphp
                    @foreach($messages as $key => $value)
                        @php $n++; @endphp
                        <div class="comment @if ($n==$nb) comment-b @endif">
                            <div class="comment-author">
                                <a>
                                    <img src="@if($value->EST_LU===0 && $value->CONTACT!='' || $value->NB_NON_LU>0)
                                    {{asset('925-9254185.png')}}
                                    @else {{asset('20210908-2210-giz44p.png')}} @endif ">
                                </a>
                            </div>
                            <div class="comment-content">
                                <div class="comment-meta">
                                    <h6>
                                        @if ($value->CONTACT==='')
                                        <span style="color: grey; font-size: 14px">BHCI</span>
                                        @else {{$value->NOM_PRENOMS ?? ''}} @endif
                                    </h6>
                                    <div class=""> {{Help::dateheureFormate($value->DATECREA ?? 'MMJJAAAA', '/')}} </div>
                                    <div class=""> {{$value->ADRESSE ?? ''}} </div>
                                    <div class=""> {{$value->SUJET ?? ''}} </div>
                                    <p style="color: grey; font-size: 14px">
                                        @if ($value->NB_NON_LU>0)
                                            <b>{{ $value->NB_NON_LU ?? '0' }}</b> message(s) non lu,
                                        @endif
                                        <span style="color: grey; font-size: 14px">
                                            {{ Help::duration($value->DATECREA) }}
                                        </span>
                                    </p>
                                </div>
                                <div class="comment-meta">
                                    <a href="{{route('messageDetail',['id'=>$value->ID_CONTACT])}}">Consulter</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center">
                        <i class="fa fa-angle-double-left"></i>
                        <b>Aucun messages reçus</b>
                        <i class="fa fa-angle-double-right"></i>
                    </p>
                @endif
            </div>
        </div> --}}
    </div>
@endsection

@section('js')
    <script>
        function form() {
            var rout = "{{route('messageNouveau')}}";
            window.open(rout, '_self');
        }
    </script>
@endsection
