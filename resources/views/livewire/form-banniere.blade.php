<div>
    <div class="alert alert-2 alert-warning alert-dismissible fade show" role="alert" id="sv-mess"
        style="display: none">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="submit-address dashboard-list">
        <form method="post" action="#" enctype="multipart/form-data">
            <h4 class="bg-grea-3">
                <i class="fa fa-info"></i>&nbsp;
                @if (empty($banniere->ID_BANNIERES))
                    Nouvelle Saisie
                @else
                    Mise à Jour bannière n° <b>{{ $banniere->ID_BANNIERES ?? '' }}</b>
                @endif
            </h4>
            <div class="search-contents-sidebar">
                <div class="row pad-20">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group propertytitle">
                            <label class="form-label">Titre</label>
                            <input type="text" class="form-control @error('libelle') is-invalid @enderror"
                                wire:model="libelle" placeholder="Titre de la bannière" />
                            @error('libelle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group message">
                            <label class="form-label">Description</label>
                            <textarea type="text" class="form-control @error('description') is-invalid @enderror" wire:model="description"
                                placeholder="Description.." rows="4"></textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <p style="font-size: 100%">Joindre une image, taille maximum 2Mo </p>
                        <input type="file"
                            class="form-control @error('avatar') is-invalid @enderror
                        @error('avatar') is-invalid @enderror @error('avatar.*') is-invalid @enderror"
                            wire:model="avatar" accept=".jpg, .png, .jpeg" id="file-selector">

                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('avatar.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <p id="status"></p>
                        <img class="img-fluid" src="{{ asset($avatar ?? '') }}" id="output" wire:ignore />
                    </div>
                    <div class="col-md-12">
                        @error('ajaxmess')
                            <div class="text-center" style="color: red">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row pad-20">
                        <div class="col-12">
                            <button class="btn btn-primary" type="button" wire:click="valideForm();">
                                <i class="fa fa-fw fa-check-circle-o"></i>Valider
                            </button>
                            <button class="btn btn-outline-secondary" type="button" onclick="cancel();">
                                <i class="fa fa-fw fa-times-circle-o"></i>Annuler
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
