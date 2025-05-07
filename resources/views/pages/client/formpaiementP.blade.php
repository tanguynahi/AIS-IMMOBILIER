@extends('layouts.c_template', ['titre' => $titre])

@section('content')
    @include('partials.client.breadcrumb-navcli', ['LBL' => 'Fiche Paiement'])

    @if ($message = Session::get('success'))
    <div class="alert alert-2 alert-success alert-dismissible fade show" role="alert">
        <strong>{{ $message }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if ($message = Session::get('error'))
    <div class="alert alert-2 alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ $message }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="submit-address dashboard-list">
        <br />
        <a type="button" onclick="cancel('{{$affaire->ID_AFFAIRES}}');" class="mb-10" style="margin-left: 20px">
            <i class="fa fa-angle-double-left"></i>&nbsp;<b>Retour</b>
        </a>
        <form method="post" action="{{route('paiementSave')}}" enctype="multipart/form-data">
            @csrf
            <h4 class="bg-grea-3"><i class="fa fa-info"></i>&nbsp;Informations de base</h4>
            <div class="search-contents-sidebar">
                <div class="row pad-20">
                    <div class="col-lg-8 col-md-8 col-sm-12">
                        <div class="form-group">
                            <label>Propriété </label>
                            @php
                                $lib = '('.$affaire->LIB_TYPE.') '.$affaire->LIB_CATEGORIE.' '.$affaire->LIB_PROPRIETE. ' | '.
                                $affaire->ADRESSE;
                            @endphp
                            <input class="form-control" value="{{$lib ?? ''}}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="mont_aff" class="form-label">Montant Affaire </label>
                            <input class="form-control" value="{{Help::formatNombre($affaire->TOTAL_A_PAYER ?? '0', true)}}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="date_aff" class="form-label">Date </label>
                            <input class="form-control" type="date" value="{{$affaire->DATE_CONCLUS ?? 'AAAA-MM-JJ'}}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-12">
                        <div class="form-group">
                            <label>Redevances </label>
                            <input class="form-control" value="{{$liaison->LIB_REDEVANCES ?? ''}}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="mont_redev" class="form-label">Total à Payer </label>
                            <input class="form-control"
                            value="{{ Help::formatNombre($liaison->TOTAL_A_PAYER ?? '0', true) }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="period" class="form-label">Periode </label>
                            <input class="form-control" value="{{ $liaison->LIB_PERIODE ?? '' }}" readonly>
                        </div>
                    </div>
                    @if($liaison->ID_TYPE_PERIODE!=1 && $liaison->ID_TYPE_PERIODE!=6)
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="mont_period" class="form-label">Montant Periodique </label>
                            <input type="number" class="form-control"
                            value="{{ Help::formatNombre($liaison->MONTANT_PERIOD ?? '', true) }}" readonly>
                        </div>
                    </div>
                    @else
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="date" class="form-label">Date facturation</label>
                            <input type="date" class="form-control" value="{{ $liaison->DATE_LIAIS ?? '' }}" readonly>
                        </div>
                    </div>
                    @endif
                    @if($liaison->ID_TYPE_PERIODE!=1 && $liaison->ID_TYPE_PERIODE!=6)
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="freq" class="form-label">Frequence </label>
                            <input type="number" class="form-control" value="{{ $liaison->NB_FREQUENCE ?? '' }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="datemin" class="form-label">Date debut *</label>
                            <input type="date" class="form-control" value="{{ $liaison->DATE_DBT_PAY ?? '' }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="datemax" class="form-label">Date fin</label>
                            <input type="date" class="form-control" value="{{ $liaison->DATE_FIN_PAY ?? '' }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="date" class="form-label">Date facturation</label>
                            <input type="date" class="form-control" value="{{ $liaison->DATE_LIAIS ?? '' }}" readonly>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <h4 class="bg-grea-3"><i class="fa fa-info"></i>&nbsp;Informations Paiement</h4>
            <div class="search-contents-sidebar">
                <div class="row pad-20">
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <input class="form-control" name="id" value="{{$liaison->ID_LIAIS ?? ''}}" style="display: none;">
                        <div class="form-group">
                            <label>Reférence *</label>
                            <input type="text" class="form-control"
                            onKeyPress="if(this.value.length==20) return false;" name="refID">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label>Date *</label>
                            <input type="date" class="form-control" name="date">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label>Heure *</label>
                            <input type="time" class="form-control" name="heure">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>Montant *</label>
                            <input type="number" class="form-control" name="mont">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>Moyen paiement *</label>
                            <select class="form-control" name="moyen">
                                <option value="0" selected disabled>Choisir un moyen..</option>
                                <option value="2">Cash</option>
                                <option value="3">Chèque</option>
                                <option value="4">Virement</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <label class="form-label">Document de paiement</label>
                        <input type="file" name="preuves[]" multiple id="file-selector" accept=".jpg, .png, .jpeg"
                        class="form-control" placeholder="Choisir fichier">
                        <p id="status"></p>
                        <img id="output" style="height: 50%; width: 50%; display: none">
                    </div>
                </div>
                <div class="text-center" id="outmess"></div>
                <div class="row pad-20">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <button type="submit" class="btn-6">Enregistrer </button>
                        <a type="button" onclick="cancel('{{$affaire->ID_AFFAIRES}}');"
                        class="btn btn-outline-dark" style="margin-left: 20px">Annuler</a>
                    </div>
                </div>

            </div>
        </form>
    </div>
    
@endsection

@section('js')

    <script>

        var ajaxmess = $('#outmess');
        ajaxmess.text(""); ajaxmess.css('color', 'red');

        function cancel(id) {
            rout = "{{route('paiementAffList',['idAffaire'=>':idAffaire'])}}";
            rout = rout.replace(':idAffaire', id)
            window.open(rout, '_self');
        }

        /*function savedata(param) {
            ajaxmess.text("");
            ajaxmess.css('color', 'red');
            var id = param;
            var ref = document.getElementById("refID").value;
            var dat = document.getElementById("date").value;
            var mont = document.getElementById("mont").value;
            var moy = document.getElementById("moyen").value;
            var preuv = document.getElementById("file-selector").value;
            var rout = "{{ route('paiementSave') }}";
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
                    Ref: ref,
                    Date: dat,
                    Moyen: moy,
                    Amount: mont,
                    File: preuv,
                },
                success: function(res) {
                    console.log(res);
                    if (res.code != '200') {
                        ajaxmess.focus();
                        ajaxmess.text(res.mess);
                    }else{
                        ajaxmess.text(res.mess);
                        ajaxmess.css('color', 'green');
                        // setTimeout(cancel, 500);
                    }
                },
                error: function(res) {
                    console.log(res); ajaxmess.focus();
                    ajaxmess.text('alert: Erreur interne du serveur !');
                }
            });
        }*/

        const status = document.getElementById('status');
        const output = document.getElementById('output');
        if (window.FileList && window.File && window.FileReader) {
            document.getElementById('file-selector').addEventListener('change', event => {
                output.src = '';
                status.textContent = '';
                const file = event.target.files[0];
                if (file == undefined) {
                    $("#output").hide();
                } else {
                    if (!file.type) {
                        status.textContent =
                            'Error: La preuve de paiement File.type ne semble pas être prise en charge sur ce navigateur.';
                        return;
                    }
                    if (!file.type.match('image.*')) {
                        status.textContent = 'Error: Le fichier sélectionné ne semble pas être une image.'
                        return;
                    }
                    const reader = new FileReader();
                    reader.addEventListener('load', event => {
                        output.src = event.target.result;
                        $("#output").show();
                    });
                    reader.readAsDataURL(file);
                }
            });
        }

    </script>

@endsection
