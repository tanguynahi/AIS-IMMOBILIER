@extends('layouts.c_template', ['titre' => $titre])

@section('content')
    @include('partials.client.breadcrumb-navcli', ['LBL' => 'Detail Demande'])
    <div class="submit-address dashboard-list">
        <h4> Detail de la demande n°{{$demande->ID_DEMANDE_VISIT ?? 'xxxxxx'}} </h4>
        <div class="row pad-20">
            <div class="col-lg-6 row">
                <h6><u>Informations sur la Propriété</u></h6>
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
                <div class="comment"></div>
            </div>
            <div class="col-lg-6">
                <h6><u>Informations sur la demande</u></h6>
                <div class="">
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-10">
                        <div class="form-group" style="text-align: left">
                            <label for="label-control">Type demande</label>
                            <select class="form-control" id="typeD">
                                <option value="0" selected disabled>Choisir type..</option>
                                <option value="1" @if($demande->TYPE_DEMAND==1) selected @endif>Visite de propriété</option>
                                <option value="2" @if($demande->TYPE_DEMAND==2) selected @endif>Besion d'information par appel</option>
                                <option value="3" @if($demande->TYPE_DEMAND==3) selected @endif>Besion d'information par email</option>
                                <option value="4" @if($demande->TYPE_DEMAND==4) selected @endif>Autre</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-10 row" id="periodChps" @if($demande->TYPE_DEMAND!=1) style="display: none;" @endif>
                        <div class="col-lg-6" >
                            <span style="color: black">Date visite : </span>
                            <input type="date" name="name" class="form-control text-center"
                            id="date" value="{{$demande->DATE_VISIT ?? ''}}">
                        </div>
                        <div class="col-lg-6 mb-10">
                            <span style="color: black">Heure visite : </span>
                            <input type="time" name="name" class="form-control text-center"
                            id="heure" value="{{$demande->HEUR_VISIT ?? ''}}">
                        </div>
                    </div>
                    <div class="form-group message">
                        <label for="motif" class="form-label">Message</label>
                        <textarea class="form-control" id="motif"
                        rows="3" placeholder="Saisi ici votre message/besoin pour la demande...">{{$demande->MESSAGE}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <span>Date demande : {{Help::dateheureFormate($demande->DATECREA ?? 'MMJJAAAA', '/')}} </span>
            </div>
            <h4></h4>
            <div class="col-lg-12">
                <br />
                <div class="buttons mb-20">
                    <a class="btn-1 btn-gray" type="button" onclick="actionBars({{$demande->ID_DEMANDE_VISIT}});">
                        <i class="fa fa-fw fa-check-circle-o"></i> Enregistrer
                    </a>
                    &nbsp;&nbsp;
                    <a class="btn-1 btn-gray" type="button" onclick="cancel();">
                        <i class="fa fa-fw fa-times-circle-o"></i> Fermer
                    </a>
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
        function actionBars(id) {
            if (confirm("Voulez-vous enregistrer les informations de cette demande ?")) {
                var rout = "{{ route('demSave') }}";
                var date = document.getElementById("date").value;
                var heur = document.getElementById("heure").value;
                var motif = document.getElementById("motif").value;
                var typdem = document.getElementById("typeD").value;
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
                            date: date,
                            heure: heur,
                            mess: motif,
                            demtype: typdem,
                        },
                        success: function(res) {
                            console.log(res);
                            if (res.code != '200') {
                                alert(res.mess);
                            }else{ alert(res.mess); var rout = "{{route('demClientList')}}"; window.open(rout, '_self'); }
                        }, error: function(res) { console.log(res); alert('alert: Erreur interne du serveur !'); }
                    });
                }
            }
        }
        $("#typeD").on('change', function() {
            var id = $("#typeD").val();
            if (id==1) {
                $("#periodChps").show();
            }else{$("#periodChps").hide();}
        });
    </script>
@endsection
