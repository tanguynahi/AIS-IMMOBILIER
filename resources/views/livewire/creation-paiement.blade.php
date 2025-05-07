<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-12">
        <div class="form-group">
            <label>Reférence *</label>
            <input type="text" class="form-control @error('reference') is-invalid @enderror" wire:model.defer="reference"
            onKeyPress="if(this.value.length==20) return false;">
            @error('reference') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-12">
        <div class="form-group">
            <label>Date *</label>
            <input type="date" class="form-control @error('date') is-invalid @enderror" wire:model.defer="date">
            @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-12" hidden>
        <div class="form-group">
            <label>Heure </label>
            <input type="time" class="form-control" wire:model.defer="heure">
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-12">
        <div class="form-group">
            <label>Montant *</label>
            <input type="number" class="form-control @error('montant') is-invalid @enderror" wire:model.defer="montant">
            @error('montant') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-12 mb-10">
        <label class="form-label">Document de paiement</label>
        {{-- <input type="file" multiple id="{{$fichID}}" accept=".jpg, .png, .jpeg"
        class="form-control @error('fichier') is-invalid @enderror @error('fichier.*') is-invalid @enderror"
        placeholder="Choisir fichier" wire:model.defer="fichier"> --}}
        <input type="file" multiple id="{{$fichID}}" accept=".jpg, .png, .jpeg"
    class="form-control @error('fichier') is-invalid @enderror @error('fichier.*') is-invalid @enderror"
    placeholder="Choisir fichier" wire:model="fichier" wire:key="upload-file">
        @error('fichier') <div class="invalid-feedback">{{ $message }}</div> @enderror
        @error('fichier.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
        {{-- @dd($errors) --}}
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 mb-10">
        @error('idLIAIS') <div class="text-center" style="color: blue">{{ $message }}</div> @enderror
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 mb-10">
        @error('serviceID') <div class="text-center" style="color: blue">{{ $message }}</div> @enderror
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 mb-10">
        @error('ajaxmessV') <div class="text-center" style="color: red">{{ $message }}</div> @enderror
    </div>
    <div class="col-lg-6 col-md-12 col-sm-12">
        <button type="button" wire:click="savePaiement" class="btn-6">Enregistrer </button>
    </div>
</div>
