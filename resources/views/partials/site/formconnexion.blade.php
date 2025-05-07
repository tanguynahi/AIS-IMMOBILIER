<form action="#" method="post">
    @csrf
    <div class="row" id="authLOG" style="display: none;">
        <div class="col-lg-12">
            <div class="form-group form-box" style="text-align: left">
                <label for="label-control">Login</label>
                <input type="text" name="Login" class="form-control"
                    placeholder="Entrez votre login" aria-label="Login" id="Login"
                    pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==50) return false;">
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group form-box" style="text-align: left">
                <label for="label-control">Mot de Passe</label>
                <input type="password" name="MotDePasse" class="form-control" autocomplete="off"
                    placeholder="Mot de passe" aria-label="Password" id="MotDePasse"
                    pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==30) return false;">
                <span class="eye"><i class="fa fa-eye"></i> </span>
            </div>
        </div>
        <div class="col-lg-6"><a href="#" style="color: gray">Mot de Passe oublié?</a></div>
        <div class="form-group">
            <div class="text-center" id="output" style="color: red"></div>
        </div>
        <div class="form-group">
            <button type="button" class="btn-md btn-theme w-100" onclick="markAsCnx({{$proprietes->ID_PROPRIETES ?? 0}});">
            Connexion</button>
        </div>
        <p style="color: gray">Vous n'avez pas de compte ?
            <a type="button" onclick="form();" style="color:rgb(66, 66, 255)" id="newacc">
                Saisissez vos informations ici
            </a>
        </p>
    </div>
</form>
