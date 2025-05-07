<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>{{ $titre ?? 'Connexion' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.site.css')
</head>

<body>

    @php $entreprise = Help::Infos() @endphp

    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PTNPV7L" height="0" width="0"
        style="display:none;visibility:hidden"></iframe>
    </noscript>
    <div class="page_loader"></div>

    <div class="contact-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-7 col-md-12 bg-login-ing">
                    <div class="informeson">
                        <div class="typing">
                            <h1>{{$entreprise->RAISON_SOCIALE ?? 'Bienvenue à BHCI'}}</h1>
                        </div>
                        <p>{{$entreprise->SLOGAN ?? 'Le Professionnel de l\'Immobilier'}}</p>
                        <div class="social-list">
                            <div class="buttons">
                                <a href="{{$entreprise->URLFBK ?? '#'}}" class="facebook-bg"><i class="fa fa-facebook"></i></a>
                                <a href="{{$entreprise->URLTWT ?? '#'}}" class="twitter-bg"><i class="fa fa-twitter"></i></a>
                                <a href="{{$entreprise->URLLINK ?? '#'}}" class="dribbble-bg"><i class="fa fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12 form-section">
                    <div class="login-inner-form">
                        <div class="details">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset($entreprise->LOGO ?? Help::$LOGO) }}" alt="logo">
                            </a>
                            <h3>{{$libform ?? 'Authentification'}}</h3>
                            @if($act=='auth')
                                <form action="#" method="post">
                                    @csrf
                                    <div class="form-group form-box" style="text-align: left">
                                        <label for="label-control">Login</label>
                                        <input type="text" name="Login" class="form-control"
                                            placeholder="Entrez votre login" aria-label="Login" id="Login"
                                            pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==50) return false;">
                                    </div>
                                    <div class="form-group form-box" style="text-align: left">
                                        <label for="label-control">Mot de Passe</label>
                                        <input type="password" name="MotDePasse" class="form-control" autocomplete="off"
                                            placeholder="Mot de passe" aria-label="Password" id="MotDePasse"
                                            pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==30) return false;">
                                        <span class="eye"><i class="fa fa-eye"></i> </span>
                                    </div>
                                    <div class="form-group form-box checkbox clearfix">
                                        <div class="form-check checkbox-theme">
                                            <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">
                                                Se souvenir de moi
                                            </label>
                                        </div>
                                        <a href="#" style="color: gray">Mot de Passe oublié?</a>
                                    </div>
                                    <div class="form-group">
                                        <div class="text-center" id="output" style="color: red"></div>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn-md btn-theme w-100" onclick="sendData();">
                                        Connexion</button>
                                    </div>
                                    {{-- <p>Vous n'avez pas de compte ?
                                        <a href="{{route('registerAccount')}}" style="color:rgb(66, 66, 255)">
                                        Créer un compte ici</a>
                                    </p> --}}
                                </form>
                            @else
                                <form action="#" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5 col-sm-12">
                                            <div class="form-group" style="text-align: left">
                                                <label for="label-control">Civilité</label>
                                                <select class="form-control" id="civilite">
                                                    <option value="" selected disabled>Choisir civilité..</option>
                                                    <option value="1">Monsieur</option>
                                                    <option value="2">Madame</option>
                                                    <option value="3">Mademoiselle</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-12">
                                            <div class="form-group" style="text-align: left">
                                                <label for="label-control">Nom</label>
                                                <input type="text" id="nom" class="form-control"
                                                placeholder="Nom" aria-label="Nom"
                                                pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==20) return false;">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group" style="text-align: left">
                                                <label for="label-control">Prenoms</label>
                                                <input type="text" id="prenoms" class="form-control"
                                                placeholder="Prenoms" aria-label="Prenoms"
                                                pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==50) return false;">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group" style="text-align: left">
                                                <label for="label-control">Contact</label>
                                                <input type="text" id="contact" class="form-control"
                                                placeholder="Contact" aria-label="Contact"
                                                pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==10) return false;">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group" style="text-align: left">
                                                <label for="label-control">Nationalité</label>
                                                <input type="text" id="nationalite" class="form-control"
                                                placeholder="Nationalite" aria-label="Nationalite"
                                                pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==30) return false;">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group" style="text-align: left">
                                                <label for="label-control">Pays</label>
                                                <select class="form-control" id="pays">
                                                    <option value="" selected disabled>Choisir pays..</option>
                                                    @foreach ($pays as $v)
                                                        <option value="{{$v->ID_PAYS}}">{{$v->LIB_PAYS}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group" style="text-align: left">
                                                <label for="label-control">Ville</label>
                                                <select class="form-control" id="ville">
                                                    <option value="" selected disabled>Choisir ville..</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="text-align: left">
                                        <label for="label-control">Adresse</label>
                                        <input type="text" class="form-control" id="adresse"
                                         placeholder="Adresse (ville, commune, quartier, rue...)" aria-label="Adresse"
                                         pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==250) return false;">
                                    </div>
                                    <div class="form-group" style="text-align: left">
                                        <label for="label-control">Email</label>
                                        <input type="email" id="email" class="form-control"
                                        placeholder="Email" aria-label="Email Address"
                                        pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==50) return false;">
                                        <p style="color: gray">
                                        L'adresse email sera utilisé comme votre login de connexion à votre compte.</p>
                                    </div>
                                    <div class="form-group" style="text-align: left">
                                        <label for="label-control">Mot de Passe</label>
                                        <input type="password" id="mdp" class="form-control" autocomplete="off"
                                        placeholder="Mot de Passe" aria-label="Password"><br />
                                        <p id="password-strength"></p>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn-md btn-theme w-100" onclick="savedata();">
                                        Valider</button>
                                    </div>
                                    <p>Avez-vous déjà un compte ?<a href="{{route('cnxPage_A')}}" style="color:rgb(66, 66, 255)">
                                    Connectez vous ici</a></p>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="full-page-search">
        <button type="button" class="close">×</button>
        <form action="#">
            <input type="search" value="" placeholder="tapez le(s) mot(s)-clé(s) ici" />
            <button type="submit" class="btn btn-sm button-theme">Recherche</button>
        </form>
    </div>

    @include('partials.site.js')

    <script type="text/javascript">

        function sendData() {
            var rout = "{{ route('ajaxCnx') }}";
            var acce = document.getElementById("Login").value;
            var pass = document.getElementById("MotDePasse").value;
            var errfield = controlChps(acce, pass);
            if (errfield != '') {
                $("#output").text(errfield);
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
                        Login: acce,
                        MotDePasse: pass,
                    },
                    success: function(res) {
                        $("#output").text('');
                        console.log(res);
                        if (res.code != '200') {
                            $("#output").text(res.mess);
                        }else{ window.open(res.mess, '_self'); }
                    },
                    error: function(res) {
                        console.log(res);
                        $("#output").text('Erreur interne du serveur !');
                    }
                });
            }
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


        $("#pays").on('change', function() {
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
                            valeur += ` <option value="${ d.ID_VILLE }">${ d.LIB_VILLE }</option>`;
                        });
                    }
                    $('#ville').append(valeur);
                }, error: function(data) { console.log(data); $("#output").text('alert: Erreur interne du serveur !'); }
            });
        });
        function savedata() {

            var errorElement = $('#password-strength');
            errorElement.text("");
            errorElement.css('color', 'red');

            var rout = "{{ route('ajaxAccount') }}";

            var civ = document.getElementById("civilite").value;
            var nom = document.getElementById("nom").value;
            var pren = document.getElementById("prenoms").value;
            var cont = document.getElementById("contact").value;
            var nat = document.getElementById("nationalite").value;
            var pays = document.getElementById("pays").value;
            var ville = document.getElementById("ville").value;
            var adr = document.getElementById("adresse").value;
            var email = document.getElementById("email").value;
            var mdp = document.getElementById("mdp").value;

            var errfield = checkfields(civ, nom, pren, cont, nat, pays, ville, adr, email, mdp);
            if (errfield!='') {
                errorElement.text(errfield);
            }else{
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
                        Civilite: civ,
                        Nom: nom,
                        Prenoms: pren,
                        Contact: cont,
                        Nationalite: nat,
                        IDPays: pays,
                        VilleID: ville,
                        Adresse: adr,
                        Email: email,
                        Mdp: mdp,
                    },
                    success: function (res) {
                        console.log(res);
                        if (res.code != '200'){
                            errorElement.text(res.mess);
                        }else{
                            var rout = "{{route('successPage')}}";
                            window.open(rout, '_self');
                        }
                    },
                    error: function(res) { console.log(res); errorElement.text('alert: Erreur interne du serveur !'); }
                });
            }

        }
        function checkEmail (email) {
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (re.test(email)) return true;
            else return false;
        }
        function checkfields(civ, nom, pren, cont, nat, pays, ville, adr, email, mdp){
            if (civ=='') { document.getElementById("civilite").focus(); return "Veuillez definir votre 'civilité'"; }
            if (nom=='' || nom.length < 4) { document.getElementById("nom").focus(); return "Veuillez saisi un nom valide, 4 caractères minimum"; }
            if (pren=='' || pren.length < 3) { document.getElementById("prenoms").focus(); return "Veuillez saisi un prenoms valide, 3 caractères minimum"; }
            if (cont=='' || cont.length < 10) { document.getElementById("contact").focus(); return "Veuillez saisir un contact valide, 10 caractères"; }
            if (nat=='') { document.getElementById("nationalite").focus(); return "Veuillez renseigner une nationalité valide"; }
            if (pays<=0) { document.getElementById("pays").focus(); return "Veuillez indiquer le pays de residence"; }
            if (ville<=0) { document.getElementById("ville").focus(); return "Veuillez indiquer la ville de residence"; }
            if (adr==''|| adr.length < 20) { document.getElementById("adresse").focus(); return "Veuillez renseigner une adresse valide, 20 caractères minimum. (ville, commune, quartier, rue...)"; }
            if (email == '' || checkEmail(email)==false) {
            document.getElementById("email").focus(); return "Veuillez renseigner un email valide (jhoen@gmail.com)"; }
            if (mdp=='' || mdp.length < 8) { document.getElementById("mdp").focus(); return "Veuillez renseigner mot de passe valide, 8 caractères minimum"; }
            return '';
        }
        function verifieForceMotDePasse(password) {

            // Initialise les variables
            var strength = 0;
            var tips = "";

            // Vérifie la longueur du mot de passe
            if (password.length < 8) tips += "Saisi un mot de passe long. ";
            else strength += 1;

            // Vérifie les cas mixtes
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 1;
            else tips += "Utilisez des lettres minuscules et majuscules. ";

            // Vérifie les chiffres
            if (password.match(/\d/)) strength += 1;
            else tips += "Incluez au moins un chiffre. ";

            // Vérifie les caractères spéciaux
            if (password.match(/[^a-zA-Z\d]/)) strength += 1;
            else tips += "Incluez au moins un caractère spécial. ";

            // Mise à jour message utilisateur et la couleur en fonction de la force du mot de passe
            var passwordStrengthElement = $('#password-strength');
            if (strength < 2) {
                passwordStrengthElement.text("Facile à deviner. " + tips);
                passwordStrengthElement.css('color', 'red');
            } else if (strength === 2) {
                passwordStrengthElement.text("Normal. " + tips);
                passwordStrengthElement.css('color', 'orange');
            } else if (strength === 3) {
                passwordStrengthElement.text("Difficile. " + tips);
                passwordStrengthElement.css('color', 'black');
            } else {
                passwordStrengthElement.text("Extrêmement difficile. " + tips);
                passwordStrengthElement.css('color', 'green');
            }
        }
        $(document).ready(function() {
            $('#mdp').on('input', function() {
                var tips = "";
                var strength = 0;
                var password = $(this).val();
                var passwordStrengthElement = $('#password-strength');
                if (password.length>0) verifieForceMotDePasse(password);
                else passwordStrengthElement.text("");
            });
        });

        document.onraccourcie = function() { return false; }
    </script>

</body>

</html>
