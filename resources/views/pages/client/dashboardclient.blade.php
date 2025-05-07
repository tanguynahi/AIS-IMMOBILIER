@extends('layouts.c_template', ['titre'=>$titre])

@section('content')

    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Tableau de bord'])
    <div class="alert alert-2 alert-warning alert-dismissible fade show" role="alert" hidden>
        <strong>Holy guacamole!</strong> You should check in on some of those fields below.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="ui-item bg-success">
                <div class="left">
                    <h4>{{$nbProp ?? 0}}</h4>
                    <p>Propriétés Acquis</p>
                </div>
                <div class="right">
                    <i class="flaticon-empire-state-building"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="ui-item" style="background-color: #27AE60">
                <div class="left">
                    <h4>{{$stats->TOTAL ?? 0}}</h4>
                    <p>Total à Payer</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="ui-item" style="background-color: #138D75">
                <div class="left">
                    <h4>{{$stats->PAYER ?? 0}}</h4>
                    <p>Total Payer</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="ui-item" style="background-color: #196F3D">
                <div class="left">
                    <h4>{{$stats->SOLDE ?? 0}}</h4>
                    <p>Reste à Payer</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="dashboard-list">
                <div class="dashboard-message bdr clearfix">
                    <div class="tab-box-2">
                        <div class="clearfix mb-30 comments-tr">
                            <span>Paiement en cours à ce jour
                                <i class="fa fa-angle-double-left"></i>
                                {{ Help::cDateJour() ?? 'jour' }}
                                <i class="fa fa-angle-double-right"></i>
                            </span>
                        </div>
                        @if(count($paiements)>0)
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead style="background-color: #EAEDED;">
                                        <tr>
                                            <td><strong>Propriété</strong></td>
                                            <td><strong>Redevance</strong></td>
                                            <td><strong>Total à Payer</strong></td>
                                            <td><strong>Total Payé</strong></td>
                                            <td><strong>Reste à Payer</strong></td>
                                            <td><strong>Echéance</strong></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php (int) $som = 0; @endphp
                                        @foreach($paiements as $key => $value)
                                            @php (int) $som = $som + $value->REST_A_PAYER ; @endphp
                                            <tr>
                                                <td title="{{$value->LIB_PROPRIETE ?? ''}}">
                                                    {{ Help::strCut($value->LIB_PROPRIETE ?? 'xxxxxx', 0, 30, '...') }}
                                                </td>
                                                <td>{{$value->LIB_REDEVANCES ?? 'xxxxxx'}}</td>
                                                <td>{{ Help::formatNombre($value->TOTAL_A_PAYER ?? '0', true) }}</td>
                                                <td>{{ Help::formatNombre($value->TOTAL_PAYER ?? '0', true) }}</td>
                                                <td><b>{{ Help::formatNombre($value->REST_A_PAYER ?? '0', true) }}</b></td>
                                                <td><b>{{ $value->DATE_FIN_PAY ?? 'JJ/MM/AAAA'  }}</b></td>
                                                <td>
                                                    <a href="{{route('nouvPaiement',['id'=>$value->ID_LIAIS])}}"
                                                    class="btn btn-outline-primary">Payer </a>
                                                </td>
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
                            <br />
                            <div class="text-center">
                                <a href="{{route('nouvPaiement',['id'=>0])}}" class="btn btn-outline-primary"
                                    style="margin-left: 20px"><i class="fa fa-plus"></i>&nbsp;&nbsp;Nouveau Paiement
                                </a>
                            </div>
                        @else
                            <div class="comment">
                                <p class="text-center">
                                    <i class="fa fa-angle-double-left"></i>
                                    <b>Aucun paiement en cours.</b>
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
