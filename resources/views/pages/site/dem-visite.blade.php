@extends('layouts.s_template', ['titre' => $titre])

@section('content')
    @include('partials.site.sub-banner', ['element' => 'Demande propriété'])
    <div class="properties-details-page">
        <br />
        <div class="container">
            <div class="row" id="formInfos">
                <div class="col-lg-6 col-md-12">
                    <div class="sidebar-right">
                        <div class="widget advanced-search">
                            <h3 class="sidebar-title">Informations vous concernant</h3>
                            <div class="s-border"></div>
                            <div class="m-border"></div>
                            <div class="row" id="connectInfos"
                                @if (empty($us->ID_UTILISATEUR)) style="display: none;" @endif>
                                <div class="col-md-12">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td style="color: black">
                                                    Nom & Prenoms
                                                </td>
                                                <td style="color: black">
                                                    <b>: {{ $client->NOM ?? 'xxxxxxxxxx' }}&nbsp;
                                                        {{ $client->PRENOMS ?? 'xxxxxxxxxx' }} </b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color: black">
                                                    Pays
                                                </td>
                                                <td style="color: black">
                                                    <b>: {{ $client->LIB_PAYS ?? 'xxxxxxxxxx' }} </b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color: black">
                                                    Ville
                                                </td>
                                                <td style="color: black">
                                                    <b>: {{ $client->LIB_VILLE ?? 'xxxxxxxxxx' }} </b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color: black">
                                                    Contact
                                                </td>
                                                <td style="color: black">
                                                    <b>: {{ $client->CONTACT ?? 'xxxxxxxxxx' }} </b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color: black">
                                                    Email
                                                </td>
                                                <td style="color: black">
                                                    <b>: {{ $client->ADR_EMAIL ?? 'xxxxxxxxxx' }} </b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color: black">
                                                    Adresse
                                                </td>
                                                <td style="color: black">
                                                    <b>: {{ $client->ADRESSE ?? 'xxxxxxxxxx' }} </b>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br />
                                    <p style="color: gray" @if (empty($us->ID_UTILISATEUR)) hidden @endif>
                                        Renseigner d'autres informations ou utliser un autre compte?&nbsp;
                                        <a type="button" href="{{ route('deconnectDem') }}" style="color:rgb(66, 66, 255)">
                                            Deconnectez-vous ici
                                        </a>
                                    </p>
                                </div>
                            </div>
                            @include('partials.site.formdonnees')
                            @include('partials.site.formconnexion')
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="sidebar-right">
                        <div class="widget advanced-search">
                            <h3 class="sidebar-title">Informations sur la demande</h3>
                            <div class="s-border"></div>
                            <div class="m-border"></div>
                            <form method="post" action="#">
                                @csrf
                                <p id="str-mess"></p>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group" style="text-align: left">
                                            <label for="label-control">Type demande</label>
                                            <select class="form-control" id="typeD">
                                                <option value="0" selected disabled>Choisir type..</option>
                                                <option value="1">Visite de propriété</option>
                                                <option value="2">Besion d'information par appel</option>
                                                <option value="3">Besion d'information par email</option>
                                                <option value="4">Autre</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="dispo" class="col-lg-12 col-md-12 col-sm-12 row" style="display: none;">
                                        <div class="col-md-6">
                                            <div class="form-group name">
                                                <span style="color: black">Date visite </span>
                                                <label for="" style="color: red">*</label>
                                                <input type="date" name="name" class="form-control" id="date"
                                                    aria-label="Date visite">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group name">
                                                <span style="color: black">Heure visite </span>
                                                <label for="" style="color: red">*</label>
                                                <input type="time" name="name" class="form-control" id="heure"
                                                    aria-label="Date visite">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <span class="text-center mx-3 fw-bold"><i><u>Souscrivez gratuitement à notre
                                                    assistance
                                                    complète avec BMI-WFS</u></i></span> <br>
                                        <input type="text" id="selected_assistance" name="selected_assistance"
                                            value="" style="display: none">

                                        <label style="cursor: pointer;">
                                            <input type="radio" name="assistance_option"
                                                value="Suivi personnalisé de votre projet avec
                                                BMI-WFS"
                                                style="margin-right: 5px;">
                                            <span style="color: black">Suivi personnalisé de votre projet avec
                                                BMI-WFS</span>
                                        </label>
                                        <br>

                                        <label style="cursor: pointer;">
                                            <input type="radio" name="assistance_option"
                                                value="Assistance au suivi des travaux par BMI-WFS"
                                                style="margin-right: 5px;">
                                            <span style="color: black">Assistance au suivi des travaux par BMI-WFS</span>
                                        </label>
                                        <br>

                                        <label style="cursor: pointer;">
                                            <input type="radio" name="assistance_option"
                                                value="Assistance à la gestion des paiements avec
                                                BMI-WFS"
                                                style="margin-right: 5px;">
                                            <span style="color: black">Assistance à la gestion des paiements avec
                                                BMI-WFS</span>
                                        </label>
                                        <br>

                                        <label style="cursor: pointer;">
                                            <input type="radio" name="assistance_option"
                                                value="Accompagnement jusqu'à la validation de votre bien
                                                par BMI-WFS"
                                                style="margin-right: 5px;">
                                            <span style="color: black">Accompagnement jusqu'à la validation de votre bien
                                                par BMI-WFS</span>
                                        </label>


                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group message">
                                            <span style="color: black">Message </span>
                                            <textarea class="form-control" name="message" placeholder="Votre message" rows="5" id="message"
                                                aria-label="Write message">Souhaite visiter la propriété {{ $proprietes->LIB_PROPRIETE ?? '' }} </textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="send-btn text-center">
                                            <button type="button" class="btn-6"
                                                onclick="sendDemande({{ $proprietes->ID_PROPRIETES ?? 0 }});">
                                                Soumettre la demande</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="sidebar-left">
                        <div class="widget advanced-search">
                            <h3 class="sidebar-title">Informations Propriétés</h3>
                            <div class="s-border"></div>
                            <div class="m-border"></div>
                            <div class="heading-properties-3">
                                <div class="clearfix">
                                    <br />
                                    <div class="pull-left">
                                        <h1>
                                            <a
                                                href="{{ route('detailP', ['idPropriete' => $proprietes->ID_PROPRIETES]) }}">
                                                {{ $proprietes->LIB_PROPRIETE ?? 'designation' }}
                                            </a>
                                        </h1>
                                    </div>
                                    <div class="pull-right">
                                        @if ($proprietes->EN_PROMOTION == true)
                                            <h1>
                                                <s style="color: #8888; font-size: 70%">
                                                    {{ Help::formatNombre($proprietes->PRIX_HT ?? '0', true) }}</s>
                                                <b
                                                    style="font-size: 70%">(-{{ $proprietes->POURCENT_PROMO ?? '0.0' }}%)</b>&nbsp;
                                                <span>{{ Help::formatNombre($proprietes->PRIX_PROMO ?? '0', true) }}</span>
                                            </h1>
                                        @else
                                            <h1><span>{{ Help::formatNombre($proprietes->PRIX_HT ?? '0', true) }}</span>
                                            </h1>
                                        @endif
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <div class="pull-left">
                                        <p><i class="flaticon-pin"></i> {{ $proprietes->ADRESSE ?? 'adresse' }}</p>
                                    </div>
                                    <div class="pull-right">
                                        <p><span>{{ $proprietes->SUPERFICIE ?? 'superficie' }} m²</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="product-slider-box cds-2 clearfix mb-3">
                                <div class="product-img-slide">
                                    <div class="slider-for">
                                        <img src="{{ asset($proprietes->IMG_DEFAULT ?? 'assets/img/properties/properties-1.png') }}"
                                            class="img-fluid w-100" alt="slider-photo">
                                        @foreach ($files as $key => $value)
                                            <div class="col-lg-4 col-md-6 col-sm-6 filtr-item" data-category="2">
                                                <img src="{{ $value->PATH_IMAGES ?? 'assets/img/properties/properties-2.png' }}"
                                                    class="img-fluid w-100">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="slider-nav">
                                        <div class="thumb-slide">
                                            <img
                                                src="{{ asset($proprietes->IMG_DEFAULT ?? 'assets/img/properties/properties-1.png') }}">
                                        </div>
                                        @foreach ($files as $key => $value)
                                            <div class="col-lg-4 col-md-6 col-sm-6 filtr-item" data-category="2">
                                                <img src="{{ $value->PATH_IMAGES ?? 'assets/img/properties/properties-2.png' }}"
                                                    class="thumb-slide">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12" id="congrate" style="display: none">
                <div class="sidebar-left">
                    <div class="widget advanced-search">
                        <div class="text-center">
                            <a href="{{ route('home') }}" class="mb-30">
                                <img src="{{ asset('200.jpg') }}" alt="logo" style="height: 30%; width: 30%">
                            </a>
                            <h6 style="font-size: 200%" class="mb-30">Félicitations <br />
                                <span style="color: green; font-size: 80%" id="valInf">
                                    Votre demande a été soumise, avec succès<br /> vous serez contacté dans les 24H.
                                </span>
                            </h6>
                            <div class="coming-form clearfix">
                                <a href="{{ route('home') }}" class="btn btn-theme" type="button">Accueil</a>
                                <a href="{{ route('tdbc') }}" class="btn btn-theme" type="button">Accedez à mon
                                    compte</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Met à jour l'input masqué avec la valeur sélectionnée
        document.querySelectorAll('input[name="assistance_option"]').forEach((radio) => {
            radio.addEventListener('change', function() {
                document.getElementById('selected_assistance').value = this.value;
            });
        });
    </script>

    <script>
        var ajaxmess = $('#str-mess');

        function authLogin() {
            ajaxmess.text('');
            $('#infos').hide();
            $('#newacc').hide();
            $('#authACT').hide();
            $('#authLOG').show();
        }

        function form() {
            ajaxmess.text('');
            $('#infos').show();
            $('#newacc').hide();
            $('#authLOG').hide();
            $('#authACT').show();
        }

        function sendDemande(params) {
            $('#congrate').hide();
            $('#formInfos').show();
            var rout = "{{ route('ajaxVisit') }}";
            ajaxmess.text("");
            ajaxmess.css('color', 'red');
            var civ = document.getElementById("civilite").value;
            var nom = document.getElementById("nom").value;
            var pren = document.getElementById("prenoms").value;
            var cont = document.getElementById("contact").value;
            var nat = document.getElementById("nationalite").value;
            var pays = document.getElementById("pays").value;
            var ville = document.getElementById("ville").value;
            var adr = document.getElementById("adresse").value;
            var email = document.getElementById("email").value;
            var datevis = document.getElementById("date").value;
            var heurvis = document.getElementById("heure").value;
            var texte = document.getElementById("message").value;
            var typdem = document.getElementById("typeD").value;
            var assist = document.getElementById("selected_assistance").value;
            var errfield = checkfields(civ, nom, pren, cont, nat, pays, ville, adr, email, assist);
            if (errfield != '') {
                if ($('#infos').is(':visible') == false) {
                    ajaxmess.text('Veuillez vous connecter a un compte ou cliquez sur << Je n\'ai pas de compte >>');
                } else {
                    ajaxmess.text(errfield);
                }
            } else {
                if ((datevis == '' || datevis.length < 10) && typdem == 1) {
                    document.getElementById("date").focus();
                    ajaxmess.focus();
                    ajaxmess.text("Veuillez renseigner une date de visite valide.");
                } else {
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
                            Civilite: civ,
                            Nom: nom,
                            Prenoms: pren,
                            Contact: cont,
                            Nationalite: nat,
                            IDPays: pays,
                            VilleID: ville,
                            Adresse: adr,
                            Email: email,
                            date: datevis,
                            heur: heurvis,
                            mess: texte,
                            param: params,
                            demtype: typdem,
                            valAssist: assist,
                        },

                        success: function(res) {
                            console.log(res);
                            if (res.code != '200') {
                                ajaxmess.focus();
                                ajaxmess.text(res.mess);
                            } else {
                                $('#valInf').html(res.mess);
                                $('#congrate').show('5000');
                                $('#formInfos').hide('5000');
                            }
                        },
                        error: function(res) {
                            console.log(res);
                            ajaxmess.focus();
                            ajaxmess.text('alert: Erreur interne du serveurs !');
                        }
                    });
                }
            }
        }

        function checkEmail(email) {
            var re =
                /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (re.test(email)) return true;
            else return false;
        }

        function checkfields(civ, nom, pren, cont, nat, pays, ville, adr, email, assist) {
            if (civ == '') {
                document.getElementById("civilite").focus();
                return "Veuillez definir votre 'civilité'";
            }
            if (nom == '' || nom.length < 3) {
                document.getElementById("nom").focus();
                return "Veuillez saisi un nom valide, 4 caractères minimum";
            }
            if (pren == '' || pren.length < 3) {
                document.getElementById("prenoms").focus();
                return "Veuillez saisi un prenoms valide, 3 caractères minimum";
            }
            if (cont == '' || cont.length < 10) {
                document.getElementById("contact").focus();
                return "Veuillez saisir un contact valide, 10 caractères";
            }
            if (nat == '') {
                document.getElementById("nationalite").focus();
                return "Veuillez renseigner une nationalité valide";
            }
            if (pays <= 0) {
                document.getElementById("pays").focus();
                return "Veuillez indiquer le pays de residence";
            }
            if (ville <= 0) {
                document.getElementById("ville").focus();
                return "Veuillez indiquer la ville de residence";
            }
            if (adr == '' || adr.length < 20) {
                document.getElementById("adresse").focus();
                return "Veuillez renseigner une adresse valide, 20 caractères minimum. (ville, commune, quartier, rue...)";
            }
            if (email == '' || checkEmail(email) == false) {
                document.getElementById("email").focus();
                return "Veuillez renseigner un email valide (jhoen@gmail.com)";
            }
            if (assist == '') {
                document.getElementById("selected_assistance").focus();
                return "Veuillez sélectionner une option d'assistance avant de soumettre le formulaire. Cela nous permettra de mieux vous accompagner dans votre démarche.";
            }
            return '';
        }
        $("#typeD").on('change', function() {
            var id = $("#typeD").val();
            if (id == 1) {
                $("#dispo").show();
            } else {
                $("#dispo").hide();
            }
        });
        $("#pays").on('change', function() {
            ajaxmess.text("");
            ajaxmess.css('color', 'red');
            var id = $("#pays").val();
            var url = "{{ route('donneVilleList', ['IDPays' => ':IDPays']) }}";
            url = url.replace(":IDPays", id);
            $.ajax({
                type: "get",
                url: url,
                contentType: "application/json",
                success: function(data) {
                    console.log(data);
                    $('#ville').empty();
                    var valeur = `<option value="" selected disabled>Choisir ville..</option>`;
                    if (data.length > 0) {
                        data.forEach((d) => {
                            valeur +=
                                ` <option value="${ d.ID_VILLE }">${ d.LIB_VILLE }</option>`;
                        });
                    }
                    $('#ville').append(valeur);
                },
                error: function(data) {
                    console.log(data);
                    ajaxmess.text("alert: Erreur interne du serveur !");
                }
            });
        });


        var ajaxERR = $('#output');

        function connect(params) {
            ajaxERR.text("");
            ajaxERR.css('color', 'red');
            var acce = document.getElementById("Login").value;
            var pass = document.getElementById("MotDePasse").value;
            var errfield = controlChps(acce, pass);
            if (errfield != '') {
                ajaxERR.text(errfield);
            } else {
                var rout = "{{ route('ajaxCnx') }}";
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
                        Login: acce,
                        MotDePasse: pass,
                    },
                    success: function(res) {
                        console.log(res);
                        if (res.code != 200) {
                            ajaxERR.text(res.mess);
                        } else {
                            window.open(res.mess, '_self');
                        }
                    },
                    error: function(res) {
                        console.log(res);
                        ajaxERR.text('Erreur interne du serveur! ::ERR::connect');
                    }
                });
            }
        }

        function markAsCnx(params) {
            ajaxERR.text("");
            ajaxERR.css('color', 'red');
            var url = "{{ route('cnxFordemande', ['idPropriete' => ':param']) }}";
            url = url.replace(":param", params);
            $.ajax({
                type: "get",
                url: url,
                contentType: "application/json",
                success: function(data) {
                    console.log(data);
                    if (data.code != 200) {
                        ajaxERR.text('Echec de creation secret key! ::ERR::markAsCnx');
                    } else {
                        connect(params);
                    }
                },
                error: function(data) {
                    console.log(data);
                    ajaxERR.text('Erreur interne du serveur! ::ERR::markAsCnx');
                }
            });
        }

        function controlChps(acce, pass) {
            var taille = 0;
            if (acce == '') {
                return "Le champ 'Login' est obligatoire !";
            }
            taille = document.getElementById('Login').value.length;
            if (taille < 6) {
                return "Le Login doit être au minimun 6 caractères";
            }
            if (pass == '') {
                return "Le champ 'Mot de Passe' est obligatoire !";
            }
            taille = document.getElementById('MotDePasse').value.length;
            if (taille < 6) {
                return "Le mot de passe doit être au minimun 6 caractères";
            }
            return '';
        }
        $(".eye").on("click touchstart", function() {
            var epi = $(this).parent(".form-group").find("input");
            if (epi.attr("type") === "password") {
                epi.attr("type", "text");
            } else {
                epi.attr("type", "password");
            }
        });
    </script>
@endsection
