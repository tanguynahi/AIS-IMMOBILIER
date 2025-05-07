@extends('layouts.c_template', ['titre' => $titre])
@section('content')
    @include('partials.client.breadcrumb-navcli', ['LBL' => 'Profil'])

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

    <form action="{{route('profilValid')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="dashboard-list">
            <h3 class="heading">Mes informations</h3>
            <div class="dashboard-message contact-2 bdr clearfix">
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <div class="edit-profile-photo">
                            <img src="{{ asset($client->AVATAR ?? 'img/avatar/avatar-6.png') }}" class="img-fluid" id="output">
                            <div class="change-photo-btn">
                                <div class="photoUpload clip-home">
                                    <span><i class="fa fa-upload"></i></span>
                                    <input type="file" name="avatar" class="upload" accept=".jpg, .png, .jpeg" id="file-selector">
                                </div>
                            </div>
                        </div>
                        <p id="status"></p>
                        {{-- <img id="output" style="height: 25%; width: 40%; display: none"> --}}
                    </div>
                    <div class="col-lg-9 col-md-9">
                        <div class="row">
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group phone">
                                    <label for="nom" class="form-label">Nom *</label>
                                    <input type="text" name="nom" class="form-control" id="nom"
                                    value="{{ $client->NOM ?? '' }}" placeholder="Nom">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group phone">
                                    <label for="prenoms" class="form-label">Prenoms *</label>
                                    <input type="text" name="prenoms" class="form-control" id="prenoms"
                                    value="{{ $client->PRENOMS ?? '' }}" placeholder="Prenoms">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group phone">
                                    <label for="nationalite" class="form-label">Nationalité *</label>
                                    <input type="text" name="nationalite" class="form-control" id="nationalite"
                                    value="{{ $client->NATIONALITE ?? '' }}" placeholder="Nationalité">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group phone">
                                    <label for="pays" class="form-label">Pays *</label>
                                    <select class="form-control" id="pays" name="pays">
                                        <option value="" selected disabled>Choisir pays..</option>
                                        @foreach ($pays as $p)
                                            <option value="{{ $p->ID_PAYS }}"
                                                {{ $client->ID_PAYS == $p->ID_PAYS ? 'selected' : '' }}>
                                                {{ $p->LIB_PAYS }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group phone">
                                    <label for="pays" class="form-label">Ville *</label>
                                    <select class="form-control" id="ville" name="ville">
                                        <option value="" selected disabled>Choisir ville..</option>
                                        @foreach ($ville as $v)
                                            <option value="{{ $v->ID_VILLE }}"
                                                {{ $client->ID_VILLE == $v->ID_VILLE ? 'selected' : '' }}>
                                                {{ $v->LIB_VILLE }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group phone">
                                    <label for="boiteP" class="form-label">Boite Postale</label>
                                    <input type="text" name="boiteP" class="form-control" id="boiteP"
                                    value="{{ $client->BOITE_POSTALE ?? '' }}" placeholder="Boite Postale">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group phone">
                                    <label for="adresse" class="form-label">Adresse *</label>
                                    <input type="text" name="adresse" class="form-control" id="adresse"
                                    value="{{ $client->ADRESSE ?? '' }}" placeholder="Adresse (ville, commune, quartier, rue...)">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group phone">
                                    <label for="contact" class="form-label">Contact *</label>
                                    <input type="text" name="contact" class="form-control" id="contact"
                                    value="{{ $client->CONTACT ?? '' }}" placeholder="Contact">
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-9">
                                <div class="form-group email">
                                    <label for="adremail" class="form-label">Email *</label>
                                    <input type="email" name="email" class="form-control" id="adremail"
                                    value="{{ $client->ADR_EMAIL ?? '' }}" placeholder="Email" readonly>
                                    <p style="font-size: 90%; color: grey;">
                                    L'adresse email ne peut être modifié, il sert de login de connexion à votre compte.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="dashboard-list">
                    <h3 class="heading">Changer le mot de passe</h3>
                    <div class="dashboard-message contact-2">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group password">
                                    <label for="currentpass" class="form-label">Mot de passe actuel </label>
                                    <input type="password" name="currentpass" class="form-control"
                                    id="currentpass" placeholder="Mot de passe actuel">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group password">
                                    <label for="newpass" class="form-label">Nouveau mot de passe </label>
                                    <input type="password" name="newpass" class="form-control"
                                    id="newpass" placeholder="Nouveau mot de passe"><br />
                                    <p id="password-strength"></p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group password">
                                    <label for="confirmpass" class="form-label">
                                        Confirmer le nouveau mot de passe
                                    </label>
                                    <input type="password" name="confirmpass" class="form-control"
                                    id="confirmpass" placeholder="Confirmer le nouveau mot de passe">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="send-btn">
                                    <button type="submit" class="btn-6">Enregistrer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
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
                            'Error: La propriété File.type ne semble pas être prise en charge sur ce navigateur.';
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
            $('#newpass').on('input', function() {
                var tips = "";
                var strength = 0;
                var password = $(this).val();
                var passwordStrengthElement = $('#password-strength');
                if (password.length>0) verifieForceMotDePasse(password);
                else passwordStrengthElement.text("");
            });
        });
    </script>
@endsection
