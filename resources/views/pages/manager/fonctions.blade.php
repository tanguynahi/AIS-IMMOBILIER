@extends('layouts.a_template', ['titre' => $titre])

@section('content')
@include('partials.manager.breadcrumb-nav', ['LBL' => 'Fonction Agent'])
    <div class="submit-address dashboard-list">
        <br />
        <a type="button" onclick="form();" class="btn btn-outline-primary" style="margin-left: 20px">
            <i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter Fonction
        </a>
        <h4>Liste des fonctions agent</h4>
        <div class="row pad-20">
            <div class="col-lg-12">
                <div class="invoice">
                    <div class="row">
                        <div class="col-md-12">
                            @if(count($fonctions)>0)
                                <div class="table-responsive">
                                    <table class="table table-condensed">
                                        <thead class="bg-active-2">
                                            <tr>
                                                <td><strong>Designation</strong></td>
                                                <td><strong>Actions</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($fonctions as $key => $value)
                                                <tr>
                                                    <td>{{$value->LIB_FONCTION ?? 'xxxxxx'}}</td>
                                                    <td class="text-center">
                                                        <div class="buttons">
                                                            <a href="{{route('fonctionForm',['id'=>$value->ID_FONCTION_PERS])}}"
                                                                class="btn-1 btn-gray" title="Modifier">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            &nbsp;&nbsp;
                                                            <a class="btn-1 btn-gray" type="button" title="Supprimer"
                                                                onclick="deleted({{$value->ID_FONCTION_PERS}});">
                                                                <i class="fa fa-fw fa-times-circle-o"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-center">
                                    <i class="fa fa-angle-double-left"></i>
                                    <b>Aucune fonctions trouvées.</b>
                                    <i class="fa fa-angle-double-right"></i>
                                </p>
                            @endif
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
        var rout = "{{route('fonctionForm',['id'=>'0'])}}";
        window.open(rout, '_self');
    }
    function deleted(params) {
        if (confirm("Voulez-vous supprimer cet enregistrement ?")) {
            var rout = "{{ route('fonctionDesact',['idFonction'=>':idFonction']) }}";
            rout = rout.replace(':idFonction', params)
            window.open(rout, '_self');
        }
    }
</script>
@endsection
