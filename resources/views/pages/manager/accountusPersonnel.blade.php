<div class="dashboard-message contact-2 bdr clearfix">



    {{-- @if ($formcompte == 0 )
        <div class="listjs-table" id="customerList" >
            <div class="row g-4 mb-0">
                <div class="col-sm-auto">
                    <div>

                        <button type="button" class="btn btn-outline-primary" style="margin-left: 20px"
                           >
                            <i class="fa fa-plus"></i>&nbsp;&nbsp;Nouveau compte
                        </button>



                    </div>
                </div>
                <div class="col-sm">
                    <div class="d-flex justify-content-sm-end">
                        <div class="search-box ms-2">
                            <input type="text" class="form-control search" placeholder="Recherche...">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive mb-1">
                <table class="table align-middle table-nowrap" id="customerTable">
                    <thead class="bg-active-2" style="color: white">
                        <tr>
                            <th class="sort" data-sort="id">Nom</th>
                            <th class="sort" data-sort="customer_name">Prenoms</th>
                            <th class="sort" data-sort="leads_score">Contact</th>
                            <th class="sort" data-sort="location">Fonction</th>
                            <th class="sort" data-sort="email">Login</th>
                            <th class="sort" data-sort="status">Status</th>
                            <th class="sort" data-sort="action">Action</th>
                        </tr>
                    </thead>
                    <tbody class="list form-check-all">
                        @foreach ($comptes as $key => $value)
                            <tr>
                                <td class="id"> {{ $value->NOM ?? 'x' }} </td>
                                <td class="customer_name">{{ $value->PRENOMS ?? 'xxxxxx' }}</td>
                                <td class="leads_score">{{ $value->CONTACT ?? 'xxxxxxxxxx' }}</td>
                                <td class="location">{{ $value->LIB_FONCTION ?? 'x' }}</td>
                                <td class="email">{{ $value->LOGIN ?? '**********' }}</td>
                                <td class="status">
                                    @if ($value->STATUT == Help::$ACTIF)
                                        <span class="badge bg-success-subtle text-success text-uppercase">
                                            ACTIF
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger text-uppercase">
                                            INACTIF
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="buttons">
                                            <a type="button"
                                                wire:click="accountForm(1, {{ $value->ID_UTILISATEUR ?? '0' }})"
                                                class="btn-1 btn-gray" title="Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="noresult" style="display: none">
                    <div class="text-center">
                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                            colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                        </lord-icon>
                        <h5 class="mt-2">Désolé! Aucun résultat trouvé</h5>
                        <p class="text-muted mb-0">
                            Nous avons recherché plus de 50 comptes.
                            Nous n'avons trouvé aucun pour votre recherche.
                        </p>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <div class="pagination-wrap hstack gap-2">
                    <a class="page-item pagination-prev disabled" href="#">
                        <i class="fa fa-angle-double-left"></i>
                    </a>
                    <ul class="pagination listjs-pagination mb-0"></ul>
                    <a class="page-item pagination-next" href="#">
                        <i class="fa fa-angle-double-right"></i>
                    </a>
                </div>
            </div>
        </div>
    @endif --}}
    @if ($formcompte == 1)
        <div id="formCompte" >
            <h6><b><u>Informations Compte</u></b></h6>
            <div class="row mb-4">
                <div class="@if (!empty($idus)) col-lg-8 col-md-8 @else col-lg-5 col-md-5 @endif">
                    <div class="form-group" wire:ignore>
                        <label for="agent" class="form-label">Agents/Personnels *</label>
                        <select class="form-control" wire:model="idpersonnel"
                            @if (!empty($idus)) disabled @endif>
                            <option value="0">Choisir..</option>
                            {{-- @foreach ($personnels as $p)
                            <option value="{{ $p->ID_PERSONNELS }}">
                                {{ $p->LIB_PERS }}
                            </option>
                        @endforeach --}}
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="form-group login">
                        <label for="login" class="form-label">Login *</label>
                        <input type="text" class="form-control" wire:model="login"
                            @if (!empty($idus)) disabled @endif placeholder="Login">
                    </div>
                </div>
                {{-- @if ($passcnx == false)
                <div class="col-lg-3 col-md-3" @if (!empty($idus)) hidden @endif>
                    <div class="form-group motdepasse">
                        <label for="motdepasse" class="form-label">Mot de Passe *</label>
                        <input type="password" class="form-control" autocomplete="off" placeholder="Mot de passe"
                            id="MotDePasse" wire:model="motdepasse" pattern="/^-?\d+\.?\d*$/"
                            onKeyPress="if(this.value.length==30) return false;">
                    </div>
                </div>
            @endif --}}
                <div class="col-lg-4 col-md-4 mb-4" hidden>
                    <br />
                    <div class="checkbox checkbox-theme checkbox-circle">
                        <br />
                        <input id="checkbox2" type="checkbox" wire:model="passcnx" wire:change="passChange"
                            @if (!empty($idus)) disabled @endif>
                        <label for="checkbox2" class="form-label">Mot de Passe à la connexion ?</label>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 text-center">
                    @error('ajaxmess')
                        <span class="badge bg-danger-subtle text-danger"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
            <h6><b><u>Roles fonctionnalité</u></b></h6>
            <div class="row">
                {{-- @foreach ($roles as $key => $value)
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                    <div class="checkbox checkbox-theme checkbox-circle">
                        <input id="{{ $value->CODE_ACCES }}" type="checkbox" wire:model="{{ $value->CODE_ACCES }}">
                        <label for="{{ $value->CODE_ACCES }}">{{ $value->LIB_ACCES }} </label>
                    </div>
                </div>
            @endforeach --}}
                <br /><br />
                <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                    <button class="btn btn-danger" wire:click="validCompte">
                        <i class="fa fa-fw fa-check-circle-o"></i>Valider
                    </button>
                    <button class="btn btn-outline-secondary" type="button" wire:click="accountForm(0, 0)">
                        <i class="fa fa-fw fa-times-circle-o"></i>Annuler
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>


