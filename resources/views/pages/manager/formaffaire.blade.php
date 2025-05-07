@extends('layouts.a_template', ['titre' => $titre])

@section('content')
    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Fiche de Saisie Affaire'])
    <div class="submit-address dashboard-list">
        <form method="post" action="#">
            <h4 class="bg-grea-3"><i class="fa fa-info"></i> Informations de base</h4>
            <div class="search-contents-sidebar">
                <div class="row pad-20">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <input class="form-control" id="param" value="{{$id ?? '0'}}" style="display: none;">
                        <div class="form-group">
                            <label>Client *</label>
                            <select class="form-control" id="client">
                                <option value="0" selected disabled>Choisir client..</option>
                                @foreach ($clients as $c)
                                    <option value="{{$c->ID_CLIENT}}">{{$c->NOM}} {{$c->PRENOMS}} ({{$c->CONTACT}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Propriete *</label>
                            <select class="form-control" id="propriete">
                                <option value="0" selected disabled>Choisir propriete..</option>
                                @foreach ($proprietes as $p)
                                    <option value="{{$p->ID_PROPRIETES}}">
                                        ({{$p->LIB_TYPE}}) {{$p->LIB_PROPRIETE}} | {{$p->LIB_CATEGORIE}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="montant" class="form-label">Montant Propriété *</label>
                            <input type="number" class="form-control" id="montant" readonly>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="apayer" class="form-label">Total à Payer </label>
                            <input type="number" class="form-control" id="apayer">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="date" class="form-label">Date affaire</label>
                            <input type="date" class="form-control" id="date">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group message">
                            <label for="desc" class="form-label">Commentaire</label>
                            <textarea class="form-control" id="desc" rows="2" placeholder="Saisi ici une description..."></textarea>
                        </div>
                    </div>
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
        ajaxmess.text(""); ajaxmess.css('color', 'red');

        $("#propriete").on('change', function() {
            var id = $("#propriete").val();
            getInfosPropriete(id);
        });

        function getInfosPropriete(id) {
            var url = "{{ route('getPropriete', ['id' => ':id']) }}";
            url = url.replace(":id", id);
            $.ajax({
                type: "get",
                url: url,
                contentType: "application/json",
                success: function(data) {
                    console.log(data);
                    document.getElementById("montant").value = data.PRIX_HT;
                    document.getElementById("apayer").value = data.PRIX_HT;
                }, error: function(data) {
                    console.log(res); ajaxmess.focus();
                    ajaxmess.text('alert: Erreur interne du serveur !');
                }
            });
        }

        function RazChamp() {
            document.getElementById("client").value = "";
            document.getElementById("propriete").value = "";
            document.getElementById("montant").value = "";
            document.getElementById("apayer").value = "";
            document.getElementById("date").value = "";
            document.getElementById("desc").value = "";
        }

        function updatedata(data) {
            document.getElementById("client").value = data.ID_CLIENT;
            document.getElementById("propriete").value = data.ID_PROPRIETES;
            document.getElementById("montant").value = data.MONTANT;
            document.getElementById("desc").value = data.DESCRIPTIF;
            document.getElementById("apayer").value = data.TOTAL_A_PAYER;
            document.getElementById("date").value = data.DATE_CONCLUS;
        }
        function cancel() { rout = "{{route('affaireList')}}"; window.open(rout, '_self'); }

        function savedata(param) {
            ajaxmess.text("");
            ajaxmess.css('color', 'red');
            var id = param;
            var cli = document.getElementById("client").value;
            var prop = document.getElementById("propriete").value;
            var mont = document.getElementById("montant").value;
            var desc = document.getElementById("desc").value;
            var total = document.getElementById("apayer").value;
            var date = document.getElementById("date").value;
            var rout = "{{ route('affaireValid') }}";
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
                    Client: cli,
                    Propriete: prop,
                    Montant: mont,
                    Descrip: desc,
                    Total: total,
                    Date: date,
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

        function majIHM() {
            RazChamp();
            ajaxmess.text("");
            ajaxmess.css('color', 'red');
            var id = document.getElementById("param").value;
            if (id>0) {
                var url = "{{ route('getAffaire', ['id' => ':id']) }}";
                url = url.replace(":id", id);
                $.ajax({
                    type: "get",
                    url: url,
                    contentType: "application/json",
                    success: function(data) {
                        console.log(data);
                        if (data.ID_AFFAIRES>0) {
                            updatedata(data);
                        }else{ alerte('Erreur lors du chargement des données'); }
                    },
                    error: function(err) { console.log(err); alert("Une erreur systeme s'est produite."); }
                });
            }
        }

        majIHM();

    </script>
@endsection
