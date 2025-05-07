@extends('layouts.a_template', ['titre' => $titre])

@section('content')
    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Fiche de Saisie Proprieté'])
    <div class="alert alert-2 alert-warning alert-dismissible fade show" role="alert" id="sv-mess" style="display: none">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="submit-address dashboard-list">
        <br />
        <a type="button" onclick="cancel();" class="mb-10" style="margin-left: 20px">
            <i class="fa fa-angle-double-left"></i>&nbsp;<b>Retour</b>
        </a>
        <form method="post" action="#">
            <h4 class="bg-grea-3"><i class="fa fa-info"></i> Informations de base</h4>
            <div class="search-contents-sidebar">
                <div class="row pad-20">
                    <input type="text" id="IDProprietes" value="{{$id ?? 0}}" hidden disabled/>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group propertytitle">
                            <label for="LibellePropriete" class="form-label">Titre annonce *</label>
                            <input type="text" class="form-control" id="LibellePropriete" placeholder="Designation de la Proprité">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>Type *</label>
                            <select class="form-control" id="TypePropriete">
                                <option value="" selected disabled>Choisir type..</option>
                                @foreach ($types as $v)
                                    <option value="{{$v->ID_TYPE_PROPRIETE}}">{{$v->LIB_TYPE}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group price">
                            <label for="PrixHT" class="form-label">Prix *</label>
                            <input type="number" class="form-control" id="PrixHT" placeholder="Prix">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>Categorie *</label>
                            <select class="form-control" id="IDCategories">
                                <option value="" selected disabled>Choisir categorie..</option>
                                @foreach ($categories as $v)
                                    <option value="{{ $v->ID_CATEGORIES }}">{{ $v->LIB_CATEGORIE }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group area">
                            <label for="Superficie" class="form-label">Superficie (m²) *</label>
                            <input type="text" class="form-control" id="Superficie" placeholder="Superficie">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12" id="nb_piece">
                        <div class="form-group">
                            <label>Nombre de Pièces </label>
                            <select class="form-control" id="NbPieces">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="checkbox checkbox-theme checkbox-circle">
                            <input id="bNouveaute" type="checkbox">
                            <label for="bNouveaute">Marquer Nouveauté</label>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <div class="checkbox checkbox-theme checkbox-circle">
                            <input id="bEnPromotion" type="checkbox">
                            <label for="bEnPromotion">En Promotion </label>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12" id="saisiPourcentage" style="display: none;">
                        <div class="form-group area">
                            <input type="number" class="form-control" id="Pourcentage" placeholder="Pourcentage">
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="bg-grea-3"><i class="fa fa-street-view"></i> Location</h4>
            <div class="row pad-20">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group address">
                        <label class="form-label"> Longitude</label>
                        <input type="text" class="form-control" id="long" readonly
                        value="{{$propriete->LONGITUDE ?? '-4.053024291992191'}}">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group address">
                        <label class="form-label">Latitude</label>
                        <input type="text" class="form-control" value="{{$propriete->LATITUDE ?? '5.489826708970218'}}"
                        id="lat" readonly>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group map">
                        <div class="map-content">
                            <div id="singleMap" class="drag-map" data-latitude="{{$propriete->LATITUDE ?? '5.489826708970218'}}"
                            data-longitude="{{$propriete->LONGITUDE ?? '-4.053024291992191'}}"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label>Pays *</label>
                        <select class="form-control" id="IDPays">
                            <option value="" selected disabled>Choisir pays..</option>
                            @foreach ($pays as $v)
                                <option value="{{$v->ID_PAYS}}">{{$v->LIB_PAYS}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label>Ville *</label>
                        <select class="form-control" id="IDVille">
                            <option value="" selected disabled>Choisir ville..</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group address">
                        <label for="Adresse" class="form-label">Adresse *</label>
                        <input type="text" class="form-control" id="Adresse" placeholder="Adresse">
                    </div>
                </div>
            </div>
            {{-- <h4 class="bg-grea-3">Property Gallery</h4>
            <div class="row pad-20">
                <div class="col-lg-12">
                    <div id="myDropZone" class="dropzone dropzone-design">
                        <div class="dz-default dz-message"><span>Drop files here to upload</span></div>
                    </div>
                    <input type="file" name="file" class="form-control" id="file" placeholder="Choisir un fichier">
                </div>
            </div> --}}
            <h4 class="bg-grea-3" id="h4detail"><i class="fa fa-list"></i> Informations détaillées</h4>
            <div class="row pad-20" id="chps_batisse">
                <div class="col-lg-12">
                    <div class="form-group message">
                        <textarea id="Descriptif" class="form-control" rows="3" placeholder="Detailed Information"></textarea>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="form-group">
                        <label>Année de construction</label>
                        <select class="form-control" id="AnneeConst">
                            <option value="" selected disabled>Choisir année..</option>
                            @foreach ($annee as $v)
                                <option value="{{$v->ANNEE_CONST_ID}}">{{$v->LIB_ANNEE_CONST}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="form-group">
                        <label>Chambres</label>
                        <select class="form-control" id="NbChambres">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                            <option>9</option>
                            <option>10</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="form-group">
                        <label>Salles de bain</label>
                        <select class="form-control" id="NbSalleDeBain">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                            <option>9</option>
                            <option>10</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="form-group">
                        <label>Garages</label>
                        <select class="form-control" id="NbGarages">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                    <div class="checkbox checkbox-theme checkbox-circle">
                        <input id="Wifi" type="checkbox">
                        <label for="Wifi">Wifi </label>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                    <div class="checkbox checkbox-theme checkbox-circle">
                        <input id="Piscine" type="checkbox">
                        <label for="Piscine">Piscine </label>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                    <div class="checkbox checkbox-theme checkbox-circle">
                        <input id="Cusine" type="checkbox">
                        <label for="Cusine">Cuisine équipée </label>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                    <div class="checkbox checkbox-theme checkbox-circle">
                        <input id="Climatise" type="checkbox">
                        <label for="Climatise">Climatisation </label>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                    <div class="checkbox checkbox-theme checkbox-circle">
                        <input id="Parking" type="checkbox">
                        <label for="Parking">Parking </label>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                    <div class="checkbox checkbox-theme checkbox-circle">
                        <input id="Securite" type="checkbox">
                        <label for="Securite">Securité </label>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                    <div class="checkbox checkbox-theme checkbox-circle">
                        <input id="SalleDeSport" type="checkbox">
                        <label for="SalleDeSport">Salle de Sport </label>
                    </div>
                </div>
            </div>
            <h4 class="bg-grea-3"><i class="fa fa-sliders"></i> Media vidéo</h4>
            <div class="row pad-20">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group address">
                        <label class="form-label">Video Youtube</label>
                        <input type="text" class="form-control" id="UrlVideo" placeholder="Lien Video Youtube">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group address">
                        <label class="form-label">Video Vimeo</label>
                        <input type="text" class="form-control" id="UrlVimeo" placeholder="Lien Video Vimeo">
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6" hidden>
                    <div class="checkbox checkbox-theme checkbox-circle">
                        <input id="CalcHypoth" type="checkbox">
                        <label for="CalcHypoth">Calculateur Hypothèque </label>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6" hidden>
                    <div class="checkbox checkbox-theme checkbox-circle">
                        <input id="GoogleMap" type="checkbox">
                        <label for="GoogleMap">Google map </label>
                    </div>
                </div>
            </div>
            <h4 class="bg-grea-3">
                <div class="text-center" id="output" style="color: red; font-size:15px;"></div>
            </h4>
            <div class="row pad-20">
                <div class="col-12">
                    <button class="btn btn-primary" type="button" onclick="savedata();">
                        <i class="fa fa-fw fa-check-circle-o"></i>Valider
                    </button>
                    <button class="btn btn-outline-secondary" type="button" onclick="cancel();">
                        <i class="fa fa-fw fa-times-circle-o"></i>Annuler
                    </button>
                </div>
            </div>
        </form>

    </div>
@endsection

@section('js')

    <script src="https://maps.googleapis.com/maps/api/js?key={{Help::$API_KEY_HERE ?? 'API_KEY_HERE'}}&libraries=places"></script>
    <script src="{{asset('site/js/map-add.js')}}"></script>
    <script src="{{asset('site/js/dashboard.js')}}"></script>

    <script>

        $("#bEnPromotion").on('change', function() {
            let valeur = document.getElementById("bEnPromotion").checked;
            if (valeur == true) $("#saisiPourcentage").show('500');
            if (valeur == false) $("#saisiPourcentage").hide('500');
        });

        function chpSelonType(idcat) {
            let url = "{{ route('donneInfosCategorie', ['idcateG' => ':idcateG']) }}";
            url = url.replace(":idcateG", idcat);
            $.ajax({
                type: "get",
                url: url,
                contentType: "application/json",
                success: function(data) {
                    console.log(data);
                    if (typeof data.ID_TYPE != "undefined") {
                        if (data.ID_TYPE==1){
                            $("#nb_piece").show('1000');
                            $("#h4detail").show('1000');
                            $("#chps_batisse").show('1000');
                        }else{
                            $("#nb_piece").hide('1000');
                            $("#h4detail").hide('1000');
                            $("#chps_batisse").hide('1000');
                        }
                    }else{
                        let valeur = `<div class="alert alert-2 alert-warning alert-dismissible fade show" role="alert">
                        Type de la catégorie est invalide.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`;
                        $('#sv-mess').append(valeur);
                    }
                },
                error: function(err) {
                    console.log(err);
                    $("#sv-mess").show();
                    let valeur = `<div class="alert alert-2 alert-warning alert-dismissible fade show" role="alert">
                        Une erreur s'est produite pendant la recupération des informations de la catégorie.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                    $('#sv-mess').append(valeur);
                }
            });
        }
        $("#IDCategories").on('change', function() {
            let idcat = document.getElementById("IDCategories").value;
            chpSelonType(idcat);
        });

        $("#IDPays").on('change', function() {
            let id = $("#IDPays").val();
            getVillePays(id, 0);
        });

        function getVillePays(id, idV) {
            let url = "{{ route('donneVilleList', ['IDPays' => ':IDPays']) }}";
            url = url.replace(":IDPays", id);
            $.ajax({
                type: "get",
                url: url,
                contentType: "application/json",
                success: function(data) {
                    console.log(data);
                    $('#IDVille').empty();
                    let valeur = `<option value="" selected disabled>Choisir ville..</option>`;
                    if (data.length > 0) {
                        data.forEach((d) => {
                            valeur += ` <option value="${ d.ID_VILLE }">${ d.LIB_VILLE }</option>`;
                        });
                    }
                    $('#IDVille').append(valeur);
                    if (idV>0) document.getElementById("IDVille").value = idV;
                }, error: function(data) { console.log(data); $("#output").text('alert: Erreur interne du serveur !'); }
            });
        }

        function RazChamp() {
            document.getElementById("LibellePropriete").value = "";
            document.getElementById("TypePropriete").value = "";
            document.getElementById("PrixHT").value = "";
            document.getElementById("IDCategories").value = "";
            document.getElementById("Superficie").value = "";
            document.getElementById("NbPieces").value = "";
            document.getElementById("bNouveaute").value = "";
            document.getElementById("bEnPromotion").value = "";
            document.getElementById("Pourcentage").value = "";
            document.getElementById("IDPays").value = "";
            document.getElementById("IDVille").value = "";
            document.getElementById("Adresse").value = "";
            document.getElementById("Descriptif").value = "";
            document.getElementById("AnneeConst").value = "";
            document.getElementById("NbChambres").value = "";
            document.getElementById("NbSalleDeBain").value = "";
            document.getElementById("NbGarages").value = "";
            document.getElementById("Wifi").value = "";
            document.getElementById("Piscine").value = "";
            document.getElementById("Cusine").value = "";
            document.getElementById("Climatise").value = "";
            document.getElementById("Parking").value = "";
            document.getElementById("Securite").value = "";
            document.getElementById("SalleDeSport").value = "";
            document.getElementById("UrlVideo").value = "";
            document.getElementById("UrlVimeo").value = "";
            document.getElementById("CalcHypoth").value = "";
            document.getElementById("GoogleMap").value = "";
        }

        function updatedata(data) {
            document.getElementById("IDProprietes").value = data.ID_PROPRIETES;
            document.getElementById("LibellePropriete").value = data.LIB_PROPRIETE;
            document.getElementById("TypePropriete").value = data.ID_TYPE_PROPRIETE;
            document.getElementById("PrixHT").value = data.PRIX_HT;
            document.getElementById("IDCategories").value = data.ID_CATEGORIES;
            chpSelonType(data.ID_CATEGORIES);
            document.getElementById("Superficie").value = data.SUPERFICIE;
            document.getElementById("NbPieces").value = data.NB_PIECES;
            if (data.EST_NOUVEAU == 1) document.getElementById("bNouveaute").checked = true;
            if (data.EN_PROMOTION == 1) document.getElementById("bEnPromotion").checked = true;
            if (data.EN_PROMOTION == 1) $("#saisiPourcentage").show('500');
            document.getElementById("Pourcentage").value = data.POURCENT_PROMO;
            document.getElementById("IDPays").value = data.ID_PAYS;
            getVillePays(document.getElementById("IDPays").value, data.ID_VILLE);
            document.getElementById("Adresse").value = data.ADRESSE;
            document.getElementById("Descriptif").value = data.DESCRIPTIF;
            document.getElementById("AnneeConst").value = data.ANNEE_CONST;
            document.getElementById("NbChambres").value = data.NB_CHAMBRES;
            document.getElementById("NbSalleDeBain").value = data.NB_SALLE_DE_BAIN;
            document.getElementById("NbGarages").value = data.NB_GARAGE;
            if (data.WIFI == 1) document.getElementById("Wifi").checked = true;
            if (data.PISCINE == 1) document.getElementById("Piscine").checked = true;
            if (data.CUSINE_EQUIPE == 1) document.getElementById("Cusine").checked = true;
            if (data.CLIMATISATION == 1) document.getElementById("Climatise").checked = true;
            if (data.PARKING == 1) document.getElementById("Parking").checked = true;
            if (data.SECURITE == 1) document.getElementById("Securite").checked = true;
            if (data.SALLE_DE_SPORT == 1) document.getElementById("SalleDeSport").checked = true;
            document.getElementById("UrlVideo").value = data.URL_VIDEO;
            document.getElementById("UrlVimeo").value = data.URL_VIMEO;
            if (data.CALCUL_HYPOTHEQUE == 1) document.getElementById("CalcHypoth").checked = true;
            if (data.GOOGLE_MAP == 1) document.getElementById("GoogleMap").checked = true;
        }
        function cancel() { rout = "{{route('proprieteList')}}"; window.open(rout, '_self'); }

        function savedata() {

            $("#sv-mess").hide();
            $('#sv-mess').empty();
            $("#output").text('');

            let rout = "{{ route('proprieteValid') }}";

            let idP = document.getElementById("IDProprietes").value;
            let Lbl = document.getElementById("LibellePropriete").value;
            let Typ = document.getElementById("TypePropriete").value;
            let Prix = document.getElementById("PrixHT").value;
            let idCateg = document.getElementById("IDCategories").value;
            let Superf = document.getElementById("Superficie").value;
            let NbPiece = document.getElementById("NbPieces").value;
            let Nouv = document.getElementById("bNouveaute").checked;
            let EnPromo = document.getElementById("bEnPromotion").checked;
            let Pourc = document.getElementById("Pourcentage").value;
            let Long = document.getElementById("long").value;
            let Lat = document.getElementById("lat").value;
            let pays = document.getElementById("IDPays").value;
            let ville = document.getElementById("IDVille").value;
            let Adr = document.getElementById("Adresse").value;
            let Desc = document.getElementById("Descriptif").value;
            let Annee = document.getElementById("AnneeConst").value;
            let NbChamb = document.getElementById("NbChambres").value;
            let NbSalBain = document.getElementById("NbSalleDeBain").value;
            let NbGarag = document.getElementById("NbGarages").value;
            let wifi = document.getElementById("Wifi").checked;
            let piscine = document.getElementById("Piscine").checked;
            let cuisine = document.getElementById("Cusine").checked;
            let climat = document.getElementById("Climatise").checked;
            let parking = document.getElementById("Parking").checked;
            let secur = document.getElementById("Securite").checked;
            let salleSport = document.getElementById("SalleDeSport").value;
            let ytbe = document.getElementById("UrlVideo").value;
            let vimeo = document.getElementById("UrlVimeo").value;
            let calc = document.getElementById("CalcHypoth").checked;
            let gglemap = document.getElementById("GoogleMap").checked;

            let errfield = controlChps(Lbl, Typ, Prix, idCateg, Superf, NbPiece, pays, ville, Adr);
            if (errfield!='') {
                $("#output").text(errfield);
            }else{
                let csrf = document.querySelector('meta[name="csrf-token"]').content;
                let csrf_field = '<input type="hidden" name="_token" value=“'+csrf+'”>';
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
                        IDProprietes: idP,
                        LibellePropriete: Lbl,
                        TypePropriete: Typ,
                        PrixHT: Prix,
                        IDCategories: idCateg,
                        Superficie: Superf,
                        NbPieces: NbPiece,
                        bNouveaute: Nouv,
                        bEnPromotion: EnPromo,
                        Pourcentage: Pourc,
                        long: Long,
                        lat: Lat,
                        IDPays: pays,
                        IDVille: ville,
                        Adresse: Adr,
                        Descriptif: Desc,
                        AnneeConst: Annee,
                        NbChambres: NbChamb,
                        NbSalleDeBain: NbSalBain,
                        NbGarages: NbGarag,
                        Wifi: wifi,
                        Piscine: piscine,
                        Cusine: cuisine,
                        Climatise: climat,
                        Parking: parking,
                        Securite: secur,
                        SalleDeSport: salleSport,
                        UrlVideo: ytbe,
                        UrlVimeo: vimeo,
                        CalcHypoth: calc,
                        GoogleMap: gglemap,
                    },
                    success: function (data) {
                        console.log(data);
                        $("#sv-mess").show();
                        let valeur = `<div class="alert alert-2 alert-warning alert-dismissible fade show" role="alert" id="sv-mess">
                            ${ data.mess }
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`;
                        $('#sv-mess').append(valeur);
                        if (data.code == '200'){ setTimeout(cancel, 500); }
                    }, error: function(err) {
                        console.log(err);
                        $("#sv-mess").show();
                        let valeur = `<div class="alert alert-2 alert-warning alert-dismissible fade show" role="alert" id="sv-mess">
                            Erreur serveur !!!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`;
                        $('#sv-mess').append(valeur);
                    }
                });
            }

        }

        function controlChps(Lbl, Typ, Prix, idCateg, Superf, NbPiece, pays, ville, Adr){
            let len = document.getElementById('LibellePropriete').value.length;
            if (Lbl=='' || len<10) { return "Veuillez saisi un titre valide pour l'annonce, 10 caractères minimum"; }
            if (Typ=='') { return "Le champ 'Type de Proprieté' est obligatoire"; }
            if (Prix=='' || Prix<200) { return "Veuillez saisir un montant valide"; }
            if (idCateg=='') { return "Le champ 'Categorie' est obligatoire"; }
            if (Superf=='' || Superf<10) { return "Veuillez saisir une superficie valide"; }
            /*if (NbPiece=='') { return "Le champ 'Nombre de Pièces' est obligatoire"; }*/
            if (pays=='') { return "Le champ 'Pays' est obligatoire"; }
            if (ville=='') { return "Le champ 'Ville' est obligatoire"; }
            if (Adr=='') { return "Le champ 'Adresse' est obligatoire"; }
            return '';
        }

        function majIHM() {
            RazChamp();
            $("#sv-mess").hide();
            $('#sv-mess').empty();
            let id = document.getElementById("IDProprietes").value;
            if (id>0) {
                let url = "{{ route('getPropriete', ['id' => ':IDProprietes']) }}";
                url = url.replace(":IDProprietes", id);
                $.ajax({
                    type: "get",
                    url: url,
                    contentType: "application/json",
                    success: function(data) {
                        console.log(data);
                        updatedata(data);
                    },
                    error: function(err) {
                        console.log(err);
                        $("#sv-mess").show();
                        let valeur = `<div class="alert alert-2 alert-warning alert-dismissible fade show" role="alert">
                            Une erreur s'est produite pendant la recupération des informations sur l'enregistrement.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`;
                        $('#sv-mess').append(valeur);
                    }
                });
            }
        }

        majIHM();

        /*$('#PrixHT').on('keyup', function (e){
            var v = $(this).val().replace(/\s/g, '').replace(',', '.');
            e.key!=','&&e.key!='.' ? !isNaN(parseFloat(v)) ? $(this).val(parseFloat(v).toLocaleString("fr-FR")): null : null;
        })
        $('#Superficie').on('keyup', function (e){
            var v = $(this).val().replace(/\s/g, '').replace(',', '.');
            e.key!=','&&e.key!='.' ? !isNaN(parseFloat(v)) ? $(this).val(parseFloat(v).toLocaleString("fr-FR")): null : null;
        })*/

        // document.addEventListener('DOMContentLoaded', function() {
        //    const displayInput = document.getElementById('PrixHT_N');
        //    const hiddenInput = document.getElementById('PrixHT');
        //    displayInput.addEventListener('input', function() {
        //        const value = displayInput.value.replace(/,/g, '');
        //        if (!isNaN(value) && value !== '') {
        //            const formattedValue = parseInt(value).toLocaleString('en');
        //            displayInput.value = formattedValue;
        //            hiddenInput.value = value;
        //        }else{ hiddenInput.value = ''; }
        //    });
        //    displayInput.addEventListener('blur', function() {
        //        if (hiddenInput.value) {
        //            displayInput.value = parseInt(hiddenInput.value).toLocaleString('en');
        //        }
        //    });
        //    displayInput.addEventListener('focus', function() {
        //        displayInput.value = hiddenInput.value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        //    });
        // });

    </script>
@endsection
