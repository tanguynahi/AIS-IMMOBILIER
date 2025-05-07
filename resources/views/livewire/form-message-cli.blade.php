<div class="row pad-20">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-10">
                <div class="form-group">
                    <span style="color: black">Sujet </span>
                    <label for="" style="color: black">*</label>
                    <input type="text" class="form-control @error('sujet') is-invalid @enderror" 
                    placeholder="Sujet" value="Sujet du message" aria-label="Subject" pattern="/^-?\d+\.?\d*$/"
                    onKeyPress="if(this.value.length==100) return false;" wire:model.defer="sujet">
                    @error('sujet') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 mb-10">
                <div class="form-group message">
                    <textarea class="form-control @error('texte') is-invalid @enderror" wire:model.defer="texte" 
                    rows="3" onKeyPress="if(this.value.length==300) return false;" placeholder="Message.."></textarea>
                    @error('texte') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 mb-10">
                <input type="file" class="form-control" multiple id="{{$fichID ?? 0}}" accept=".jpg, .png, .jpeg, .pdf" 
                wire:model.defer="fichier">
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 mb-10">
                <div class="form-group message">
                    <a class="btn btn-primary" type="button" wire:click="sendMessage" title="Envoyer">
                        <i class="fa fa-fw fa-send"></i> Envoyer
                    </a>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 mb-10">
                @error('ajaxmess') <div class="text-center" style="color: red">{{ $message }}</div> @enderror
            </div>
        </div>
        <h4></h4>
        <div class="col-lg-12">
            <br />
            <div class="buttons mb-20">
                <a class="btn-1 btn-gray" type="button" onclick="cancel();">
                    <i class="fa fa-fw fa-times-circle-o"></i> Fermer
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-12"> <div class="text-center" id="outmess"></div> </div>
</div>
