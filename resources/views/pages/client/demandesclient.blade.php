@extends('layouts.c_template', ['titre' => $titre])

@section('content')
    @include('partials.client.breadcrumb-navcli', ['LBL' => 'Demandes'])
    <div class="submit-address dashboard-list">
        <h4>Vos demandes de Visite</h4>
        <div class="row">
            <div class="col-lg-12">
                <div class="">
                    <div class="card-body">
                        <div class="listjs-table" id="customerList">
                            <div class="row g-4 mb-0">
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
                                            <th class="sort" data-sort="id">Type dem.</th>
                                            <th class="sort" data-sort="customer_name">Propriete</th>
                                            <th class="sort" data-sort="email">Date</th>
                                            <th class="sort" data-sort="phone">Intitulé</th>
                                            <th class="sort" data-sort="status">Status</th>
                                            <th class="sort" data-sort="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach($demandes as $key => $value)
                                        <tr>
                                            <td class="id">{{ Help::LibelleTypeDemande($value->TYPE_DEMAND ?? 0) }}</td>
                                            <td class="customer_name" title="{{$value->LIB_PROPRIETE ?? ''}}">
                                                {{ Help::strCut($value->LIB_PROPRIETE ?? 'xxxxxx', 0, 15, '...') }}
                                            </td>
                                            <td class="email">
                                                @if($value->TYPE_DEMAND==1)
                                                    <b>{{ $value->DATE_VISIT ?? 'JJ/MM/AAAA' }}
                                                @else
                                                    x
                                                @endif
                                            </td>
                                            <td class="phone" title="{{$value->MESSAGE ?? ''}}">
                                                {{ Help::strCut($value->MESSAGE ?? 'Aucun texte', 0, 40, '...') }}
                                            </td>
                                            <td class="status">
                                                @switch($value->STATUT)
                                                    @case(Help::$ENATTENTE)
                                                    <span class="badge bg-primary-subtle text-primary text-uppercase">EN ATTENTE</span>
                                                    @break
                                                    @case(Help::$REFUSE)
                                                    <span class="badge bg-danger-subtle text-danger text-uppercase">REJETEE</span>
                                                    @break
                                                    @case(Help::$ACTIF)
                                                    <span class="badge bg-success-subtle text-success text-uppercase">APPROUVEE</span>
                                                    @break
                                                    @default
                                                    <span class="badge bg-danger-subtle text-danger text-uppercase">INACTIF</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <div class="buttons">
                                                        <a href="{{route('demCliForm',['idDemand'=>$value->ID_DEMANDE_VISIT])}}"
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
                                            Nous avons recherché plus de 150 demandes.
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

