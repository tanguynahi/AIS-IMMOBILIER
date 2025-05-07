<form action="#" method="post">
    @csrf
    <div class="row" id="infos" style="display: none;">
        <input type="number" value="{{$client->ID_CLIENT ?? 0}}" id="cli" hidden>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="form-group" style="text-align: left">
                <label for="label-control">Civilité</label>
                <select class="form-control" id="civilite" @if(isset($client->CIVILITE)) disabled @endif>
                    <option value="" selected disabled>Choisir..</option>
                    <option value="1" @if($client->CIVILITE == 1) selected @endif>Monsieur</option>
                    <option value="2" @if($client->CIVILITE == 2) selected @endif>Madame</option>
                    <option value="3" @if($client->CIVILITE == 3) selected @endif>Mademoiselle</option>
                </select>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="form-group" style="text-align: left">
                <label for="label-control">Nom</label>
                <input type="text" id="nom" class="form-control" placeholder="Nom" aria-label="Nom"
                value="{{$client->NOM ?? ''}}" onKeyPress="if(this.value.length==20) return false;"
                pattern="/^-?\d+\.?\d*$/" @if(isset($client->NOM)) readonly @endif>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="form-group" style="text-align: left">
                <label for="label-control">Prenoms</label>
                <input type="text" id="prenoms" class="form-control" placeholder="Prenoms"
                aria-label="Prenoms" value="{{$client->PRENOMS ?? ''}}" pattern="/^-?\d+\.?\d*$/"
                onKeyPress="if(this.value.length==50) return false;"
                @if(isset($client->PRENOMS)) readonly @endif>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="form-group" style="text-align: left">
                <label for="label-control">Contact</label>
                <input type="text" id="contact" class="form-control" placeholder="Contact"
                aria-label="Contact" value="{{$client->CONTACT ?? ''}}" pattern="/^-?\d+\.?\d*$/"
                onKeyPress="if(this.value.length==10) return false;"
                @if(isset($client->CONTACT)) readonly @endif>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-group" style="text-align: left">
                <label for="label-control">Nationalité</label>
                <input type="text" id="nationalite" class="form-control" placeholder="Nationalite"
                aria-label="Nationalite" value="{{$client->NATIONALITE ?? ''}}" pattern="/^-?\d+\.?\d*$/"
                onKeyPress="if(this.value.length==30) return false;"
                @if(isset($client->NATIONALITE)) readonly @endif>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12" hidden>
            <div class="form-group" style="text-align: left">
                <label for="label-control">Pays</label>
                <select class="form-control" id="pays" @if(isset($client->ID_PAYS)) readonly @endif>
                    <option value="" selected disabled>Choisir pays..</option>
                    @foreach ($pays as $p)
                        <option value="{{$p->ID_PAYS}}" @if($idPays==$p->ID_PAYS) selected @endif>
                            {{$p->LIB_PAYS}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-12">
            <div class="form-group" style="text-align: left">
                <label for="label-control">Ville</label>
                <select class="form-control" id="ville" @if(isset($client->ID_VILLE)) disabled @endif>
                    <option value="" selected disabled>Choisir ville..</option>
                    @foreach ($villes as $v)
                        <option value="{{$v->ID_VILLE}}" @if($client->ID_VILLE==$v->ID_VILLE) selected @endif>
                            {{$v->LIB_VILLE}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group" style="text-align: left">
                <label for="label-control">Adresse</label>
                <input type="text" class="form-control" id="adresse" value="{{$client->ADRESSE ?? ''}}"
                placeholder="Adresse (ville, commune, quartier, rue...)" aria-label="Adresse"
                pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==250) return false;"
                @if(isset($client->ADRESSE)) readonly @endif>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group" style="text-align: left">
                <label for="label-control">Email</label>
                <input type="email" id="email" class="form-control"
                placeholder="Email" aria-label="Email Address" value="{{$client->ADR_EMAIL ?? ''}}"
                pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==50) return false;"
                @if(isset($client->ADR_EMAIL)) readonly @endif>
                <p @if(isset($us->ID_UTILISATEUR) && $us->ID_UTILISATEUR>0) style="color: gray; display: none;" @endif>
                    L'adresse email sera utilisé comme votre login de connexion à votre compte.
                </p>
            </div>
        </div>
    </div>
    <div class="row">
        @if(empty($us->ID_UTILISATEUR))
            <div class="col-lg-8 col-md-8 col-sm-12">
                <a type="button" onclick="form();" class="btn btn-outline-primary mb-20" id="newacc">
                    Je n'ai pas de compte
                </a>
                <p id="authACT" style="color: gray">
                    Avez-vous déjà un compte?&nbsp;
                    <a type="button" onclick="authLogin();" style="color:rgb(66, 66, 255)">
                        Connectez vous ici
                    </a>
                </p>
            </div>
        @endif
    </div>
</form>
