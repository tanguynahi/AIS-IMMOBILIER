<div>
    <div class="submit-address dashboard-list">
        <h4 class="bg-grea-3"><i class="fa fa-info"></i>&nbsp;Informations de base</h4>
        <div class="search-contents-sidebar">
            <div class="row pad-20">
                <input type="number" class="form-control" wire:model="ID" hidden>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group propertytitle">
                        <label for="libelle" class="form-label">Designation *</label>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-12 mb-20">
                                <input type="text" placeholder="Designation"
                                class="form-control @error('libfonction') is-invalid @enderror" wire:model="libfonction">
                                @error('libfonction') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                                <button class="btn btn-primary" wire:click="saveFonction">
                                    <i class="fa fa-fw fa-check-circle-o"></i>Valider
                                </button>
                                <button class="btn btn-outline-secondary" type="button" onclick="cancel();">
                                    <i class="fa fa-fw fa-times-circle-o"></i>Annuler
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    @error('ajaxmess') <div class="text-center" style="color: red">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>
</div>
