@extends('layouts.a_template', ['titre'=>$titre])

@section('content')

    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Tableau de bord'])
    <div class="alert alert-2 alert-warning alert-dismissible fade show" role="alert" hidden>
        <strong>Holy guacamole!</strong> You should check in on some of those fields below.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="row">
        <div class="@if (Help::optAutorise(['ZZZ'], $us->ID_UTILISATEUR)) col-lg-3 col-md-3 col-sm-12 @else col-lg-4 col-md-4 col-sm-12 @endif">
            <div class="ui-item bg-success">
                <div class="left">
                    <h4>{{$nbCli ?? 0}}</h4>
                    <p>Client(s)</p>
                </div>
                <div class="right"><i class="fa fa-users"></i></div>
            </div>
        </div>
        <div class="@if (Help::optAutorise(['ZZZ'], $us->ID_UTILISATEUR)) col-lg-3 col-md-3 col-sm-12 @else col-lg-4 col-md-4 col-sm-12 @endif">
            <div class="ui-item" style="background-color: #138D75">
                <div class="left">
                    <h4>{{$nbPro ?? 0}}</h4>
                    <p>Propriéte(s)</p>
                </div>
                <div class="right"><i class="flaticon-empire-state-building"></i></div>
            </div>
        </div>
        <div class="@if (Help::optAutorise(['ZZZ'], $us->ID_UTILISATEUR)) col-lg-3 col-md-3 col-sm-12 @else col-lg-4 col-md-4 col-sm-12 @endif">
            <div class="ui-item bg-danger">
                <div class="left">
                    <h4>{{$nbAff ?? 0}}</h4>
                    <p>Affaires Conclues</p>
                </div>
                <div class="right"><i class="fa fa-handshake-o"></i></div>
            </div>
        </div>
        @if (Help::optAutorise(['ZZZ'], $us->ID_UTILISATEUR))
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="ui-item bg-dark">
                <div class="left">
                    <h4>{{ Help::formatNombre($chiff->montant ?? '0', false) }}</h4>
                    <p>CA du Jour</p>
                </div>
                <div class="right"><i class="fa fa-credit-card"></i></div>
            </div>
        </div>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="dashboard-list">
                <div class="dashboard-message bdr clearfix">
                    <div class="tab-box-2">
                        <div class="clearfix mb-30 comments-tr">
                            <span>Demandes Client du {{ Help::cDateJour() ?? 'jour' }}</span>
                        </div>
                        @if(count($demandes)>0)
                            @foreach($demandes as $key => $value)
                                <div class="comment d-flex">
                                    <div class="comment-author">
                                        <a href="#">
                                            <img src="{{ asset($value->AVATAR ?? 'assets/img/avatar/avatar-3.png') }}">
                                        </a>
                                    </div>
                                    <div class="comment-content">
                                        <div class="comment-meta">
                                            <h5>{{$value->LIB_CLIENT ?? 'xxxxxx xxxxxx'}}</h5>
                                            @if (Help::optAutorise(['DEM', 'ZZZ'], $us->ID_UTILISATEUR))
                                            <div class="comment-meta">
                                                {{Help::dateheureFormate($value->DATECREA ?? 'MMJJAAAA', '/')}}
                                                <a href="{{route('demandeForm',['idDemand'=>$value->ID_DEMANDE_VISIT])}}">Voir</a>
                                            </div>
                                            @endif
                                        </div>
                                        <p>Souhaite visiter la propriété
                                            <i class="fa fa-angle-double-left"></i>
                                            <b>{{$value->LIB_PROPRIETE ?? 'xxxx xxxxxx'}}</b>
                                            <i class="fa fa-angle-double-right"></i>
                                            à l'adresse <b>{{$value->ADRESSE ?? 'xxxxx xxxxx xxxxx'}}</b>.
                                            {{-- <b style="color: green">Reference: #13054</b> --}}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="comment">
                                <p class="text-center">
                                    <i class="fa fa-angle-double-left"></i>
                                    <b >Aucune demandes reçues.</b>
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
