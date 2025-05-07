<div class="">
    <div class="card-body">
        <div class="listjs-table" id="customerList">
            <div class="row mb-0">
                <h6><u>Filtrer Par</u></h6>
                <div class="col-lg-2 mb-10">
                    <div class="form-group">
                        <label>Du </label>
                        <input type="date" class="form-control @error('datemin') is-invalid @enderror" wire:model.defer="datemin">
                        @error('datemin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-lg-2 mb-10">
                    <div class="form-group">
                        <label>Au </label>
                        <input type="date" class="form-control @error('datemax') is-invalid @enderror" wire:model.defer="datemax">
                        @error('datemax') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-lg-7 mb-10">
                    <div class="form-group">
                        <label>Biens </label>
                        <select class="form-control" wire:model.defer="idaffaire" wire:change="getfacturationaffaire">
                            <option value="0">Tous..</option>
                            @foreach ($affaires as $aff)
                            <option value="{{ $aff->ID_AFFAIRES ?? 0 }}">
                                ({{ $aff->LIB_TYPE ?? 'xxx' }}) {{ $aff->LIB_PROPRIETE ?? 'xxxxx' }}
                                | {{ $aff->LIB_CATEGORIE ?? 'xxxxx' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 mb-10">
                    <div class="form-group">
                        <label>Facturation </label>
                        <select class="form-control" wire:model.defer="idliaison" wire:change="downloadList">
                            <option value="0">Tous..</option>
                            @foreach ($liaisons as $l)
                            <option value="{{ $l->ID_LIAIS ?? 0 }}">
                                {{ $l->LIB_REDEVANCES ?? 'xxxxxxx' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 mb-10">
                    <div class="form-group">
                        <div class="search-box ms-2">
                            <label>Recherche libre </label>
                            <input type="text" class="form-control search" placeholder="Recherche...">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-10">
                    <div class="form-group">
                        <label style="color: white">xxxxxxxxx</label>
                        <a href="{{route('nouvPaiement', ['id'=>0])}}" class="btn btn-outline-primary" style="margin-left: 20px">
                            <i class="fa fa-plus"></i>&nbsp;&nbsp;Nouveau Paiement
                        </a>
                    </div>
                </div>
                <div class="text-left mb-1" id="output"></div>
            </div>
            <div class="table-responsive mb-1">
                <table class="table align-middle table-nowrap" id="customerTable">
                    <thead class="bg-active-2" style="color: white">
                        <tr>
                            <th class="sort" data-sort="name">Redevance</th>
                            <th class="sort" data-sort="customer_name">Reference</th>
                            <th class="sort" data-sort="email">Moyen</th>
                            <th class="sort" data-sort="phone">Montant</th>
                            <th class="sort" data-sort="date">Date</th>
                            <th class="sort" data-sort="status">Status</th>
                            <th class="sort" data-sort="action">Action</th>
                        </tr>
                    </thead>
                    <tbody class="list form-check-all">
                        @foreach($paiements as $key => $value)
                        <tr>
                            <td class="name">{{$value->LIB_REDEVANCES ?? 'xxxxxx'}}</td>
                            <td class="customer_name">{{$value->REFERENCE_P ?? 'xxxxxx'}}</td>
                            <td class="email">{{$value->LIB_SERVICE_ID ?? 'xxxxxx'}}</td>
                            <td class="phone">{{ Help::formatNombre($value->MONTANT ?? '0', true) }}</td>
                            <td class="date">{{$value->DATE_PAIEMENT ?? 'AAAA-MM-JJ'}}</td>
                            <td class="status">
                                @switch($value->STATUT)
                                    @case("1")
                                        @if($value->SERVICE_ID>4)
                                        <span class="badge bg-primary-subtle text-primary text-uppercase">EN ATTENTE</span>
                                        @else
                                        <span class="badge bg-success-subtle text-success text-uppercase">VALIDE</span>
                                        @endif
                                    @break
                                    @case("2")
                                        @if($value->SERVICE_ID>4)
                                        <span class="badge bg-success-subtle text-success text-uppercase">VALIDE</span>
                                        @else
                                        <span class="badge bg-danger-subtle text-danger text-uppercase">ERREUR</span>
                                        @endif
                                    @break
                                    @case("3")
                                        @if($value->SERVICE_ID==2 || $value->SERVICE_ID==3 || $value->SERVICE_ID==4)
                                        <span class="badge bg-primary-subtle text-primary text-uppercase">EN ATTENTE</span>
                                        @else
                                        <span class="badge bg-danger-subtle text-danger text-uppercase">ANNULE</span>
                                        @endif
                                    @break
                                    @case("4")
                                        @if($value->SERVICE_ID==2 || $value->SERVICE_ID==3 || $value->SERVICE_ID==4)
                                        <span class="badge bg-danger-subtle text-danger text-uppercase">REJETE</span>
                                        @else
                                        <span class="badge bg-danger-subtle text-danger text-uppercase">ECHEC</span>
                                        @endif
                                    @break
                                    @default
                                    <span class="badge bg-primary-subtle text-primary text-uppercase">NON DEFINI</span>
                                @endswitch
                            </td>
                            <td>
                                <div class="buttons">
                                    <a href="{{route('paiemCliForm', ['idPaiement'=>$value->ID_PAIEMENTS, 'back'=>'paiemL'])}}"
                                        class="btn-1 btn-gray" title="Detail">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @if($value->SERVICE_ID==2 || $value->SERVICE_ID==3 || $value->SERVICE_ID==4)
                                        &nbsp;&nbsp;
                                        <a href="{{route('filePaiementList', ['idPaiement'=>$value->ID_PAIEMENTS ?? '0', 'back'=>'paiemL'])}}"
                                            title="Document(s) paiement">
                                            <i class="fa fa-image"></i>
                                        </a>
                                    @endif
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
                            Nous avons recherché plus de 150 paiements.
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
    </div>
</div>
