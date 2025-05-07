@extends('layouts.a_template', ['titre' => $titre])

@section('content')
@include('partials.manager.breadcrumb-nav', ['LBL' => 'Prospects'])
    <div class="submit-address dashboard-list">
        <h4>Liste des prospects</h4>
        <div class="row">
            @if ($message = Session::get('error'))
                <div class="alert alert-2 alert-warning alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            @if ($message = Session::get('success'))
                <div class="alert alert-2 alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            @php session()->forget('error'); @endphp
            @php session()->forget('success'); @endphp
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
                                            <th class="sort" data-sort="id">Nom</th>
                                            <th class="sort" data-sort="name">Prenoms</th>
                                            <th class="sort" data-sort="customer_name">Nationalité</th>
                                            <th class="sort" data-sort="email">Contact</th>
                                            <th class="sort" data-sort="phone">Adresse</th>
                                            <th class="sort" data-sort="action">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach($prospects as $key => $value)
                                        <tr>
                                            <td class="id">{{$value->NOM ?? 'xxxxxx'}}</td>
                                            <td class="name">{{$value->PRENOMS ?? 'xxxxxx'}}</td>
                                            <td class="customer_name">{{$value->NATIONALITE ?? 'x'}}</td>
                                            <td class="email">{{$value->CONTACT ?? 'xxxxxxxxxx'}}</td>
                                            <td class="phone">{{ Help::strCut($value->ADRESSE ?? 'xxx, xxx, xxx', 0, 33, '...') }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <div class="buttons">
                                                        <button class="btn btn-primary" type="button"
                                                            onclick="validated('{{$value->ID_PROSPECT ?? 0}}');"
                                                            title="Valider le prospect '{{$value->PRENOMS ?? 'xxxxxx'}}'">
                                                            <i class="fa fa-fw fa-check-circle-o"></i>
                                                        </button>
                                                        <button class="btn btn-secondary" type="button"
                                                            onclick="deleted({{$value->ID_PROSPECT ?? 0}})"
                                                            title="Supprimer le prospect '{{$value->PRENOMS ?? 'xxxxxx'}}'">
                                                            <i class="fa fa-fw fa-times-circle-o"></i>
                                                        </button>
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
                                            Nous avons recherché plus de 150 prospects.
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

@section('js')
<script>
    function validated(params) {
        if (confirm("Voulez-vous valider cet prospect ?")) {
            if (confirm("Cette action enregistrera le prospect dans votre base des clients, Voulez-vous valider ?")) {
                var rout = "{{ route('prospectValid',['idProspect'=>':idProspect']) }}";
                rout = rout.replace(':idProspect', params)
                window.open(rout, '_self');
            }
        }
    }
    function deleted(params) {
        if (confirm("Voulez-vous supprimer cet prospect ?")) {
            var rout = "{{ route('prospectDesact',['idProspect'=>':idProspect']) }}";
            rout = rout.replace(':idProspect', params)
            window.open(rout, '_self');
        }
    }
</script>
@endsection
