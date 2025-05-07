@extends('layouts.c_template', ['titre' => $titre])

@section('content')
    @include('partials.client.breadcrumb-navcli', ['LBL' => 'Document paiement'])
    <div class="dashboard-list">
        <div class="photo-gallery pg-2">
            <div class="container">
                <br />
                <a type="button" onclick="cancel('{{$paiement->ID_PAIEMENTS ?? 0}}', '{{$back ?? 'paiemL'}}');"
                    class="mb-10" style="margin-left: 20px">
                    <i class="fa fa-angle-double-left"></i>&nbsp;<b>Retour</b>
                </a>
                <div class="main-title text-center">
                    <p class="mb-30">document(s) de la reférence de paiement n°
                        <b><u>{{$paiement->REFERENCE_P ?? 'xxxxxx'}}</u></b>
                    </p>
                </div>
                <a type="button" onclick="form('{{$paiement->ID_PAIEMENTS ?? 0}}', '{{$back ?? 'paiemL'}}');"
                    class="btn btn-outline-primary mb-20" style="margin-left: 20px">
                    <i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter Fichier
                </a>
                <br />
                <div class="row filter-portfolio">

                    @if(count($fichiers)>0)
                        @foreach($fichiers as $key => $value)
                            <div class="col-lg-4 col-md-6 col-sm-6 filtr-item" data-category="2">
                                <div class="portfolio-item">
                                    <a href="{{asset($value->PATH_PREUVE_PAY ?? 'assets/img/properties/properties-1.png')}}">
                                        <img src="{{asset($value->PATH_PREUVE_PAY ?? 'assets/img/properties/properties-1.png')}}" class="img-fluid">
                                    </a>
                                    <div class="portfolio-content">
                                        <div class="portfolio-content-inner">
                                            <p>Visualiser</p>
                                        </div>
                                    </div>
                                </div>
                                <a type="button" onclick="deletedata('{{$value->ID_PREUVESPAIEMENT}}')">
                                <div class="tag">Supprimer</div></a>
                            </div>
                        @endforeach
                    @else
                        <div class="col-lg-12 col-md-12 col-sm-12 filtr-item" data-category="2">
                            <div class="main-title text-center">>
                                <p>
                                    <i class="fa fa-angle-double-left"></i>
                                    Aucune document trouvés pour la reference de paiement
                                    <b>{{$paiement->REFERENCE_P ?? ''}}</b>
                                    <i class="fa fa-angle-double-right"></i>
                                </p>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function cancel(id, cle) {
            var rout = "{{route('paiemClientList')}}";
            if (cle!='paiemL'){
                rout = "{{route('paiementAffList',['idAffaire'=>':idAffaire'])}}";
                rout = rout.replace(':idAffaire', id);
            }
            window.open(rout, '_self');
        }
        function form(param, cle) {
            var rout = "{{route('documentForm',['idPaiement'=>':idPaiement', 'back'=>':back'])}}";
            rout = rout.replace(':back', cle)
            rout = rout.replace(':idPaiement', param)
            window.open(rout, '_self');
        }
        function deletedata(id) {
            var url = "{{route('documentDesact',['id'=>':id'])}}"
            url = url.replace(":id", id);
            if (confirm("Voulez-vous supprimer ce fichier ?")) {
                window.open(url, '_self');
            }
        }
    </script>
@endsection
