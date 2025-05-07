<div class="row col-lg-12 pad-20">
    <label style="color: black"><b>Correspondant *</b></label>
    <div class="row">
        <div class="col-lg-4 mb-10">
            <input type="radio" name="choix" wire:model.defer="option1" id="r1" value="choix1">
            <label style="color: black">Autre</label>&nbsp;&nbsp;&nbsp;
            <input type="radio" name="choix" wire:model.defer="option2" id="r2" value="choix2">
            <label style="color: black">Client</label>
        </div>
    </div>
    <div class="col-lg-4 mb-10" @if ($option2===false) style="display: none;" @endif>
        <div class="form-group">
            <label>Client *</label>
            <select class="form-control" wire:model.defer="client">
                <option value="0">Choisir client..</option>
                @foreach ($clients as $c)
                    <option value="{{$c->ID_CLIENT}}">{{$c->NOM}} {{$c->PRENOMS}} ({{$c->CONTACT}})</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-4 mb-10" @if ($option1===false) style="display: none;" @endif>
        <div class="form-group">
            <span style="color: black">Nom & Prenoms </span>
            <label for="" style="color: black">*</label>
            <input type="text" class="form-control @error('nomprenoms') is-invalid @enderror"
            placeholder="Nom & Prenoms" aria-label="Full Name" pattern="/^-?\d+\.?\d*$/"
            onKeyPress="if(this.value.length==70) return false;" wire:model.defer="nomprenoms">
            @error('nomprenoms') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="col-lg-4 mb-10" @if ($option1===false) style="display: none;" @endif>
        <div class="form-group">
            <span style="color: black">Adresse email </span>
            <label for="" style="color: black">*</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror"
            placeholder="Adresse email" aria-label="Email Address" pattern="/^-?\d+\.?\d*$/"
            onKeyPress="if(this.value.length==50) return false;" wire:model.defer="email">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="@if ($option1===false && $option2===false) col-lg-12 mb-10 @else
        @if ($option2===true) col-lg-8 mb-10 @else col-lg-4 mb-10 @endif  @endif">
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
    <div class="col-lg-4 mb-10">
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
    <h4></h4>
    <div class="col-lg-12">
        <br />
        <div class="buttons mb-20">
            <a class="btn-1 btn-gray" type="button" onclick="cancel();">
                <i class="fa fa-fw fa-times-circle-o"></i> Fermer
            </a>
        </div>
    </div>
    <div class="col-lg-12"> <div class="text-center" id="outmess"></div> </div>
</div>

@script
<script>
    let type1 = document.querySelector("#r1");
    type1.addEventListener("click", choixTYPE);
    let type2 = document.querySelector("#r2");
    type2.addEventListener("click", choixTYPE);
    function choixTYPE(){
        // Récupérez l'élément contenant les boutons radio
        var rates = document.getElementsByName('choix');
        // Parcourez les boutons radio pour trouver celui qui est sélectionné
        var rate_value;
        for (var i = 0; i < rates.length; i++) {
            if (rates[i].checked) {
                rate_value = rates[i].value;
                break;
            }
        }
        console.log(rate_value);
        var ch1 = false;
        var ch2 = false;
        if (rate_value=='choix1') { ch1=true; }
        if (rate_value=='choix2') { ch2=true; }
        $wire.dispatch('updateWireChps', {ch1: ch1, ch2: ch2});
    }

</script>
@endscript
