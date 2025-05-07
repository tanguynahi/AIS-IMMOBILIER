@extends('layouts.a_template', ['titre' => $titre])

@section('content')
    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Mes Propriétés'])
    <div class="dashboard-list">
        <br />
        <a type="button" onclick="form();" class="btn btn-outline-primary" style="margin-left: 20px">
            <i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter Propriete
        </a>
        <h3>Liste Propriété </h3>
        @if(count($proprietes)>0)
            <table class="manage-table">
                <tbody>
                    @foreach ($proprietes as $p)
                        <tr class="responsive-table">
                            <td class="listing-photoo">
                                <img src="{{asset( $p->IMG_DEFAULT ?? 'assets/img/properties/properties-1.png')}}" class="img-fluid">
                            </td>
                            <td class="title-container">
                                <h2><a href="#">{{$p->LIB_PROPRIETE ?? 'Designation'}}</a></h2>
                                <h5><i class="flaticon-empire-state-building"></i>
                                    {{$p->LIB_TYPE ?? 'Type'}}, {{$p->LIB_CATEGORIE ?? 'Categ'}}
                                    @if($p->ID_TYPE==1), {{$p->NB_PIECES ?? 'x'}} Pièce(s) @endif
                                </h5>
                                <h5><i class="flaticon-pin"></i> {{$p->ADRESSE ?? 'Adresse'}} </h5>
                                <h6 class="table-property-price">
                                    <b>{{ Help::formatNombre($p->PRIX_HT ?? '0', true) }}</b>
                                </h6>
                            </td>
                            <td class="expire-date" @if($p->ID_TYPE!==1) hidden @endif>Année : {{$p->ANNEE ?? 'Année'}}</td>
                            <td class="action">
                                <a href="{{route('proprieteForm', ['id'=>$p->ID_PROPRIETES ?? 0])}}">
                                    <i class="fa fa-pencil"></i> Modifier
                                </a>
                                <a href="{{route('galerieList', ['idPropriete'=>$p->ID_PROPRIETES ?? 0])}}">
                                    <i class="fa fa-image"></i> Fichiers
                                </a>
                                @php
                                    (string) $lbl = '';
                                    if ($p->STATUT == Help::$ACTIF) $lbl = 'Desactiver';
                                    else $lbl = 'Activer';
                                @endphp
                                <a href="{{route('proprieteDesact',['idPropriete'=>$p->ID_PROPRIETES ?? 0])}}" class="delete">
                                    @if($p->STATUT == Help::$ACTIF) <i class="fa fa-eye"></i> @else <i class="fa fa-eye-slash"></i> @endif
                                    {{$lbl ?? 'Act/Desact.'}}
                                </a>
                                {{-- <i class="fa fa-remove"></i> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <br />
            <p class="text-center">
                <i class="fa fa-angle-double-left"></i>
                <b>Vous n'avez aucune propriétés enregistrées.</b>
                <i class="fa fa-angle-double-right"></i>
            </p>
        @endif
    </div>
@endsection

@section('js')
<script>
    function form() {
        var rout = "{{route('proprieteForm',['id'=>'0'])}}";
        window.open(rout, '_self');
    }
</script>
@endsection
