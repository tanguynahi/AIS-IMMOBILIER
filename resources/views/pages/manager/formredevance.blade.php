@extends('layouts.a_template', ['titre' => $titre])

@section('content')
    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Fiche de Saisie Redevance'])
    <div class="submit-address dashboard-list">
        <form method="post" action="#">
            <h4 class="bg-grea-3"><i class="fa fa-info"></i>&nbsp;Informations de base</h4>
            <div class="search-contents-sidebar">
                <div class="row pad-20">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group propertytitle">
                            <label for="libelle" class="form-label">Designation *</label>
                            <input type="text" class="form-control" id="libelle" placeholder="Designation de la redevance">
                            <input class="form-control" id="param" value="{{$id ?? '0'}}" style="display: none;">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>Type *</label>
                            <select class="form-control" id="type">
                                <option value="0" selected disabled>Choisir type..</option>
                                @foreach ($types as $t)
                                    <option value="{{$t->ID_TYPE_PROPRIETE}}">{{$t->LIB_TYPE}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>Periode *</label>
                            <select class="form-control" id="periode">
                                <option value="0" selected disabled>Choisir periode..</option>
                                @foreach ($periodes as $p)
                                    <option value="{{$p->ID_TYPE_PERIODE}}">{{$p->LIB_PERIODE}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group message">
                            <label for="desc" class="form-label">Description</label>
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

        function RazChamp() {
            document.getElementById("libelle").value = "";
            document.getElementById("type").value = "";
            document.getElementById("periode").value = "";
            document.getElementById("desc").value = "";
        }

        function updatedata(data) {
            document.getElementById("libelle").value = data.LIB_REDEVANCES;
            document.getElementById("type").value = data.ID_TYPE_REDEVANCES;
            document.getElementById("periode").value = data.ID_TYPE_PERIODE;
            document.getElementById("desc").value = data.DESCRIPTIF;
        }
        function cancel() { rout = "{{route('redevanceList')}}"; window.open(rout, '_self'); }

        var ajaxmess = $('#output');

        function savedata(param) {
            ajaxmess.text("");
            ajaxmess.css('color', 'red');
            var id = param;
            var lib = document.getElementById("libelle").value;
            var desc = document.getElementById("desc").value;
            var typ = document.getElementById("type").value;
            var period = document.getElementById("periode").value;
            var rout = "{{ route('redevanceValid') }}";
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
                    lib: lib,
                    desc: desc,
                    typ: typ,
                    period: period,
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
                var url = "{{ route('getRedevance', ['id' => ':id']) }}";
                url = url.replace(":id", id);
                $.ajax({
                    type: "get",
                    url: url,
                    contentType: "application/json",
                    success: function(data) {
                        console.log(data);
                        if (data.ID_REDEVANCES>0) {
                            updatedata(data);
                        }else{ alert("Erreur lors du chargement de données"); }
                    },
                    error: function(err) { console.log(err); alert("Une erreur systeme s'est produite."); }
                });
            }
        }

        majIHM();

    </script>
@endsection
