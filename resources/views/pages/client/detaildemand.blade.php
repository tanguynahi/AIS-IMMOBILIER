@extends('layouts.c_template', ['titre' => $titre])

@section('content')
    @include('partials.client.breadcrumb-navcli', ['LBL' => 'Detail Demande'])
    <div class="submit-address dashboard-list">
        <h4> Detail de la demande n°{{$demande->ID_DEMANDE_VISIT ?? 'xxxxxx'}} </h4>
        <div class="row pad-20">
            <div class="col-lg-6 row">
                <h6><u>Informations sur la Propriété</u></h6>
                <div class="comment">
                    <div class="col-lg-6 mb-20">
                        <img src="{{asset($demande->IMG_DEFAULT ?? 'img/avatar/avatar-1.png')}}" style="height: 100%; width: 100%">
                    </div>
                    <div class="col-lg-12">
                        <div class="comment-meta">
                            <h5>{{$demande->LIB_PROPRIETE ?? 'xxxxx xxxxxxx'}}</h5>
                            <div class="comment-meta">
                                {{$demande->LIB_TYPE ?? 'xxxxxx'}} | {{$demande->LIB_CATEGORIE ?? 'xxxxxx'}}
                            </div>
                        </div>
                        <ul>
                            <li>Adresse :<span> {{$demande->ADRESSE_P ?? 'xxxx, xxxxx, xxxxxx'}}</span></li>
                            <b>{{ Help::formatNombre($demande->PRIX_HT ?? '0', true) }}</b>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h6><u>Informations sur la demande</u></h6>
                <div class="comment">
                    <div class="col-lg-12 mb-10">
                        @if($demande->TYPE_DEMAND==1)
                        <span style="color: black">Date & Heure visite :
                            <b>{{$demande->DATE_VISIT ?? 'JJ/MM/AAAA'}}
                            &nbsp;à {{$demande->HEUR_VISIT ?? 'HH:MM'}}</b>
                        </span>
                        @endif
                    </div>
                    <div class="col-lg-12 mb-10">
                        <span>
                            Type :
                            <b>
                                @switch($demande->TYPE_DEMAND)
                                    @case(1) Visite de propriété @break
                                    @case(2) Information par appel @break
                                    @case(3) Information par email @break
                                    @case(4) Autre @break
                                    @default
                                    non defini
                                @endswitch
                            </b>
                        </span>
                    </div>
                    <span>Etat :
                        <b>
                            @switch($demande->STATUT)
                                @case(Help::$ENATTENTE)
                                <span style="color: blue; font-size:90%">EN ATTENTE</span>
                                @break
                                @case(Help::$REFUSE)
                                <span style="color: red; font-size:90%">REJETEE</span>
                                @break
                                @case(Help::$ACTIF)
                                <span style="color: green; font-size:90%">APPROUVEE</span>
                                @break
                                @default
                                    INACTIF
                            @endswitch
                        </b>
                    </span>
                    <div class="col-lg-12 mb-20">
                        <span>Message/Besoin : <b>{{$demande->MESSAGE ?? 'Aucun message'}}</b></span>
                    </div>
                    @if($demande->STATUT==Help::$REFUSE)
                        <div class="col-lg-12 mb-20">
                            <span>Motifs rejet : <b>{{$demande->MOTIFS ?? 'Aucun motifs'}}</b></span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-12">
                <span>Date demande : {{Help::dateheureFormate($demande->DATECREA ?? 'MMJJAAAA', '/')}} </span>
            </div>
            <h4></h4>
            <div class="col-lg-12">
                <br/>
                <div class="buttons mb-20">
                    <a class="btn-1 btn-gray" type="button" onclick="cancel();">
                        <i class="fa fa-fw fa-times-circle-o"></i> Fermer
                    </a>
                    @if($demande->STATUT == Help::$ENATTENTE)
                        &nbsp;&nbsp;
                        <a class="btn-1 btn-gray" type="button" title="Supprimer"
                            onclick="deleted('{{$demande->ID_DEMANDE_VISIT}}');">
                            <i class="fa fa-fw fa-times-circle-o"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function cancel(id) {
            var rout = "{{route('demClientList')}}"
            window.open(rout, '_self');
        }
        function deleted(params) {
            if (confirm("Voulez-vous supprimer cette demande ?")) {
                var rout = "{{ route('demDesact',['idDemand'=>':idDemand']) }}";
                rout = rout.replace(':idDemand', params)
                window.open(rout, '_self');
            }
        }
    </script>
@endsection
