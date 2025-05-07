@extends('layouts.c_template', ['titre' => $titre])

@section('content')
    @include('partials.client.breadcrumb-navcli', ['LBL' => 'Paiements'])
    <div class="submit-address dashboard-list">
        <br />
        <a type="button" onclick="cancel();" class="mb-10" style="margin-left: 20px">
            <i class="fa fa-angle-double-left"></i>&nbsp;<b>Retour</b>
        </a>
        <h4>Detail paiement de la propriété {{$affaire->LIB_CATEGORIE ?? ''}} | {{$affaire->LIB_PROPRIETE ?? ''}}</h4>
        <div class="row pad-20">
            <div class="col-lg-12">
                <div class="invoice">
                    <div class="row">
                        <div class="col-lg-12">
                            <h6><u>Redevances à payer</u></h6>
                            <div class="table-box mb-20">
                                @if(count($liaisons)>0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead style="background-color: #EAEDED;">
                                                <tr>
                                                    <th scope="col">N°</th>
                                                    <th scope="col">Redevance</th>
                                                    <th scope="col">Total à Payer</th>
                                                    <th scope="col">Total Payé</th>
                                                    <th scope="col">Reste à Payer</th>
                                                    {{-- <th scope="col">Nouveau Paiement</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php (int) $n = 0; @endphp
                                                @foreach($liaisons as $key => $value)
                                                    @php (int) $n++; @endphp
                                                    <tr>
                                                        <th scope="row">{{$n ?? '?'}}</th>
                                                        <td>{{$value->LIB_REDEVANCES ?? 'xxxxxx'}}</td>
                                                        <td>{{ Help::formatNombre($value->TOTAL_A_PAYER ?? '0', true) }}</td>
                                                        <td>{{ Help::formatNombre($value->TOTAL_PAYER ?? '0', true) }}</td>
                                                        <td>{{ Help::formatNombre($value->REST_A_PAYER ?? '0', true) }}</td>
                                                        <td>
                                                            @if($value->REST_A_PAYER > 0)
                                                                <a href="{{route('nouvPaiement',['id'=>$value->ID_LIAIS])}}"
                                                                class="btn btn-outline-primary">Payer </a>
                                                            @else
                                                                <a class="btn btn-success disabled" >A Jour </a>
                                                            @endif
                                                        </td>
                                                        {{-- <td class="text-center">
                                                            @if($value->REST_A_PAYER!=0)
                                                                <div class="buttons">
                                                                    <a type="button"
                                                                        onclick="PAYredev('manu', {{$idAffaire ?? '0'}}, {{$value->ID_LIAIS ?? '0'}});"
                                                                        class="btn btn-outline-primary" title="Paiement manuel">Manuel
                                                                    </a>
                                                                    &nbsp;&nbsp;
                                                                    <a type="button"
                                                                        onclick="PAYredev('auto', {{$idAffaire ?? '0'}}, {{$value->ID_LIAIS ?? '0'}});"
                                                                        class="btn btn-outline-primary" title="Payer en ligne">En ligne
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </td> --}}
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-left">
                                        <i class="fa fa-angle-double-left"></i>
                                        <b >Aucune facturation trouvés.</b>
                                        <i class="fa fa-angle-double-right"></i>
                                    </p>
                                @endif
                            </div>
                        </div>
                        <h4></h4>
                        <div class="col-md-12">
                            <br />
                            <h6><u>Paiements éffectués pour ce bien</u></h6>
                            @if(count($paiements)>0)
                                <div class="table-responsive">
                                    <table class="table table-condensed">
                                        <thead class="bg-active-2">
                                            <tr>
                                                <td><strong>Redevance</strong></td>
                                                <td><strong>Reference</strong></td>
                                                <td><strong>Moyen</strong></td>
                                                <td><strong>Montant</strong></td>
                                                <td><strong>Date & Heure</strong></td>
                                                <td><strong>Statut</strong></td>
                                                <td><strong>Actions</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($paiements as $key => $value)
                                                <tr>
                                                    <td>{{$value->LIB_REDEVANCES ?? 'xxxxxx'}}</td>
                                                    <td>{{$value->REFERENCE_P ?? 'xxxxxx'}}</td>
                                                    <td>{{$value->LIB_SERVICE_ID ?? 'xxxxxx'}}</td>
                                                    <td><b>{{ Help::formatNombre($value->MONTANT ?? '0', true) }}</b></td>
                                                    <td>{{$value->DATE_PAIEMENT ?? 'JJ/MM/AAAA'}}
                                                        {{$value->HEURE_PAIEMENT ?? 'HH:MM'}}
                                                    </td>
                                                    <td class="text-center">
                                                        @switch($value->STATUT)
                                                            @case("1")
                                                                @if($value->SERVICE_ID>4)
                                                                <b><span style="color: blue; font-size:90%">EN ATTENTE</span></b>
                                                                @else
                                                                <b><span style="color: green; font-size:90%">VALIDE</span></b>
                                                                @endif
                                                            @break
                                                            @case("2")
                                                                @if($value->SERVICE_ID>4)
                                                                <b><span style="color: green; font-size:90%">VALIDE</span></b>
                                                                @else
                                                                <b><span style="color: red; font-size:90%">ERREUR</span></b>
                                                                @endif
                                                            @break
                                                            @case("3")
                                                                @if($value->SERVICE_ID==2 || $value->SERVICE_ID==3 || $value->SERVICE_ID==4)
                                                                <b><span style="color: blue; font-size:90%">EN ATTENTE</span></b>
                                                                @else
                                                                <b><span style="color: blue; font-size:90%">ANNULE</span></b>
                                                                @endif
                                                            @break
                                                            @case("4")
                                                                @if($value->SERVICE_ID==2 || $value->SERVICE_ID==3 || $value->SERVICE_ID==4)
                                                                <b><span style="color: red; font-size:90%">REJETE</span></b>
                                                                @else
                                                                <b><span style="color: red; font-size:90%">ECHEC</span></b>
                                                                @endif
                                                            @break
                                                            @default
                                                            <b><span style="color: blue; font-size:90%">NON DEFINI</span></b>
                                                        @endswitch
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="buttons">
                                                            <a href="{{route('paiemCliForm', ['idPaiement'=>$value->ID_PAIEMENTS, 'back'=>'affPAY'])}}"
                                                                class="btn-1 btn-gray" title="Detail">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            @if($value->SERVICE_ID==2 || $value->SERVICE_ID==3 || $value->SERVICE_ID==4)
                                                                &nbsp;&nbsp;
                                                                <a href="{{route('filePaiementList', ['idPaiement'=>$value->ID_PAIEMENTS ?? '0', 'back'=>'affPAY'])}}"
                                                                    title="Document(s) paiement">
                                                                    <i class="fa fa-image"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{-- Legende etat paiement --}}
                                <div class="col-lg-12 row" hidden>
                                    <span>
                                        <div style="width:20px; height:20px; background: blue;"></div>
                                    </span>
                                    <span style="color: black; font-size:90%">En attente de validation</span>
                                </div>
                            @else
                                <p class="text-center">
                                    <i class="fa fa-angle-double-left"></i>
                                    <b>Aucun paiement trouvés.</b>
                                    <i class="fa fa-angle-double-right"></i>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>

    function cancel() {
        rout = "{{route('proprieteGet')}}";
        window.open(rout, '_self');
    }
    function PAYredev(TYPE, AFFID, LIAISID) {
        rout = "{{route('paiementForm',['type'=>':type', 'idAffaire'=>':idAffaire', 'idLiais'=>':idLiais'])}}";
        rout = rout.replace(':type', TYPE);
        rout = rout.replace(':idAffaire', AFFID);
        rout = rout.replace(':idLiais', LIAISID);
        window.open(rout, '_self');
    }

</script>
@endsection
