@extends('layouts.a_template', ['titre' => $titre])

@section('content')
    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Fiche Facturation'])
    <div class="submit-address dashboard-list">
        <form method="post" action="#" id="form-liais">
            <h4 class="bg-grea-3"><i class="fa fa-info"></i>&nbsp;Informations de base</h4>
            <div class="search-contents-sidebar">
                <div class="row pad-20">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <input class="form-control" id="idP" style="display: none;">
                        <input class="form-control" id="param" value="{{$id ?? '0'}}" style="display: none;">
                        <div class="form-group">
                            <label>Client *</label>
                            <select class="form-control" id="clid">
                                <option value="0" selected disabled>Choisir client..</option>
                                @foreach ($clients as $c)
                                    <option value="{{$c->ID_CLIENT}}">{{$c->NOM}} {{$c->PRENOMS}} ({{$c->CONTACT}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>Biens *</label>
                            <select class="form-control" id="aff_id">
                                <option value="" selected disabled>Choisir un bien..</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 row" id="aff_chps" style="display: none;">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="mont_aff" class="form-label">Montant Affaire </label>
                                <input type="number" class="form-control" id="mont_aff" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="date_aff" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date_aff" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>Redevances *</label>
                            <select class="form-control" id="red_id">
                                <option value="0" selected disabled>Choisir redevance..</option>
                                @foreach ($redevances as $r)
                                    <option value="{{$r->ID_REDEVANCES}}">
                                        {{$r->LIB_REDEVANCES}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 row" id="chp_redev" style="display: none;">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="mont_redev" class="form-label">Total à Payer *</label>
                                <input type="number" class="form-control" id="mont_redev">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="period" class="form-label">Periode </label>
                                <input type="text" class="form-control" id="period" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12" id="mont_id" style="display: none;">
                            <div class="form-group">
                                <label for="mont_period" class="form-label">Montant Periodique *</label>
                                <input type="number" class="form-control" id="mont_period">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-12 row" id="date_chps" style="display: none;">
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="form-group">
                                <label for="freq" class="form-label">Frequence *</label>
                                <input type="number" class="form-control" id="freq">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="form-group">
                                <label for="datemin" class="form-label">Date debut *</label>
                                <input type="date" class="form-control" id="datemin">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <div class="form-group">
                                <label for="calc" class="form-label" style="color: white">chgvjhb</label>
                                <a type="button" onclick="calcdate();" class="btn-6">Calculer</a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="datemax" class="form-label">Date fin</label>
                                <input type="date" class="form-control" id="datemax" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="date" class="form-label">Date facturation</label>
                            <input type="date" class="form-control" id="date">
                        </div>
                    </div>
                    <div class="text-center" id="outmess"></div>
                    <div class="text-center" id="output"></div>
                    <div class="row pad-20">
                        <div class="col-12">
                            <button class="btn btn-primary" type="button" onclick="savedata('{{$id ?? 0}}');">
                                <i class="fa fa-fw fa-check-circle-o"></i>Valider
                            </button>
                            <button class="btn btn-outline-secondary" type="button" onclick="cancel();">
                                <i class="fa fa-fw fa-times-circle-o"></i>Annuler
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection

@section('js')

    <script>

        var ajaxmess = $('#output');
        var ajaxhelp = $('#outmess');
        ajaxmess.text(""); ajaxmess.css('color', 'red');
        ajaxhelp.text(""); ajaxhelp.css('color', 'blue');

        $("#clid").on('change', function() {
            var id = $("#clid").val();
            $("#aff_chps").hide('1000');
            $("#chp_redev").hide('1000');
            ajaxhelp.text("");
            ajaxmess.text("");
            getAffairesClient(id, 0);
        });
        function getAffairesClient(id, idAff) {
            var url = "{{ route('getAffaireClient', ['id' => ':id']) }}";
            url = url.replace(":id", id);
            $.ajax({
                type: "get",
                url: url,
                contentType: "application/json",
                success: function(data) {
                    console.log(data);
                    ajaxmess.text('');
                    $('#aff_id').empty();
                    var valeur = `<option value="" selected disabled>Choisir un bien..</option>`;
                    if (data.length > 0) {
                        data.forEach((d) => {
                            valeur += ` <option value="${ d.ID_AFFAIRES }">
                            (${ d.LIB_TYPE }) ${ d.LIB_PROPRIETE } | ${ d.LIB_CATEGORIE }</option>`;
                        });
                    }else{
                        ajaxmess.focus();
                        ajaxmess.text('Aucune affaires conclues trouvées pour cet client !');
                    }
                    $('#aff_id').append(valeur);
                    if (idAff>0) document.getElementById("aff_id").value = idAff;
                }, error: function(data) { console.log(data); $("#output").text('alert: Erreur interne du serveur !'); }
            });
        }


        $("#aff_id").on('change', function() {
            var id = $("#aff_id").val();
            getInfosAffaires(id);
        });
        function getInfosAffaires(id) {
            ajaxmess.text('');
            $("#aff_chps").hide('1000');
            var url = "{{ route('getInfosAffaire', ['id' => ':id']) }}";
            url = url.replace(":id", id);
            $.ajax({
                type: "get",
                url: url,
                contentType: "application/json",
                success: function(data) {
                    console.log(data);
                    if (typeof data.TOTAL_A_PAYER != "undefined") {
                        $("#aff_chps").show('1000');
                        document.getElementById("mont_aff").value = data.TOTAL_A_PAYER;
                        document.getElementById("date_aff").value = data.DATE_CONCLUS;
                    }else{
                        ajaxmess.focus();
                        ajaxmess.text('Echec de recupération des informations du bien !');
                    }
                }, error: function(data) { ajaxmess.focus(); ajaxmess.text('alert: Erreur interne du serveur !'); }
            });
        }


        function RazRedChps() {
            document.getElementById("freq").value = "";
            document.getElementById("mont_period").value = "";
            document.getElementById("period").value = "";
            document.getElementById("datemin").value = "";
            document.getElementById("datemax").value = "";
            document.getElementById("mont_redev").value = "";
        }
        $("#red_id").on('change', function() {
            RazRedChps();
            document.getElementById("mont_period").disabled=false;
            var id = $("#red_id").val();
            getInfosRedevances(id);
        });
        function getInfosRedevances(id) {
            var mess = "";
            ajaxmess.text('');
            $("#date_chps").hide('1000');
            $("#chp_redev").hide('1000');
            var url = "{{ route('getInfosRedevance', ['id' => ':id']) }}";
            url = url.replace(":id", id);
            $.ajax({
                type: "get",
                url: url,
                contentType: "application/json",
                success: function(data) {
                    console.log(data);
                    if (typeof data.ID_REDEVANCES != "undefined") {
                        console.log(data);
                        document.getElementById("period").value = data.LIB_PERIODE;
                        document.getElementById("idP").value = data.ID_TYPE_PERIODE;
                        mess = "NB: Veuillez saisir le montant 'Total à Payer'";
                        switch (data.ID_TYPE_PERIODE) {
                            case 1:
                            case 6:
                                $("#mont_id").hide('1000');
                                $("#date_chps").hide('1000');
                                break;
                            case 2:
                                $("#mont_id").show('1000');
                                $("#date_chps").show('1000');
                                if (mess!='') mess += ", le montant 'journalier' a facturer, la 'fréquence' et la date de debut de paiement.";
                                else mess = "Veuillez saisir le montant 'journalier' a facturer, la 'fréquence' et la date de debut de paiement.";
                                break;
                            case 3:
                                $("#mont_id").show('1000');
                                $("#date_chps").show('1000');
                                if (mess!='') mess += ", le montant 'hebdomadaire' a facturer, la 'fréquence' et la date de debut de paiement.";
                                else mess = "Veuillez saisir le montant 'hebdomadaire' a facturer, la 'fréquence' et la date de debut de paiement.";
                                break;
                            case 4:
                                $("#mont_id").show('1000');
                                $("#date_chps").show('1000');
                                if (mess!='') mess += ", le montant 'mensuelle' a facturer, la 'fréquence' et la date de debut de paiement.";
                                else mess = "Veuillez saisir le montant 'mensuelle' a facturer, la 'fréquence' et la date de debut de paiement.";
                                break;
                            case 5:
                                $("#mont_id").show('1000');
                                $("#date_chps").show('1000');
                                if (mess!='') mess += ", le montant 'annuelle' a facturer, la 'fréquence' et la date de debut de paiement.";
                                else mess = "Veuillez saisir le montant 'annuelle' a facturer, la 'fréquence' et la date de debut de paiement.";
                                break;
                            default:
                                mess = 'Periode non pris en charge !';
                            break;
                        }
                        $("#chp_redev").show('1000');
                        ajaxhelp.focus(); ajaxhelp.text(mess);
                    }else{ ajaxmess.focus(); ajaxmess.text('Echec de recupération des informations du bien !'); }
                }, error: function(data) { ajaxmess.focus(); ajaxmess.text('alert: Erreur interne du serveur !'); }
            });
        }


        function calcdate() {
            var APayer = document.getElementById("mont_redev").value;
            var montP = document.getElementById("mont_period").value;
            var freq = document.getElementById("freq").value;
            var date = document.getElementById("datemin").value;
            var period = document.getElementById("idP").value;
            var rout = "{{ route('dateCalc') }}";
            ajaxmess.text(""); ajaxmess.css('color', 'red');
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
                    TotalAPay: APayer,
                    MontPeriod: montP,
                    Freq: freq,
                    Period: period,
                    datemin: date,
                },
                success: function(res) {
                    console.log(res);
                    if (res.code != '200') {
                        ajaxmess.text(res.mess);
                    }else{ document.getElementById("datemax").value = res.mess; }
                },
                error: function(res) {
                    console.log(res); ajaxmess.focus();
                    ajaxmess.text('alert: Erreur interne du serveur !');
                }
            });
        }
        function cancel() { rout = "{{route('liaisonList')}}"; window.open(rout, '_self'); }


        function savedata(param) {
            ajaxmess.text("");
            ajaxmess.css('color', 'red');
            var id = param;
            var cli = document.getElementById("clid").value;
            var aff = document.getElementById("aff_id").value;
            var red = document.getElementById("red_id").value;
            var apayer = document.getElementById("mont_redev").value;
            var mtper = document.getElementById("mont_period").value;
            var freqce = document.getElementById("freq").value;
            var datdeb = document.getElementById("datemin").value;
            var datfin = document.getElementById("datemax").value;
            var idtyp = document.getElementById("idP").value;
            var date = document.getElementById("date").value;
            var rout = "{{ route('liaisonValid') }}";
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
                    id: id,
                    CliID: cli,
                    AffID: aff,
                    RedID: red,
                    TtlAP: apayer,
                    MtPer: mtper,
                    Freq: freqce,
                    DateMin: datdeb,
                    DateMax: datfin,
                    TypID: idtyp,
                    DateFac: date,
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


        function RazChamp() {
            document.getElementById("idP").value = "";
            document.getElementById("clid").value = "";
            document.getElementById("aff_id").value = "";
            document.getElementById("mont_aff").value = "";
            document.getElementById("date_aff").value = "";
            document.getElementById("red_id").value = "";
            document.getElementById("mont_redev").value = "";
            document.getElementById("period").value = "";
            document.getElementById("mont_period").value = "";
            document.getElementById("freq").value = "";
            document.getElementById("datemin").value = "";
            document.getElementById("datemax").value = "";
            document.getElementById("date").value = "";
        }

        function updatedata(data) {
            document.getElementById("clid").value = data.ID_CLIENT;
            getAffairesClient(data.ID_CLIENT, data.ID_AFFAIRES);
            document.getElementById("aff_id").value = data.ID_AFFAIRES;
            getInfosAffaires(data.ID_AFFAIRES);
            document.getElementById("red_id").value = data.ID_REDEVANCES;
            getInfosRedevances(data.ID_REDEVANCES);
            document.getElementById("freq").value = data.NB_FREQUENCE;
            document.getElementById("mont_redev").value = data.MONTANT_REDEV;
            document.getElementById("mont_period").value = data.MONTANT_PERIOD;
            document.getElementById("datemin").value = data.DATE_DBT_PAY;
            document.getElementById("datemax").value = data.DATE_FIN_PAY;
            document.getElementById("date").value = data.DATE_LIAIS;
        }
        function majIHM() {
            RazChamp();
            ajaxmess.text("");
            ajaxmess.css('color', 'red');
            var id = document.getElementById("param").value;
            if (id>0) {
                var url = "{{ route('getLiaison', ['id' => ':id']) }}";
                url = url.replace(":id", id);
                $.ajax({
                    type: "get",
                    url: url,
                    contentType: "application/json",
                    success: function(data) {
                        console.log(data);
                        if (typeof data.ID_LIAIS != "undefined") {
                            updatedata(data);
                        }else{ alerte('Erreur lors du chargement des données'); }
                    }, error: function(err) { console.log(err); alert("Une erreur systeme s'est produite."); }
                });
            }
        }

        majIHM();

    </script>
@endsection
