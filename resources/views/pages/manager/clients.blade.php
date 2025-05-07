@extends('layouts.a_template', ['titre' => $titre])

@section('content')
@include('partials.manager.breadcrumb-nav', ['LBL' => 'Clients'])
    <div class="submit-address dashboard-list">
        <h4>Liste des clients</h4>
        <div class="row">
            <div class="col-lg-12">
                <div class="">
                    <div class="card-body">
                        <div class="listjs-table" id="customerList">
                            <div class="row g-4 mb-0">
                                <div class="col-sm-auto" hidden>
                                    <div>
                                        <button type="button" class="btn btn-info add-btn"
                                            data-bs-toggle="modal" id="create-btn"
                                            data-bs-target="#showModal">
                                            <i class="ri-add-line align-bottom me-1"></i> Add
                                        </button>
                                        <button class="btn btn-soft-danger" onClick="deleteMultiple()">
                                            <i class="ri-delete-bin-2-line"></i>
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
                                            <th class="sort" data-sort="id">Civ.</th>
                                            <th class="sort" data-sort="name">Nom</th>
                                            <th class="sort" data-sort="customer_name">Prenoms</th>
                                            <th class="sort" data-sort="email">Nationalité</th>
                                            <th class="sort" data-sort="phone">Contact</th>
                                            <th class="sort" data-sort="date">Adresse</th>
                                            <th class="sort" data-sort="status">Status</th>
                                            <th class="sort" data-sort="action">Action</th>
                                            {{-- <th class="sort" data-sort="leads_score">Contact</th>
                                            <th class="sort" data-sort="location">Email</th>
                                            <th class="sort" data-sort="tags">Statut</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach($clients as $key => $value)
                                        <tr>
                                            <td class="id">
                                                @switch($value->CIVILITE)
                                                    @case('1') M. @break  @case('2') Mme @break @case('3') Mlle @break
                                                    @default
                                                    non defini
                                                @endswitch
                                            </td>
                                            <td class="name">{{$value->NOM ?? 'xxxxxx'}}</td>
                                            <td class="customer_name">{{$value->PRENOMS ?? 'xxxxxx'}}</td>
                                            <td class="email">{{$value->NATIONALITE ?? 'x'}}</td>
                                            <td class="phone">{{$value->CONTACT ?? 'xxxxxxxxxx'}}</td>
                                            <td class="date">{{ Help::strCut($value->ADRESSE ?? 'xxx, xxx, xxx', 0, 33, '...') }}</td>
                                            <td class="status">
                                                <span class="badge bg-success-subtle text-success text-uppercase">ACTIF</span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <div class="buttons">
                                                        <a href="{{route('clientForm',['idClient'=>$value->ID_CLIENT])}}"
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
                                            Nous avons recherché plus de 150 clients.
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
            </div>
        </div>
    </div>
@endsection
