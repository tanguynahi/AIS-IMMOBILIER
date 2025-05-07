@extends('layouts.a_template', ['titre' => $titre])

@section('content')
    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Detail Propriété Affaire'])
    <div class="submit-address dashboard-list">
        <br />
        <a type="button" onclick="cancel('{{$affaire->ID_CLIENT ?? 0}}');" class="mb-10" style="margin-left: 20px">
            <i class="fa fa-angle-double-left"></i>&nbsp;<b>Retour</b>
        </a>
        <h4> Detail affaire n°{{$affaire->ID_AFFAIRES ?? 'xxxxxx'}} - {{$affaire->LIB_PROPRIETE ?? 'xxxxx xxxxxxx'}} </h4>
        <div class="row pad-20">
            <div class="col-lg-6 row">
                <h6><u>Informations sur le biens</u></h6>
                <div class="comment">
                    <div class="col-lg-6 mb-20">
                        <img src="{{asset($affaire->IMG_DEFAULT ?? 'img/avatar/avatar-1.png')}}"
                        style="height: 100%; width: 100%">
                    </div>
                    <div class="col-lg-12">
                        <div class="comment-meta">
                            <h5>{{$affaire->LIB_PROPRIETE ?? 'xxxxx xxxxxxx'}}</h5>
                            <div class="comment-meta">
                                {{$affaire->LIB_TYPE ?? 'xxxxxx'}} | {{$affaire->LIB_CATEGORIE ?? 'xxxxxx'}}
                            </div>
                        </div>
                        <ul> <li>Adresse :<span> {{$affaire->ADRESSE ?? 'xxxx, xxxxx, xxxxxx'}}</span></li> </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h6><u>Informations sur l'affaire</u></h6>
                <div class="comment">
                    <div class="col-lg-6 mb-10">
                        <span style="color: black">
                            Montant Affaire : <b>{{ Help::formatNombre($affaire->TOTAL_A_PAYER ?? '0', true) }}</b>
                        </span>
                    </div>
                    <div class="col-lg-6 mb-10">
                        <span style="color: black">
                            Date affaire : <b>{{$affaire->DATE_CONCLUS ?? 'YYYY-MM-DD'}}</b>
                        </span>
                    </div>
                    <div class="col-lg-12 mb-20">
                        <span>Commentaire : <br /><b>{{$affaire->DESCRIPTIF ?? 'Aucun commentaire'}}</b></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <h6><u>Redevances à payer</u></h6>
                <div class="table-box mb-20">
                    @if(count($liaisons)>0)
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">N°</th>
                                        <th scope="col">Redevance</th>
                                        <th scope="col">Total à Payer</th>
                                        <th scope="col">Total Payé</th>
                                        <th scope="col">Reste à Payer</th>
                                        <th scope="col">Echéance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php (int) $n = 0; @endphp
                                    @php (int) $som = 0; @endphp
                                    @foreach($liaisons as $key => $value)
                                        @php (int) $n++; @endphp
                                        @php (int) $som = $som + $value->REST_A_PAYER ; @endphp
                                        <tr>
                                            <th scope="row">{{$n ?? '?'}}</th>
                                            <td>{{$value->LIB_REDEVANCES ?? 'xxxxxx'}}</td>
                                            <td>{{ Help::formatNombre($value->TOTAL_A_PAYER ?? '0', true) }}</td>
                                            <td>{{ Help::formatNombre($value->TOTAL_PAYER ?? '0', true) }}</td>
                                            <td>{{ Help::formatNombre($value->REST_A_PAYER ?? '0', true) }}</td>
                                            <td><b>{{ $value->DATE_FIN_PAY ?? 'JJ/MM/AAAA'  }}</b></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12">
                            <br />
                            <span style="color: black">
                                TOTAL A PAYER : <b>{{ Help::formatNombre($som ?? '0', true) }}</b>
                            </span>
                        </div>
                        <h4></h4>
                    @else
                        <p class="text-left">
                            <i class="fa fa-angle-double-left"></i>
                            <b >Aucune facturation trouvés.</b>
                            <i class="fa fa-angle-double-right"></i>
                        </p>
                    @endif
                </div>
            </div>
            <div class="col-lg-12">
                <div class="buttons mb-10">
                    <a class="btn-1 btn-gray" type="button" onclick="cancel('{{$affaire->ID_CLIENT ?? 0}}');">
                        <i class="fa fa-fw fa-times-circle-o"></i> Fermer
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function cancel(param) {
            var rout = "{{route('clientForm',['idClient'=>':idClient'])}}"
            rout = rout.replace(':idClient', param)
            window.open(rout, '_self');
        }
    </script>
@endsection
