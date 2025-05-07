@extends('layouts.a_template', ['titre' => $titre])
@section('content')
    {{-- @livewire('infos-entreprise', ['id' => $us->ID_ENTREPRISE, 'idcnx'=>$us->ID_UTILISATEUR]) --}}

    <div>

        @include('partials.manager.breadcrumb-nav', ['LBL' => $entreprise->RAISON_SOCIALE ?? 'XXXXXXX'])

        <div class="tabbing tabbing-box mb-50 dashboard-list">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (Help::optAutorise(['PAR', 'ACC', 'ZZZ'], $iduscnx))
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @if (Help::optAutorise(['PAR', 'ZZZ'], $iduscnx))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if ($compteopt == 1) active @endif" id="home-tab"
                                data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab"
                                aria-controls="home" aria-selected="true" wire:click="optionSelect(1)">Paramètres</button>
                        </li>
                    @endif
                    @if (Help::optAutorise(['ACC', 'ZZZ'], $iduscnx))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if ($compteopt == 2) active @endif" id="profile-tab"
                                data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab"
                                aria-controls="profile" aria-selected="false" wire:click="optionSelect(2)">Compte
                                utilisateur</button>
                        </li>
                    @endif
                </ul>
                <div class="tab-content" id="myTabContent">
                    @if (Help::optAutorise(['PAR', 'ZZZ'], $iduscnx))
                        <div class="tab-pane fade @if ($compteopt == 1) show active @endif" id="home"
                            role="tabpanel" aria-labelledby="home-tab">
                            <div class="accordion accordion-flush" id="accordionFlushExample7">
                                <div class="accordion-item">
                                    @include('pages.manager.dataentreprise')
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="tab-pane fade @if ($compteopt == 2) show active @endif" id="profile"
                        role="tabpanel" aria-labelledby="profile-tab">
                        <div class="accordion accordion-flush" id="accordionFlushExample2">
                            <div class="accordion-item">
                                {{-- @include('pages.manager.accountus') --}}
                                <livewire:account-form />
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>

    </div>

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
                if (password.length > 0) verifieForceMotDePasse(password);
                else passwordStrengthElement.text("");
            });
        });
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
