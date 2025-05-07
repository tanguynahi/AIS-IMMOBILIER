@extends('layouts.a_template', ['titre' => $titre])

@section('content')
    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Detail Demande'])
    <div class="submit-address dashboard-list">
        <h4>Detail de la demande n°{{$demande->ID_DEMANDE_VISIT ?? 'xxxxxx'}}</h4>
        <div class="row pad-20">
            <div class="col-lg-6">
                <h6><u>Informations Client</u></h6>
                <div class="comment">
                    <div class="comment-author">
                        <a href="#">
                            <img src="{{asset($demande->AVATAR ?? 'avatar-bg.png')}}">
                        </a>
                    </div>
                    <div class="comment-content">
                        <div class="comment-meta">
                            <h5>{{$demande->LIB_CLIENT ?? 'xxxxx xxxxxxx'}}</h5>
                            <span>{{$demande->ADRESSE ?? 'xxxxx xxxxxxx'}}</span>
                        </div>
                        <ul>
                            <li>Email : <span>
                                <a href="mailto:{{$demande->ADR_EMAIL ?? 'xxxxxxxx'}}">
                                {{$demande->ADR_EMAIL ?? 'xxxxxxxx'}} </a></span>
                            </li>
                            <li>Contact : <span>
                                <a href="tel:{{$demande->CONTACT ?? '+225xxxxxxxxxx'}}">
                                {{$demande->CONTACT ?? '+225xxxxxxxxxx'}}</a></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h6><u>Informations sur la Propriété</u></h6>
                <div class="comment">
                    <div class="comment-author">
                        <a href="#">
                            <img src="{{asset($demande->IMG_DEFAULT ?? 'img/avatar/avatar-1.png')}}">
                        </a>
                    </div>
                    <div class="comment-content">
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
            <div class="col-lg-12 row mb-10">
                <div class="col-lg-3 mb-10">
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
                <div class="col-lg-2 mb-10">
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
                </div>
                <div class="col-lg-7 mb-10">
                    <span>Message/Besoin : <b>{{$demande->MESSAGE ?? 'Aucun message'}}</b></span>
                </div>
            </div>
            @if($demande->STATUT==Help::$REFUSE)
                <div class="col-lg-12 mb-20">
                    <span>Motifs rejet : <b>{{$demande->MOTIFS ?? 'Aucun motifs'}}</b></span>
                </div>
            @endif
            @if($demande->TYPE_DEMAND==1)
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="comment">
                        <span>Date & Heure visite : <b>{{$demande->DATE_VISIT ?? 'JJ/MM/AAAA'}}
                        &nbsp;à {{$demande->HEUR_VISIT ?? 'HH:MM'}}</b></span>
                    </div>
                </div>
            </div>
            @endif
            <div id="modChps" style="display: none">
                <h4 class="bg-grea-3">Mise à Jour demande</h4>
                <br />
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-12 mb-20" @if($demande->TYPE_DEMAND!=1) style="display: none;" @endif id="dt">
                        <div class="form-group">
                            <label for="date" class="form-label">Date visite *</label>
                            <input type="date" class="form-control" id="date" value="{{$demande->DATE_VISIT ?? ''}}">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 mb-20" @if($demande->TYPE_DEMAND!=1) style="display: none;" @endif id="hr">
                        <div class="form-group">
                            <label for="date" class="form-label">Heure visite</label>
                            <input type="time" class="form-control" id="heure" value="{{$demande->HEUR_VISIT ?? ''}}">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-12 mb-20">
                        <div class="form-group">
                            <label class="form-label">Propriete *</label>
                            <select class="form-control" id="propriete">
                                <option value="0" selected disabled>Choisir propriete..</option>
                                @foreach ($proprietes as $p)
                                    <option value="{{$p->ID_PROPRIETES}}" @if($p->ID_PROPRIETES==$demande->ID_PROPRIETES) selected @endif>
                                        ({{$p->LIB_TYPE}}) {{$p->LIB_PROPRIETE}} | {{$p->LIB_CATEGORIE}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 mb-20">
                        <div class="form-group">
                            <label class="form-label">Type demande *</label>
                            <select class="form-control" id="typeD">
                                <option value="0" selected disabled>Choisir type..</option>
                                <option value="1" @if($demande->TYPE_DEMAND==1) selected @endif>Visite de propriété</option>
                                <option value="2" @if($demande->TYPE_DEMAND==2) selected @endif>Information par appel</option>
                                <option value="3" @if($demande->TYPE_DEMAND==3) selected @endif>Information par email</option>
                                <option value="4" @if($demande->TYPE_DEMAND==4) selected @endif>Autre</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-20" @if ($demande->STATUT!=Help::$REFUSE) style="display: none;" @endif>
                        <div class="form-group message">
                            <label for="motif" class="form-label">Motifs de rejet</label>
                            <textarea class="form-control" id="editmotifrej"
                                rows="3" placeholder="Saisi ici le motif du rejet...">{{$demande->MOTIFS ?? ''}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="buttons mb-20">
                        <a class="btn-1 btn-gray" type="button" onclick="actionBars('vad',{{$demande->ID_DEMANDE_VISIT}});">
                            <i class="fa fa-fw fa-check-circle-o"></i>Valider
                        </a>
                        &nbsp;&nbsp;
                        <a class="btn-1 btn-gray" type="button" onclick="actionBars('ini', '0');">
                            <i class="fa fa-fw fa-times-circle-o"></i>Annuler
                        </a>
                    </div>
                </div>
            </div>
            <div id="motifChps" style="display: none">
                <h4 class="bg-grea-3">Rejet</h4>
                <br />
                <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
                    <div class="form-group message">
                        <label for="motif" class="form-label">Motifs de rejet</label>
                        <textarea class="form-control" id="motif"
                            rows="3" placeholder="Saisi ici le motif du rejet..."></textarea>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="buttons mb-20">
                        <a class="btn-1 btn-gray" type="button" onclick="actionBars('val',{{$demande->ID_DEMANDE_VISIT}});">
                            <i class="fa fa-fw fa-check-circle-o"></i>Valider
                        </a>
                        &nbsp;&nbsp;
                        <a class="btn-1 btn-gray" type="button" onclick="actionBars('ini', '0');">
                            <i class="fa fa-fw fa-times-circle-o"></i>Annuler
                        </a>
                    </div>
                </div>
            </div>
            <div id="initChps">
                <div class="col-lg-12">
                    <div class="buttons mb-20">
                      @if($demande->STATUT != Help::$ACTIF)
                            <a class="btn-1 btn-gray" type="button" onclick="actionBars('mod', 0);">
                                <i class="fa fa-pencil"></i> Modifier
                            </a>
                            &nbsp;&nbsp;
                            <a class="btn-1 btn-gray" type="button" onclick="actionBars('sav', {{$demande->ID_DEMANDE_VISIT}});">
                                <i class="fa fa-fw fa-check-circle-o"></i> Approuver
                            </a>
                        @endif
                        &nbsp;&nbsp;
                        @if($demande->STATUT != Help::$REFUSE)
                        <a class="btn-1 btn-gray" type="button" onclick="actionBars('rej', 0);">
                            <i class="fa fa-ban fa-times-circle-o"></i> Rejeter
                        </a>
                        &nbsp;&nbsp;
                        @endif
                        <a class="btn-1 btn-gray" type="button" onclick="cancel();">
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
        function cancel(id) {
            var rout = "{{route('demVisitList')}}"
            window.open(rout, '_self');
        }
        function actionBars(params, id) {
            switch (params) {
                case 'rej':
                    $('#modChps').hide('5000');
                    $('#initChps').hide('5000');
                    $('#motifChps').show('5000');
                    document.getElementById("motif").focus();
                    break;

                case 'ini':
                    $('#modChps').hide('5000');
                    $('#initChps').show('5000');
                    $('#motifChps').hide('5000');
                    break;

                case 'mod':
                    $('#modChps').show('5000');
                    $('#initChps').hide('5000');
                    $('#motifChps').hide('5000');
                    break;

                case 'val':
                    if (confirm("Voulez-vous rejeter cette demande ?")) {
                        var rout = "{{ route('rejectDemande') }}";
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
                                    }else{
                                        alert('Demande rejectée');
                                        var rout = "{{route('demVisitList')}}";
                                        window.open(rout, '_self');
                                    }
                                }, error: function(res) { console.log(res); alert('alert: Erreur interne du serveur !'); }
                            });
                        }
                    }
                    break;

                case 'vad':
                    if (confirm("Voulez-vous enregistrer ses informations ?")) {
                        var rout = "{{ route('updateDemande') }}";
                        dat = document.getElementById("date").value;
                        heur = document.getElementById("heure").value;
                        propID = document.getElementById("propriete").value;
                        typdem = document.getElementById("typeD").value;
                        motifrej = document.getElementById("editmotifrej").value;
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
                                date: dat,
                                heure: heur,
                                demtype: typdem,
                                property: propID,
                                motif: motifrej,
                            },
                            success: function(res) {
                                console.log(res);
                                if (res.code != '200') {
                                    alert(res.mess);
                                }else{
                                    alert('Enregistré avec succès');
                                    var rout = "{{route('demVisitList')}}";
                                    window.open(rout, '_self');
                                }
                            }, error: function(res) { console.log(res); alert('alert: Erreur interne du serveur !'); }
                        });
                    }
                    break;

                case 'sav':
                    if (confirm("Voulez-vous approuver cette demande ?")) {
                        var rout = "{{ route('approuveDemande',['idDemand'=>':id']) }}";
                        rout = rout.replace(':id', id);
                        $.ajax({
                            type: 'get',
                            url: rout,
                            success: function(res) {
                                console.log(res);
                                if (res.code != '200') {
                                    alert(res.mess);
                                }else{
                                    alert('Demande approuvée');
                                    var rout = "{{route('demVisitList')}}";
                                    window.open(rout, '_self');
                                }
                            }, error: function(res) { console.log(res); alert('alert: Erreur interne du serveur !'); }
                        });
                    }
                    break;

                default:
                    alert('Action non pris en charge !');
                    break;
            }
        }
        $("#typeD").on('change', function() {
            var id = $("#typeD").val();
            if (id==1) { $("#dt").show(); $("#hr").show(); }else{ $("#dt").hide(); $("#hr").hide(); }
        });
    </script>
@endsection
