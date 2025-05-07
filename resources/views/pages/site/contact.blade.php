@extends('layouts.s_template', ['titre' => $titre])
@section('content')
    @include('partials.site.sub-banner', ['element' => 'Contact'])

    <div class="contact-2 content-area-17">
        <div class="container">
            <div class="main-title text-center">
                <h1>Contactez-Nous</h1>
                <p>Remplissez le formulaire et nous vous recontacterons dans les 24 heures.</p>
            </div>
            <form action="#" method="post">
                @csrf
                <div class="row g-0 contact-innner">
                    <div class="col-lg-7">
                        <div class="contact-form">
                            <h3 class="mb-20">Laissez nous votre message</h3>
                            <p id="str-mess"></p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group name">
                                        <span style="color: black">Nom & Prenoms </span>
                                        <label for="" style="color: red">*</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            placeholder="Nom & Prenoms" aria-label="Full Name" pattern="/^-?\d+\.?\d*$/"
                                            onKeyPress="if(this.value.length==70) return false;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group email">
                                        <span style="color: black">Adresse email </span>
                                        <label for="" style="color: red">*</label>
                                        <input type="email" name="email" class="form-control" placeholder="Email"
                                            aria-label="Email Address" pattern="/^-?\d+\.?\d*$/" id="email"
                                            onKeyPress="if(this.value.length==50) return false;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group subject">
                                        <span style="color: black">Sujet </span>
                                        <label for="" style="color: red">*</label>
                                        <input type="text" name="subject" class="form-control" placeholder="Sujet"
                                            value="Souhaite avoir plus d'infos" aria-label="Subject" pattern="/^-?\d+\.?\d*$/"
                                           id="sujet" onKeyPress="if(this.value.length==100) return false;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group number">
                                        <span style="color: black">Contact </span>
                                        <label for="" style="color: red">*</label>
                                        <input type="text" name="phone" class="form-control" placeholder="Contact"
                                            aria-label="Phone Number" pattern="/^-?\d+\.?\d*$/" id="contact"
                                            onKeyPress="if(this.value.length==10) return false;">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group number">
                                        <span style="color: black">Adresse </span>
                                        <label for="" style="color: red">*</label>
                                        <input type="text" name="adresse" class="form-control" aria-label="Adresse"
                                            placeholder="Adresse (ville, commune, quartier, rue...)" id="adresse"
                                            pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==250) return false;">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group message">
                                        <span style="color: black">Message </span>
                                        <label for="" style="color: red">*</label>
                                        <textarea class="form-control" name="message" placeholder="Votre message"
                                        id="message" aria-label="Write message"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <p id="output"></p>
                                </div>
                                <div class="col-md-12">
                                    <div class="send-btn text-center">
                                        <button type="button" class="btn-6" onclick="savedata();">Envoyer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="contact-info">
                            <h3 class="mb-20">Contact Info</h3>
                            <div class="ca-box d-flex mb-30">
                                <i class="flaticon-pin me-3"></i>
                                <div class="detail">
                                    <h5>Adresse</h5>
                                    <a href="https://www.google.com/maps/search/Banque+de+l+Habitat+de+Cote+d+Ivoire+(BHCI)+Abidjan+CI+Av.+Anoma+Abidjan+Cote+d+Ivoire/5.320690317391832,-4.015781781578299"
                                        target="blank">
                                        <p>Abidjan, Plateau <br />
                                            01 BP 2325 Abidjan 01</p>
                                    </a>
                                </div>
                            </div>
                            <div class="ca-box d-flex mb-30">
                                <i class="flaticon-phone me-3"></i>
                                <div class="detail">
                                    <h5>Numero Tél</h5>
                                    <p><a href="tel:+225 20 25 39 38">+225 20 25 39 38</a></p>
                                    <p><a href="tel:+225 20 25 39 39">+225 20 25 39 39</a></p>
                                </div>
                            </div>
                            <div class="ca-box d-flex mb-30">
                                <i class="flaticon-mail me-3"></i>
                                <div class="detail">
                                    <h5>Email</h5>
                                    <p><a href="mailto:info@bhci.ci">info@bhci.ci</p>
                                </div>
                            </div>
                            <div class="ca-box d-flex">
                                <i class="flaticon-fax me-3"></i>
                                <div class="detail">
                                    <h5>Fax</h5>
                                    <p><a href="tel:+225 20 22 58 18">+225 20 22 58 18</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="section contact-2-map">
        {{-- <div class="map">
            <div id="map" class="contact-map"></div>
        </div> --}}
        <input class="form-control" value="5.320690317391832" id="lat" readonly hidden>
        <input class="form-control" value="-4.015781781578299" id="long" readonly hidden>
        <div class="map">
            <div class="map-content">
                <div id="singleMap" class="contact-map" data-latitude="5.320690317391832"
                    data-longitude="-4.015781781578299"></div>
            </div>
        </div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ Help::$API_KEY_HERE ?? 'API_KEY_HERE' }}&libraries=places">
    </script>
    <script src="{{ asset('site/js/map-add.js') }}"></script>

