@extends('layouts.c_template', ['titre' => $titre])

@section('content')
    @include('partials.client.breadcrumb-navcli', ['LBL' => 'Propriétés'])
    <div class="submit-address dashboard-list">
        <h4>Vos biens {{count($affaires) ?? 0}} Propriété(s)</h4>
        <div class="row pad-20">
            <div class="col-lg-12">
                <div class="invoice">
                    <div class="row">
                        @if(count($affaires)>0)
                            <div class="col-lg-12 col-md-12">
                                <div class="row">
                                    @foreach ($affaires as $key => $p)
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="property-box">
                                                <div class="property-photo">
                                                    <a href="{{ route('detailP',['idPropriete'=>$p->ID_PROPRIETES]) }}" class="property-img">
                                                        <img class="d-block w-100"
                                                        src="{{ asset($p->IMG_DEFAULT ?? 'assets/img/properties/properties-1.png') }}">
                                                    </a>
                                                </div>
                                                <div class="detail">
                                                    <h1 class="title">
                                                        <a href="{{ route('detailP',['idPropriete'=>$p->ID_PROPRIETES]) }}"
                                                            title="Consulter la propriété">
                                                            {{ $p->LIB_PROPRIETE ?? 'designation' }} |
                                                            {{ $p->LIB_CATEGORIE ?? 'Categ' }}
                                                        </a>
                                                    </h1>
                                                    <div class="location">
                                                        <a href="{{ route('detailP',['idPropriete'=>$p->ID_PROPRIETES]) }}">
                                                            <i class="flaticon-pin"></i>{{ $p->ADRESSE ?? 'Adresse' }}
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="facilities-list clearfix">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td style="color: black">Coût </td>
                                                                <td style="color: black">
                                                                    <b>: {{ Help::formatNombre($p->MONTANT ?? '0', true) }}</b>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="color: black">Total à Payer </td>
                                                                <td style="color: black">
                                                                    <b>: {{ Help::formatNombre($p->TOTAL_A_PAYER ?? '0', true) }} </b>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="color: black">Date conclus </td>
                                                                <td style="color: black">
                                                                    <b>: {{ $p->DATE_CONCLUS ?? 'dd/mm/yyyy' }} </b>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <p style="color: black"><u>Commentaire</u><br />
                                                        <span style="color: black">
                                                            <b> {{ Help::strCut($p->DESCRIPTIF ?? 'Aucun', 0, 30, '...') }} </b>
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="footer">
                                                    <a href="{{route('affaireCliForm', ['idAffaire'=>$p->ID_AFFAIRES ?? '0'])}}"
                                                        title="Detail affaire">Detail <i class="fa fa-angle-double-right"></i>
                                                    </a>
                                                    &nbsp;&nbsp;
                                                    <a href="{{route('paiementAffList',['idAffaire'=>$p->ID_AFFAIRES])}}"
                                                        title="Paiements">Paiements <i class="fa fa-credit-card"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <br />
                            </div>
                        @else
                            <p class="text-center">
                                <i class="fa fa-angle-double-left"></i>
                                <b>Aucun biens acquis trouvés.</b>
                                <i class="fa fa-angle-double-right"></i>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
