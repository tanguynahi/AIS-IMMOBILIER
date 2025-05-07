@extends('layouts.a_template', ['titre' => $titre])

@section('content')
    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Detail message'])
    <div class="submit-address dashboard-list">
        <br />
        <a type="button" onclick="cancel();"
            class="mb-10" style="margin-left: 20px">
            <i class="fa fa-angle-double-left"></i>&nbsp;<b>Retour</b>
        </a>
        <h4> <u>Sujet:</u> {{$infosmessage->SUJET ?? 'Aucun'}} </h4>
        <div class="row pad-20">

            <div class="col-lg-6">
                <div class="col-lg-12 mb-10">
                    <div class="comment-meta">
                        <span style="color: black">
                            De : <b>{{$infosmessage->NOM_PRENOMS ?? 'xxxxx xxxxxxx'}}</b>
                        </span>
                    </div>
                </div>
                <div class="col-lg-12 mb-10">
                    <span style="color: black">
                        Adresse : <b>{{$infosmessage->ADRESSE ?? 'xxxx, xxxxx, xxxx'}}</b>
                    </span>
                </div>
                <div class="col-lg-12 mb-10">
                    <span style="color: black;">
                        Date : <b>{{Help::dateheureFormate($infosmessage->DATECREA ?? 'MMJJAAAA', '/')}}</b>
                    </span>
                </div>
                <div class="col-lg-12 mb-10">
                    <span style="color: grey; font-size: 14px">
                        {{ Help::duration($infosmessage->DATECREA) }}
                    </span>
                </div>
            </div>

            <h4></h4>
            <h6><br /><u>Messages</u></h6>
            @if(count($messages)>0)
            <div class="col-lg-12 mb-10">
                <span style="color: black">
                    $discutions
                    {{$infosmessage->MESSAGE ?? ''}}
                </span>
            </div>
            @endif


            <div id="motifChps" style="display: none">
                <br />
                <h4 class="bg-grea-3">Refus Paiement</h4>
                <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
                    <div class="form-group message">
                        <label for="motif" class="form-label">Motifs</label>
                        <textarea class="form-control" id="motif"
                            rows="3" placeholder="Saisi ici le motif du refus..."></textarea>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="buttons mb-20">
                        <a class="btn-1 btn-gray" type="button" onclick="actionBars('val',{{$paiement->ID_PAIEMENTS  ?? 0}});">
                            <i class="fa fa-fw fa-check-circle-o"></i> Valider
                        </a>
                        &nbsp;&nbsp;
                        <a class="btn-1 btn-gray" type="button" onclick="actionBars('ini', '0');">
                            <i class="fa fa-fw fa-times-circle-o"></i> Annuler
                        </a>
                    </div>
                </div>
            </div>

            {{-- <div id="majPAY" style="display: none">
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
                    <div class="col-lg-12">
                        <div class="buttons mb-20">
                            <a class="btn-1 btn-gray" type="button" onclick="actionBars('upd', {{$paiement->ID_PAIEMENTS}});">
                                <i class="fa fa-fw fa-check-circle-o"></i> Enregistrer
                            </a>
                            &nbsp;&nbsp;
                            <a class="btn-1 btn-gray" type="button" onclick="actionBars('ini', '0');">
                                <i class="fa fa-fw fa-times-circle-o"></i> Annuler
                            </a>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div id="initChps">
                <h4></h4>
                <div class="col-lg-12">
                    <br />
                    <div class="buttons mb-20">
                        {{-- @if(($paiement->SERVICE_ID==2 || $paiement->SERVICE_ID==3 || $paiement->SERVICE_ID==4) && $paiement->STATUT==3)
                            <a class="btn-1 btn-gray" type="button" onclick="actionBars('rej', 0);">
                                <i class="fa fa-ban fa-times-circle-o"></i> Refuser
                            </a>
                            &nbsp;&nbsp;
                            <a class="btn-1 btn-gray" type="button" onclick="actionBars('sav', '{{$paiement->ID_PAIEMENTS}}');">
                                <i class="fa fa-fw fa-check-circle-o"></i> Approuver
                            </a>
                            &nbsp;&nbsp;
                            <a class="btn-1 btn-gray" type="button" onclick="actionBars('mod', '{{$paiement->ID_PAIEMENTS}}');">
                                <i class="fa fa-fw fa-pencil"></i> Modifier
                            </a>
                            &nbsp;&nbsp;
                        @endif --}}
                        <a class="btn-1 btn-gray" type="button" onclick="cancel();">
                            <i class="fa fa-fw fa-times-circle-o"></i> Fermer
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12"> <div class="text-center" id="outmess"></div> </div>
        </div>
    </div>
@endsection

@section('js')
    <script>

        var ajaxmess = $('#outmess');
        ajaxmess.text(""); ajaxmess.css('color', 'red');

        function cancel() {
            var rout = "{{route('messageList')}}";
            window.open(rout, '_self');
        }

        function actionBars(params, id) {
            switch (params) {
                case 'rej':
                    $('#majPAY').hide('5000');
                    $('#initChps').hide('5000');
                    $('#motifChps').show('5000');
                    document.getElementById("motif").focus();
                    break;

                case 'mod':
                    $('#majPAY').show('5000');
                    $('#initChps').hide('5000');
                    $('#motifChps').hide('5000');
                    document.getElementById("refID").focus();
                    break;

                case 'ini':
                    $('#majPAY').hide('5000');
                    $('#initChps').show('5000');
                    $('#motifChps').hide('5000');
                    break;

                case 'upd':
                    if (confirm("Voulez-vous enregistrer ce paiement ?")) {
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

                case 'val':
                    if (confirm("Voulez-vous refuser ce paiement ?")) {
                        var rout = "{{ route('rejectPaiement') }}";
                        motif = document.getElementById("motif").value;
                        if (motif=='' || motif.length<10) {
                            alert('veuillez indiquer un motif valide !');
                        }else{
                            var csrf = document.querySelector('meta[name="csrf-token"]').content;
                            var csrf_field = '<input type="hidden" name="_token" value=“' + csrf + '”>';
                            $('form').append(csrf_field);
                            $.ajaxSetup({
                                beforeSend: function(xhr, settings) {
                                    if (settings.url.indexOf(document.domain) >= 0) {
                                        xhr.setRequestHeader("X-CSRF-Token", csrf);
                                    }
                                }
                            });
                            $.ajax({
                                type: 'post',
                                url: rout,
                                _token: csrf,
                                data: {
                                    param: id,
                                    motif: motif,
                                },
                                success: function(res) {
                                    console.log(res);
                                    if (res.code != '200') {
                                        alert(res.mess);
                                    }else{ alert('Paiement rejecté'); cancel(); }
                                }, error: function(res) { console.log(res); alert('alert: Erreur interne du serveur !'); }
                            });
                        }
                    }
                break;

                case 'sav':
                    if (confirm("Voulez-vous approuver ce paiement ?")) {
                        var rout = "{{ route('approuvePaiement',['idPaiement'=>':id']) }}";
                        rout = rout.replace(':id', id);
                        $.ajax({
                            type: 'get',
                            url: rout,
                            success: function(res) {
                                console.log(res);
                                if (res.code != '200') {
                                    alert(res.mess);
                                }else{ alert('Paiement approuvé'); cancel(); }
                            }, error: function(res) { console.log(res); alert('alert: Erreur interne du serveur !'); }
                        });
                    }
                break;

                default: alert('Action non pris en charge !'); break;
            }
        }

    </script>
@endsection
