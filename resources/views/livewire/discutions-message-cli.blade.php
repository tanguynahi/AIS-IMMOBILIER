<div class="row pad-20">
    <div class="col-lg-12">
        @if(count($discutions)>0)
        @php (int) $n = 0; (int) $nb = count($discutions); @endphp
        @foreach($discutions as $key => $value)
        @php $n++; @endphp
        <div class="comment @if ($n==$nb) comment-b @endif">
            <div class="comment-author">
                <a>
                    <img src="@if($value->EST_RECEPTEUR===Help::$E) {{ asset($us->AVATAR ?? 'boy_icon-icons.png') }}
                    @else {{ asset($entreprise->LOGO ?? '4341274_120573.png') }} @endif">
                </a>
            </div>
            <div class="comment-content">
                <h6>
                    @if($value->EST_RECEPTEUR===Help::$C) {{ $entreprise->RAISON_SOCIALE ?? 'BMI-WFS' }}
                    @else <b style="color: grey; font-size: 14px">MOI</b> @endif
                </h6>
                <p> {{ $value->MESSAGE ?? 'contenu vide' }} </p>
                <div class="comment-meta">
                    <div class="comment-meta" style="color: grey; font-size: 14px">
                        {{ Help::dateheureFormate($value->DATECREA ?? 'MMJJAAAA', '/') }}
                        <a href="#">
                            @if($value->NB_FILES>0)
                                {{ $value->NB_FILES }} fichier(s)
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <p class="text-center">
            <i class="fa fa-angle-double-left"></i>
            <b >Aucune discusions trouvées.</b>
            <i class="fa fa-angle-double-right"></i>
        </p>
        @endif
        <br /><br />
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-10">
                <div class="form-group message">
                    <textarea class="form-control @error('texte') is-invalid @enderror" wire:model.defer="texte" 
                    rows="3" onKeyPress="if(this.value.length==300) return false;" placeholder="Message.."></textarea>
                    @error('texte') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 mb-10">
                <input type="file" class="form-control" multiple id="{{$fichID}}" accept=".jpg, .png, .jpeg, .pdf" 
                wire:model.defer="fichier">
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 mb-10">
                <div class="form-group message">
                    <a class="btn btn-primary" type="button" wire:click="sendMessage" title="Envoyer">
                        <i class="fa fa-fw fa-send"></i> Envoyer
                    </a>
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
    </div>
    <div class="col-lg-12"> <div class="text-center" id="outmess"></div> </div>
</div>
