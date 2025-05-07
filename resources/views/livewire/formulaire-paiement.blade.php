<div class="submit-address dashboard-list">
    <br />
    <a type="button" onclick="cancel();"
        class="mb-10" style="margin-left: 20px">
        <i class="fa fa-angle-double-left"></i>&nbsp;<b>Acceder à la liste des Paiments</b>
    </a>
    <form method="post" action="#" id="form-liais">
        <h4 class="bg-grea-3"><i class="fa fa-info"></i>&nbsp;Informations Générale</h4>
        <div class="search-contents-sidebar">
            <div class="row pad-20">
                <div class="col-lg-7 col-md-7 col-sm-12">
                    <input class="form-control" id="idLiais" name="idLiais" style="display: none;">
                    <input class="form-control" id="idP" style="display: none;">
                    <input class="form-control" id="param" value="{{$id ?? '0'}}" style="display: none;">
                    <div class="form-group">
                        <label>Biens *</label>
                        <select class="form-control" wire:model="AffID" wire:change='getListFacturation()'>
                        {{-- <select class="form-control" id="aff_id"> --}}
                            <option value="0">Choisir bien..</option>
                            @foreach ($affaires as $c)
                                <option value="{{$c->ID_AFFAIRES}}" @if($c->ID_AFFAIRES==$AffID) selected @endif>
                                    ({{ $c->LIB_TYPE ?? '' }}) {{ $c->LIB_PROPRIETE ?? '' }} | {{ $c->LIB_CATEGORIE ?? ''}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <div class="form-group">
                        <label>Redevances </label>
                        <select class="form-control" id="liais_id">
                            <option value="0">Choisir redevance..</option>
                            @foreach ($redevances as $value)
                            <option value="{{ $value->ID_LIAIS }}" @if($value->ID_LIAIS==$LiasID) selected @endif>
                                {{ $value->LIB_REDEVANCES }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 row" id="chp_redev" style="display: none;">
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="period" class="form-label">Paiement </label>
                            <input type="text" class="form-control" id="period" readonly>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12" id="mont_id" style="display: none;">
                        <div class="form-group">
                            <label for="mont_period" class="form-label">Montant Periodique *</label>
                            <input type="text" class="form-control" id="mont_period" readonly>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="freq" class="form-label">Frequence *</label>
                            <input type="text" class="form-control" id="freq" readonly>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="total_mont" class="form-label">Total à Payer</label>
                            <input type="text" class="form-control" id="total_mont" readonly>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="total_paye" class="form-label">Total Payé</label>
                            <input type="text" class="form-control" id="total_paye" readonly>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="rest_paye" class="form-label">Reste à Payer</label>
                            <input type="text" class="form-control" id="rest_paye" readonly>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="date" class="form-label">Date facturation</label>
                            <input type="date" class="form-control" id="date" readonly>
                        </div>
                    </div>
                </div>
                <div class="text-center" id="outredv"></div>
            </div>
        </div>
        <div id="formPAY" style="display: none;">
            <h4 class="bg-grea-3"><i class="fa fa-info"></i>&nbsp;Informations Paiement</h4>
            <div class="search-contents-sidebar">
                <div class="row pad-20">
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label>Mode de paiement *</label>
                            <select class="form-control" id="moyen">
                                <option value="0" selected disabled>Choisir moyen..</option>
                                <option value="2">Cash</option>
                                <option value="3">Chèque</option>
                                <option value="4">Virement</option>
                                <option value="5">En Ligne</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12" id="montID">
                        <div class="form-group">
                            <label>Montant *</label>
                            <input type="number" class="form-control" id="mont" name="mont">
                        </div>
                    </div>
                    <div id="compID" style="display: none;"> @livewire('creation-paiement',['idL'=>$LiasID ?? 0]) </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label style="color: white">chgvjhb</label>
                            <button type="button" onclick="onlinePAY();" id="btn2" style="display: none;" class="btn-6"
                            style="margin-left: 20px">Passez au paiement </button>
                        </div>
                    </div>
                    <div class="text-center" id="outmess"></div>
                </div>
            </div>
        </div>
    </form>
</div>

@script
<script>
    $("#moyen").on('change', function() {
        var m = $("#moyen").val();
        if (m<5 && m>0) {
            $("#compID").show('1000');
            $("#btn2").hide();
            $("#montID").hide();
            var idL = document.getElementById("liais_id").value;
            $wire.dispatch('updateWireChps', { idS: m, idL: idL});
        }else{ $("#compID").hide('1000'); $("#btn2").show(); $("#montID").show(); }
    });
    actionLiaison();
</script>
@endscript