@endsection

@section('js')
    <script>

        function razChamps() {
            $('#output').text("");
            document.getElementById("name").value = "";
            document.getElementById("email").value = "";
            document.getElementById("contact").value = "";
            document.getElementById("adresse").value = "";
            document.getElementById("message").value = "";
            document.getElementById("sujet").value = "Souhaite avoir plus d'infos";
        }

        function savedata() {

            var ajaxmess = $('#output');
            var errorElement = $('#str-mess');
            errorElement.text("");
            errorElement.css('color', 'red');

            var rout = "{{ route('ajaxSendMessage') }}";

            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;
            var suj = document.getElementById("sujet").value;
            var cont = document.getElementById("contact").value;
            var adr = document.getElementById("adresse").value;
            var texte = document.getElementById("message").value;

            var errfield = checkfields(name, email, suj, cont, adr, texte);
            if (errfield != '') {
                errorElement.focus();
                errorElement.text(errfield);
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
                        NomPren: name,
                        Email: email,
                        Sujet: suj,
                        Contact: cont,
                        Adresse: adr,
                        Mess: texte,
                    },
                    success: function(res) {
                        console.log(res);
                        if (res.code != '200') {
                            ajaxmess.focus();
                            ajaxmess.text(res.mess);
                        }else{
                            ajaxmess.focus();
                            ajaxmess.text(res.mess);
                            ajaxmess.css('color', 'green');
                            setTimeout(razChamps, 5000);
                        }
                    },
                    error: function(res) {
                        console.log(res);
                        ajaxmess.focus();
                        ajaxmess.text('alert: Erreur interne du serveur !');
                    }
                });
            }

        }

        function checkEmail (email) {
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (re.test(email)) return true;
            else return false;
        }

        function checkfields(name, email, suj, cont, adr, mess) {
            if (name == '' || name.length < 7) {
                document.getElementById("name").focus();
                return "Veuillez definir un nom & prenoms valide, 7 caractères minimum.";
            }
            if (email == '' || checkEmail(email)==false) {
                document.getElementById("email").focus();
                return "Veuillez renseigner un email valide (jhoen@gmail.com)";
            }
            if (suj == '' || sujet.length < 10) {
                document.getElementById("sujet").focus();
                return "Veuillez indiquer un sujet valide pour votre message, 10 caractères minimum.";
            }
            if (cont == '' || cont.length < 10) {
                document.getElementById("contact").focus();
                return "Veuillez saisir un contact valide, 10 caractères";
            }
            if (adr == '' || adr.length < 20) {
                document.getElementById("adresse").focus();
                return "Veuillez renseigner une adresse valide, 20 caractères minimum. (ville, commune, quartier, rue...)";
            }
            if (mess == '' || mess.length < 30) {
                document.getElementById("message").focus();
                return "Veuillez renseigner un message de 20 caractères minimum.";
            }
            return '';
        }

    </script>
@endsection
