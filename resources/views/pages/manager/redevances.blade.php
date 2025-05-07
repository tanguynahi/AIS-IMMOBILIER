@extends('layouts.a_template', ['titre' => $titre])

@section('content')
@include('partials.manager.breadcrumb-nav', ['LBL' => 'Redevances'])
    <div class="submit-address dashboard-list">
        <h4>Liste des redevances</h4>
        <div class="row">
            <div class="col-lg-12">
                <div class="">
                    <div class="card-body">
                        <div class="listjs-table" id="customerList">
                            <div class="row g-4 mb-0">
                                <div class="col-sm-auto">
                                    <div>
                                        <a type="button" onclick="form();"
                                            class="btn btn-outline-primary" style="margin-left: 20px">
                                            <i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter Redevance
                                        </a>
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
                                            <th class="sort" data-sort="id">Designation</th>
                                            <th class="sort" data-sort="name">Description</th>
                                            <th class="sort" data-sort="customer_name">Periode</th>
                                            <th class="sort" data-sort="action">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach($redevances as $key => $value)
                                        <tr>
                                            <td class="id">{{$value->LIB_REDEVANCES ?? 'xxxxxx'}}</td>
                                            <td class="name">{{ Help::strCut($value->DESCRIPTIF ?? 'xxx, xxx, xxx', 0, 80, '...') }}</td>
                                            <td class="customer_name">{{$value->LIB_PERIODE ?? 'xxxxxx'}}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <div class="buttons">
                                                        <a href="{{route('redevanceForm',['id'=>$value->ID_REDEVANCES])}}"
                                                            class="btn-1 btn-gray" title="Modifier">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        &nbsp;&nbsp;
                                                        <a class="btn-1 btn-gray" type="button" title="Supprimer"
                                                            onclick="deleted({{$value->ID_REDEVANCES}});">
                                                            <i class="fa fa-fw fa-times-circle-o"></i>
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
                                            Nous avons recherché plus de 150 redevances.
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
    function form() {
        var rout = "{{route('redevanceForm',['id'=>'0'])}}";
        window.open(rout, '_self');
    }
    function deleted(params) {
        if (confirm("Voulez-vous supprimer cet enregistrement ?")) {
            var rout = "{{ route('redevanceDesact',['idRedevance'=>':idRedevance']) }}";
            rout = rout.replace(':idRedevance', params)
            window.open(rout, '_self');
        }
    }
</script>
@endsection
