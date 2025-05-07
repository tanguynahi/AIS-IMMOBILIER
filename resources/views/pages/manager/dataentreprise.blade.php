<div class="dashboard-message contact-2 bdr clearfix">
    <form action="{{ route('store.entreprise', ['id' => $entreprise->ID_ENTREPRISE]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('post')
        {{-- {{ route('store.entreprise', ['id' => $entreprise->ID_ENTREPRISE]) }} --}}
        <div class="row">
            {{-- <div class="col-lg-3 col-md-3">
                <div class="edit-profile-photo">
                    <img src="{{ asset($logo ?? 'img/avatar/avatar-6.png') }}" class="img-fluid" id="output"
                        wire:ignore>
                    <div class="change-photo-btn">
                        <div class="photoUpload clip-home">
                            <span><i class="fa fa-upload"></i></span>
                            <input type="file" class="upload" accept=".jpg, .png, .jpeg" wire:model="logo"
                                id="file-selector">
                        </div>
                    </div>
                </div>
                <p id="status"></p>
            </div> --}}

            <div class="col-lg-3 col-md-3">
                <div class="edit-profile-photo">
                    <img src="{{ asset($entreprise->LOGO ?? 'img/avatar/avatar-6.png') }}" class="img-fluid"
                        id="output">
                    <!-- Par défaut, l'image est masquée -->
                    <div class="change-photo-btn">
                        <div class="photoUpload clip-home">
                            <span><i class="fa fa-upload"></i></span>
                            <input type="file" class="upload" accept=".jpg, .png, .jpeg" name="logo"
                                id="file-selector">
                        </div>
                    </div>
                </div>
                <p id="status"></p>
            </div>

            {{-- <div class="col-lg-9 col-md-9">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group phone">
                            <label for="raisonsociale" class="form-label">Raison sociale *</label>
                            <input type="text" class="form-control" wire:model="raisonsociale"
                                placeholder="Raison sociale">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group phone">
                            <label for="adresse" class="form-label">Adresse *</label>
                            <input type="text" class="form-control" wire:model="adresse"
                                placeholder="Adresse (ville, commune, quartier, rue...)">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group phone">
                            <label for="contact" class="form-label">Contact 1 *</label>
                            <input type="text" class="form-control" wire:model="contact1" placeholder="Contact 1">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group phone">
                            <label for="contact" class="form-label">Contact 2 *</label>
                            <input type="text" class="form-control" wire:model="contact2" placeholder="Contact 2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 mb-4">
                <div class="row mb-4">
                    <div class="col-lg-5 col-md-5">
                        <div class="form-group email">
                            <label for="adremail" class="form-label">Email *</label>
                            <input type="email" class="form-control" wire:model="adremail"
                                value="{{ $entreprise->ADR_EMAIL ?? '' }}" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group phone">
                            <label for="SLOGAN" class="form-label">Slogan *</label>
                            <input type="text" class="form-control" wire:model="slogan" placeholder="Slogan">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group message">
                            <label for="descriptif" class="form-label">Descriptif *</label>
                            <textarea class="form-control @error('texte') is-invalid @enderror" wire:model="descriptif" rows="2"
                                onKeyPress="if(this.value.length==300) return false;" placeholder="Message.."></textarea>
                            @error('texte')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group phone">
                            <label for="urlfbk" class="form-label">Url Facebook</label>
                            <input type="text" class="form-control" wire:model="urlfbk" placeholder="Url Facebook">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group phone">
                            <label for="urltwt" class="form-label">Url Twitter</label>
                            <input type="text" class="form-control" wire:model="urltwt" placeholder="Url twitter">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group phone">
                            <label for="urllink" class="form-label">Url Linkedin</label>
                            <input type="text" class="form-control" wire:model="urllink"
                                placeholder="Url Linkedin">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group phone">
                            <label for="urldemo" class="form-label">Url Vidéo</label>
                            <input type="text" class="form-control" wire:model="urldemo"
                                placeholder="Url vidéo illustrative">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 text-center">
                        @error('ajaxmess')
                            <span class="badge bg-danger-subtle text-danger"> {{ $message }} </span>
                        @enderror
                        @error('ajaxmessR')
                            <span class="badge bg-success-subtle text-success"> {{ $message }} </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="send-btn">
                    <button wire:click="validInfos" class="btn-6">Enregistrer</button>
                </div>
            </div> --}}
            <div class="col-lg-9 col-md-9">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group phone">
                            <label for="raisonsociale" class="form-label">Raison sociale
                                <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('raisonsociale') is-invalid @enderror"
                                name="raisonsociale" id="raisonsociale"
                                value="{{ old('raisonsociale', $entreprise->RAISON_SOCIALE) }}"
                                placeholder="Raison sociale">

                            @error('raisonsociale')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="form-group phone">
                            <label for="adresse" class="form-label">Adresse <span class="text-danger">*</span></label>
                            <input type="text" id="adresse"
                                class="form-control @error('adresse') is-invalid @enderror" name="adresse"
                                value="{{ old('adresse', $entreprise->ADRESSE) }}"
                                placeholder="Adresse (ville, commune, quartier, rue...)">
                            @error('adresse')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group phone">
                            <label for="contact1" class="form-label">Contact 1 <span
                                    class="text-danger">*</span></label>
                            <input type="tel" name="contact1" id="contact1"
                                value="{{ old('contact1', $entreprise->CONTACT1) }}"
                                class="form-control @error('contact1') is-invalid @enderror" placeholder="Contact 1">
                            @error('contact1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group phone">
                            <label for="contact2" class="form-label">Contact 2 <span
                                    class="text-danger">*</span></label>
                            <input type="tel" name="contact2" id="contact2"
                                value="{{ old('contact2', $entreprise->CONTACT2) }}"
                                class="form-control @error('contact2') is-invalid @enderror" placeholder="Contact 2">
                            @error('contact2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-12 col-md-12 mb-4">
                <div class="row mb-4">
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group email">
                            <label for="adremail" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('adremail') is-invalid @enderror"
                                name="adremail" id="adremail" value="{{ old('adremail', $entreprise->ADR_EMAIL) }}"
                                placeholder="Email">
                            @error('adremail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5">
                        <div class="form-group phone">
                            <label for="SLOGAN" class="form-label">Slogan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="slogan" id="slogan"
                                value="{{ old('slogan', $entreprise->SLOGAN) }}" placeholder="Slogan">
                            @error('slogan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group phone">

                            <label for="SLOGAN" class="form-label">Terms de Conditions
                                <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="termsconditions" id="termsconditions"
                                value="{{ old('termsconditions', $entreprise->TERMS_CONDITIONS) }}"
                                placeholder="Slogan" accept=".pdf">
                            @if (!empty($entreprise->TERMS_CONDITIONS))
                                <a href="{{ $entreprise->TERMS_CONDITIONS }}" target="_target">
                                    <img src="{{ asset('assets/pdf.png') }}" alt="terms de conditions"
                                        style="height: 25px; width:25px;">
                                </a>
                            @endif
                            @error('termsconditions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group message">
                            <label for="descriptif" class="form-label">Descriptif <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('descriptif') is-invalid @enderror" rows="2" id="descriptif"
                                name="descriptif" onKeyPress="if(this.value.length==300) return false;" placeholder="Message..">{{ old('descriptif', $entreprise->DESCRIPTIF) }}</textarea>
                            @error('descriptif')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group phone">
                            <label for="urlfbk" class="form-label">Url Facebook</label>
                            <input type="text" class="form-control @error('urlfbk') is-invalid @enderror"
                                name="urlfbk" id="urlfbk" value="{{ old('urlfbk', $entreprise->URLFBK) }}"
                                placeholder="Url Facebook">
                            @error('urlfbk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group phone">
                            <label for="urltwt" class="form-label">Url Twitter</label>
                            <input type="text" class="form-control @error('urltwt') is-invalid @enderror"
                                name="urltwt" id="urltwt" value="{{ old('urltwt', $entreprise->URLTWT) }}"
                                placeholder="Url twitter">
                            @error('urltwt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="form-group phone">
                            <label for="urllink" class="form-label">Url Linkedin</label>
                            <input type="text" class="form-control @error('urllink') is-invalid @enderror"
                                name="urllink" id="urllink" value="{{ old('urllink', $entreprise->URLLINK) }}"
                                placeholder="Url Linkedin">
                            @error('urllink')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group phone">
                            <label for="urldemo" class="form-label">Url Vidéo</label>
                            <input type="text" class="form-control @error('urldemo') is-invalid @enderror"
                                name="urldemo" id="urldemo" value="{{ old('urldemo', $entreprise->URLDEMO) }}"
                                placeholder="Url vidéo illustrative">
                            @error('urldemo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 text-center">
                        @error('ajaxmess')
                            <span class="badge bg-danger-subtle text-danger"> {{ $message }}
                            </span>
                        @enderror
                        @error('ajaxmessR')
                            <span class="badge bg-success-subtle text-success">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="send-btn">
                    <button type="submit" class="btn-6">Enregistrer</button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('js')
    <script>
        const status = document.getElementById('status');
        const output = document.getElementById('output');
        if (window.FileList && window.File && window.FileReader) {
            document.getElementById('file-selector').addEventListener('change', event => {
                output.src = ''; // Réinitialiser l'aperçu de l'image
                status.textContent = ''; // Réinitialiser le statut
                const file = event.target.files[0]; // Récupérer le fichier sélectionné

                if (!file) { // Vérifier si aucun fichier n'est sélectionné
                    $("#output").hide();
                    return;
                }

                // Vérifier si le type du fichier est supporté
                if (!file.type) {
                    status.textContent =
                        'Error: La propriété File.type ne semble pas être prise en charge sur ce navigateur.';
                    return;
                }

                // Vérifier si le fichier est bien une image
                if (!file.type.match('image.*')) {
                    status.textContent = 'Error: Le fichier sélectionné ne semble pas être une image.';
                    return;
                }

                const reader = new FileReader();
                reader.addEventListener('load', event => {
                    output.src = event.target.result; // Afficher l'image en tant qu'aperçu
                    $("#output").show(); // Afficher l'image
                });
                reader.readAsDataURL(file); // Lire le contenu du fichier
            });
        }
    </script>
@endpush
