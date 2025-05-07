<div>
    <div class="submit-address dashboard-list">
        <h4 class="bg-grea-3"><i class="fa fa-info"></i>&nbsp;Informations de base</h4>
        <div class="search-contents-sidebar">
            <div class="row pad-20">
                <input type="number" class="form-control" wire:model="ID" hidden>
                <div class="col-lg-4 col-md-4 col-sm-12 mb-10">
                    <div class="form-group propertytitle">
                        <label for="libelle" class="form-label">Nom *</label>
                        <input type="text" placeholder="Nom agent"
                        class="form-control @error('nom') is-invalid @enderror" wire:model="nom">
                        @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 mb-10">
                    <div class="form-group propertytitle">
                        <label for="libelle" class="form-label">Prenoms *</label>
                        <input type="text" placeholder="Prenoms agent"
                        class="form-control @error('prenoms') is-invalid @enderror" wire:model="prenoms">
                        @error('prenoms') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 mb-10">
                    <div class="form-group">
                        <label for="contact" class="form-label">Contact</label>
                        <input type="text" placeholder="Contact agent" pattern="/^-?\d+\.?\d*$/"
                        class="form-control @error('contact') is-invalid @enderror" wire:model="contact"
                        onKeyPress="if(this.value.length==10) return false;">
                        @error('contact') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 mb-10">
                    <div class="form-group">
                        <label for="adremail" class="form-label">E-mail</label>
                        <input type="email" placeholder="Adresse e-mail agent" pattern="/^-?\d+\.?\d*$/"
                        class="form-control @error('adremail') is-invalid @enderror" wire:model="adremail"
                        onKeyPress="if(this.value.length==50) return false;">
                        @error('adremail') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-12 mb-10">
                    <div class="form-group">
                        <label>Fonction *</label>
                        <select class="form-control @error('fonctID') is-invalid @enderror" wire:model="fonctID">
                            <option value="">Choisir fonction..</option>
                            @foreach ($fonctions as $value)
                                <option value="{{$value->ID_FONCTION_PERS}}">{{$value->LIB_FONCTION}}</option>
                            @endforeach
                        </select>
                        @error('fonctID') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mb-10">
                    <div class="form-group propertytitle">
                        <label for="libelle" class="form-label">Lien Facebook </label>
                        <input type="text" placeholder="Lien page facebook"
                        class="form-control @error('urlfbk') is-invalid @enderror" wire:model="urlfbk">
                        @error('urlfbk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mb-10">
                    <div class="form-group propertytitle">
                        <label for="libelle" class="form-label">Lien Twitter </label>
                        <input type="text" placeholder="Lien page compte twitter"
                        class="form-control @error('urltwt') is-invalid @enderror" wire:model="urltwt">
                        @error('urltwt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 mb-10">
                    <label class="form-label" style="color: black"><b>Photo</b> </label>
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 mb-20">
                            <input type="file" id="{{ $imgID }}" accept=".jpg, .png, .jpeg"
                            class="form-control @error('image') is-invalid @enderror" placeholder="Choisir fichier"
                            wire:model.defer="image">
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                            <button class="btn btn-primary" wire:click="saveAgent">
                                <i class="fa fa-fw fa-check-circle-o"></i>Valider
                            </button>
                            <button class="btn btn-outline-secondary" type="button" onclick="cancel();">
                                <i class="fa fa-fw fa-times-circle-o"></i>Annuler
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 mb-10">
                    @error('ajaxmess') <div class="text-center" style="color: red">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>
</div>
