@extends('layouts.c_template', ['titre' => $titre])

@section('content')
    @include('partials.client.breadcrumb-navcli', ['LBL' => 'Detail Paiement'])
    <div class="submit-address dashboard-list">
        <br />
        <a type="button" onclick="cancel();"
            class="mb-10" style="margin-left: 20px">
            <i class="fa fa-angle-double-left"></i>&nbsp;<b>Retour</b>
        </a>
        <h4> Reférence paiement n° {{$paiement->REFERENCE_P ?? 'xxxxxx'}} </h4>
        <div class="row pad-20">

            <div class="col-lg-6">
                <h6><u>Informations sur la Propriété</u></h6>
                <div class="col-lg-12 mb-10">
                    <div class="comment-meta">
                        <h5>{{$affaire->LIB_PROPRIETE ?? 'xxxxx xxxxxxx'}}</h5>
                        <div class="comment-meta">
                            {{$affaire->LIB_TYPE ?? 'xxxxxx'}} | {{$affaire->LIB_CATEGORIE ?? 'xxxxxx'}}
                        </div>
                    </div>
                    <ul>
                        <li>Adresse :<span> {{$affaire->ADRESSE ?? 'xxxx, xxxxx, xxxxxx'}}</span></li>
                        {{-- <li>Montant :<span><b> {{ Help::formatNombre($affaire->MONTANT ?? '0', true) }}</b></span></li> --}}
                    </ul>
                </div>
            </div>

            <div class="col-lg-6">
                <h6><u>Informations sur l'affaire</u></h6>
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
            </div>
            <div class="col-lg-12 mb-10">
                <span>Commentaire : <br /><b>{{$affaire->DESCRIPTIF ?? 'Aucun commentaire'}}</b></span>
            </div>

            <h4></h4>
            <h6><br /><u>Redevance du paiement</u></h6>
            <div class="col-lg-12 row">
                <div class="col-lg-3 mb-10">
                    <span style="color: black">
                        Designation : <b>{{$liaison->LIB_REDEVANCES ?? 'xxxxxxxxxx'}}</b>
                    </span>
                </div>
                <div class="col-lg-3 mb-10">
                    <span style="color: black">
                        Type : <b>{{$liaison->LIB_PERIODE ?? 'xxxxxxxxxx'}}</b>
                    </span>
                </div>
                <div class="col-lg-3 mb-10">
                    <span style="color: black">
                        Total à Payer : <b>{{ Help::formatNombre($liaison->TOTAL_A_PAYER ?? '0', true) }}</b>
                    </span>
                </div>
                <div class="col-lg-3 mb-10">
                    <span>Reste à Payer : <b>{{ Help::formatNombre($liaison->REST_A_PAYER ?? '0', true) }}</b></span>
                </div>
            </div>

            <h4></h4>
            <h6><br /><u>Paiement</u></h6>
            <div class="col-lg-12 row">
                <div class="col-lg-3 mb-10">
                    <span style="color: black">
                        Reférence : <b>{{$paiement->REFERENCE_P ?? 'xxxxxxxxxx'}}</b>
                    </span>
                </div>
                <div class="col-lg-3 mb-10">
                    <span style="color: black">
                        Montant : <b>{{ Help::formatNombre($paiement->MONTANT ?? '0', true) }}</b>
                    </span>
                </div>
                <div class="col-lg-3 mb-10">
                    <span style="color: black">
                        Date & Heure : <b>{{ $paiement->DATE_PAIEMENT ?? 'YYYY/MM/JJ'}} {{$paiement->HEURE_PAIEMENT ?? 'HH:MM'}}</b>
                    </span>
                </div>
                <div class="col-lg-3 mb-10">
                    <span>Moyen : <b>{{$paiement->LIB_SERVICE_ID ?? 'xxxxxxxxxx'}}</b></span>
                </div>
                <div class="col-lg-3 mb-10">
                    <span>Numero trans.: <b>{{$paiement->NO_TRANSACTION ?? 'xxxxxxxxxx'}}</b></span>
                </div>
                <div class="col-lg-9 mb-10">
                    <span>Etat :
                        @switch($paiement->STATUT)
                        @case("1")
                            @if($paiement->SERVICE_ID>4)
                            <b><span style="color: blue; font-size:90%">EN ATTENTE</span></b>
                            @else
                            <b><span style="color: green; font-size:90%">VALIDE</span></b>
                            @endif
                        @break
                        @case("2")
                            @if($paiement->SERVICE_ID>4)
                            <b><span style="color: green; font-size:90%">VALIDE</span></b>
                            @else
                            <b><span style="color: red; font-size:90%">ERREUR</span></b>
                            @endif
                        @break
                        @case("3")
                            @if($paiement->SERVICE_ID==2 || $paiement->SERVICE_ID==3 || $paiement->SERVICE_ID==4)
                            <b><span style="color: blue; font-size:90%">EN ATTENTE</span></b>
                            @else
                            <b><span style="color: blue; font-size:90%">ANNULE</span></b>
                        @endif
                        @break
                        @case("4")
                            @if($paiement->SERVICE_ID==2 || $paiement->SERVICE_ID==3 || $paiement->SERVICE_ID==4)
                            <b><span style="color: red; font-size:90%">REJETE</span></b>
                            @else
                            <b><span style="color: red; font-size:90%">ECHEC</span></b>
                            @endif
                        @break
                        @default
                            <b><span style="color: blue; font-size:90%">NON DEFINI</span></b>
                        @endswitch
                    </span>
                </div>
            </div>

            <div id="majPAY" style="display: none">
                <br />
                <h4 class="bg-grea-3"><i class="fa fa-info"></i>&nbsp;Modification Paiement</h4>
                <div class="search-contents-sidebar">
                    <div class="row pad-20">
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <input id="urlback" value="{{$back ?? 'paiemL'}}" style="display: none;">
                            <input id="param" value="{{$affaire->ID_AFFAIRES ?? ''}}" style="display: none;">
                            <div class="form-group">
                                <label>Reférence *</label>
                                <input type="text" class="form-control" value="{{$paiement->REFERENCE_P}}"
                                onKeyPress="if(this.value.length==20) return false;" id="refID">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Date *</label>
                                <input type="date" class="form-control" id="date" value="{{$paiement->DATE_PAIEMENT}}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Heure *</label>
                                <input type="time" class="form-control" id="heure" value="{{$paiement->HEURE_PAIEMENT}}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <div class="form-group">
                                <label>Montant *</label>
                                <input type="number" class="form-control" id="mont" value="{{$paiement->MONTANT}}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <div class="form-group">
                                <label>Moyen paiement *</label>
                                <select class="form-control" id="moyen">
                                    <option value="0" selected disabled>Choisir un moyen..</option>
                                    <option value="2" {{ $paiement->SERVICE_ID === "2" ? 'selected' : ''}}>Cash </option>
                                    <option value="3" {{ $paiement->SERVICE_ID === "3" ? 'selected' : ''}}>Chèque </option>
                                    <option value="4" {{ $paiement->SERVICE_ID === "4" ? 'selected' : ''}}>Virement </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-center" id="outmess"></div>
                    <div class="col-lg-12">
                        <div class="buttons mb-20">
                            <a class="btn-1 btn-gray" type="button" onclick="actionBars('val', {{$paiement->ID_PAIEMENTS}});">
                                <i class="fa fa-fw fa-check-circle-o"></i> Valider
                            </a>
                            &nbsp;&nbsp;
                            <a class="btn-1 btn-gray" type="button" onclick="actionBars('ini', '0');">
                                <i class="fa fa-fw fa-times-circle-o"></i> Annuler
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="initChps">
                <h4></h4>
                <div class="col-lg-12">
                    <br />
                    <div class="buttons mb-20">
                        @if(($paiement->SERVICE_ID==2 || $paiement->SERVICE_ID==3 || $paiement->SERVICE_ID==4) && $paiement->STATUT==3)
                            <a class="btn-1 btn-gray" type="button" onclick="actionBars('mod', 0);">
                                <i class="fa fa-pencil"></i> Modifier
                            </a>
                            &nbsp;&nbsp;
                            <a class="btn-1 btn-gray" type="button" onclick="deleted('{{$paiement->ID_PAIEMENTS}}');">
                                <i class="fa fa-ban fa-times-circle-o"></i> Supprimer
                            </a>
                            &nbsp;&nbsp;
                        @endif
                        <a class="btn-1 btn-gray" type="button" onclick="cancel('{{$affaire->ID_AFFAIRES}}');">
                            <i class="fa fa-fw fa-times-circle-o"></i> Fermer
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script>

        var ajaxmess = $('#outmess');
        ajaxmess.text(""); ajaxmess.css('color', 'red');

        function cancel() {
            var rout = "{{route('paiemClientList')}}";
            id = document.getElementById("param").value;
            cle = document.getElementById("urlback").value;
            if (cle!='paiemL'){
                rout = "{{route('paiementAffList',['idAffaire'=>':idAffaire'])}}";
                rout = rout.replace(':idAffaire', id);
            }
            window.open(rout, '_self');
        }

        function actionBars(params, id) {
            switch (params) {
                case 'mod':
                    $('#majPAY').show('5000');
                    $('#initChps').hide('5000');
                    document.getElementById("refID").focus();
                    break;

                case 'ini':
                    $('#majPAY').hide('5000');
                    $('#initChps').show('5000');
                    break;

                case 'val':
                    if (confirm("Voulez-vous enregistrer cet paiement ?")) {
                        ajaxmess.text("");
                        ajaxmess.css('color', 'red');
                        var param = id;
                        var ref = document.getElementById("refID").value;
                        var dat = document.getElementById("date").value;
                        var heur = document.getElementById("heure").value;
                        var mont = document.getElementById("mont").value;
                        var moy = document.getElementById("moyen").value;
                        var rout = "{{ route('paiementUpdate') }}";
                        var csrf = document.querySelector('meta[name="csrf-token"]').content;
                        var csrf_field = '<input type="hidden" name="_token" value=“'+csrf+'”>';
                        $('form').append(csrf_field);
                        $.ajaxSetup({
                            beforeSend: function (xhr, settings) {
                            if (settings.url.indexOf(document.domain) >= 0) {xhr.setRequestHeader("X-CSRF-Token", csrf);} }
                        });
                        $.ajax({
                            type: 'post',
                            url: rout,
                            _token: csrf,
                            data: {
                                id: param,
                                refID: ref,
                                date: dat,
                                heure: heur,
                                mont: mont,
                                moyen: moy,
                            },
                            success: function(res) {
                                console.log(res);
                                if (res.code != '200') {
                                    ajaxmess.focus();
                                    ajaxmess.text(res.mess);
                                }else{
                                    ajaxmess.text(res.mess);
                                    ajaxmess.css('color', 'green');
                                    setTimeout(cancel, 500);
                                }
                            },
                            error: function(res) {
                                console.log(res); ajaxmess.focus();
                                ajaxmess.text('alert: Erreur interne du serveur !');
                            }
                        });
                    }
                break;

                default: alert('Action non pris en charge !'); break;
            }
        }

        function deleted(params) {
            if (confirm("Voulez-vous supprimer cet paiement ?")) {
                var rout = "{{ route('paiementDesact',['idPaiement'=>':idPaiement']) }}";
                rout = rout.replace(':idPaiement', params)
                window.open(rout, '_self');
            }
        }

    </script>
@endsection
