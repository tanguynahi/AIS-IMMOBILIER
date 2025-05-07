@extends('layouts.a_template', ['titre' => $titre])

@section('content')
    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Client'])
    <div class="submit-address dashboard-list">
        <br />
        <a type="button" onclick="cancel();" class="mb-0" style="margin-left: 20px">
            <i class="fa fa-angle-double-left"></i>&nbsp;<b>Retour</b>
        </a>
        <h4>Detail client</h4>
        <div class="row pad-20">
            <div class="col-lg-6">
                <h6><u>Informations Client</u></h6>
                <div class="comment">
                    <div class="comment-author">
                        <a href="#">
                            <img src="{{asset($client->AVATAR ?? 'avatar-bg.png')}}">
                        </a>
                    </div>
                    <div class="comment-content">
                        <div class="comment-meta">
                            <h5>
                                @switch($client->CIVILITE)
                                    @case('1') M. @break  @case('2') Mme @break @case('3') Mlle @break
                                    @default
                                @endswitch
                                {{$client->NOM ?? 'xxxxx'}}&nbsp;{{$client->PRENOMS ?? 'xxxxxxx'}}
                            </h5>
                            <ul>
                                <li>Nationalité : <span>
                                    <b>{{$client->NATIONALITE ?? 'xxxxxx'}}</b>
                                </li>
                                <li>Contact : <span>
                                    <a href="tel:{{$client->CONTACT ?? '+225xxxxxxxxxx'}}">
                                    <b>{{$client->CONTACT ?? '+225xxxxxxxxxx'}}</b></a></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h6><u>Adresse & Localisation</u></h6>
                <div class="comment">
                    <div class="comment-meta">
                        <ul>
                            <li>Email : <span>
                                <a href="mailto:{{$client->ADR_EMAIL ?? 'xxxxxxxx'}}">
                                    {{$client->ADR_EMAIL ?? 'xxxxxxxx'}}
                                </a></span>
                            </li>
                            <li>Ville : <span>
                                <b>{{$client->LIB_VILLE ?? 'xxxxxxxx'}}</b></span>
                            </li>
                            <li>Adresse : <span>
                                <b>{{$client->ADRESSE ?? 'xxxx, xxxxx, xxxxxx'}}</b></span>
                            </li>
                            <li>Boite P.: <span>
                                <b>{{$client->BOITE_POSTALE ?? 'xxxx, xxxxx, xxxxxx'}}</b></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <h4></h4>
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
            <h6><br /><u>Propriété(s) acquis</u><br /><br /></h6>
            <div class="col-lg-12 row">
                @if(count($proprietes)>0)
                    @foreach($proprietes as $key => $value)
                    <div class="property-box-2">
                        <div class="row g-0">
                            <div class="col-lg-5 col-md-5">
                                <div class="property-photo">
                                    <a href="#" class="property-img">
                                        <img alt="properties" class="img-fluid"
                                        src="{{asset($value->IMG_DEFAULT ?? 'assets/img/properties/properties-list-2.png')}}">
                                        {{-- <div class="listing-badges">
                                            <span class="featured">Featured</span>
                                        </div>
                                        <div class="price-box"><span>$850.00</span> Per month</div> --}}
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7">
                                <div class="detail">
                                    <div class="hdg">
                                        <h3 class="title">
                                            <a>{{$value->LIB_PROPRIETE ?? 'xxxxx'}}</a>
                                        </h3>
                                        <h5 class="location">
                                            <a>
                                                <i class="flaticon-pin"></i>
                                                {{$value->ADRESSE ?? 'xxxxx'}}
                                            </a>
                                        </h5>
                                    </div>
                                    <ul class="facilities-list clearfix">
                                        <li>
                                            <i class="flaticon-room"></i>
                                            {{ $value->NB_PIECES ?? 'x' }} Pièce(s)
                                        </li>
                                        <li>
                                            <i class="flaticon-bed"></i>
                                            {{ $value->NB_CHAMBRES ?? 'x' }} Chambre(s)
                                        </li>
                                        <li>
                                            <i class="flaticon-bathroom"></i>
                                            {{$value->NB_SALLE_DE_BAIN ?? 'beds'}} Bain(s)
                                        </li>
                                        <li>
                                            <i class="flaticon-area"></i>
                                            {{ $value->SUPERFICIE ?? 'xxx' }} m²
                                        </li>
                                        <li>
                                            <i class="flaticon-car"></i>
                                            {{ $value->NB_GARAGE ?? 'parking' }} Garage(s)
                                        </li>
                                        @if(isset($value->SECURITE) && $value->SECURITE>0)
                                            <li><i class="flaticon-sell"></i>Securite </li>
                                        @endif
                                    </ul>
                                    <div class="footer">
                                        <a href="{{route('affDetail',['idAffaire'=>$value->ID_AFFAIRES, 'idPropriete'=>$value->ID_PROPRIETES_AFF])}}" tabindex="0">
                                            <i class="fa fa-eye"></i>Visualiser
                                        </a>
                                        &nbsp;&nbsp;
                                        <a class="btn-1 btn-gray" type="button" onclick="actionBars('form', {{$client->ID_CLIENT ?? 0}}, {{$value->ID_AFFAIRES ?? 0}});">
                                            <i class="fa fa-pencil"></i>Modifier
                                        </a>
                                        &nbsp;&nbsp;
                                        <a class="btn-1 btn-gray" type="button" title="Supprimer"
                                            onclick="actionBars('del', 0, {{$value->ID_AFFAIRES ?? 0}});">
                                            <i class="fa fa-fw fa-times-circle-o"></i>Supprimer
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <p class="text-left">
                        <i class="fa fa-angle-double-left"></i>
                        <b >Aucune propriétés trouvées.</b>
                        <i class="fa fa-angle-double-right"></i>
                    </p><br>
                @endif
            </div>
            <div class="col-lg-12">
                <div class="buttons mb-20">
                    <a class="btn-1 btn-gray" type="button" onclick="actionBars('form', {{$client->ID_CLIENT ?? 0}}, 0);">
                        <i class="fa fa-fw fa-plus"></i> Ajouter
                    </a>
                    &nbsp;&nbsp;
                    <a class="btn-1 btn-gray" type="button" onclick="cancel();">
                        <i class="fa fa-fw fa-times-circle-o"></i> Fermer
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function cancel(id) {
            var rout = "{{route('clientList')}}";
            window.open(rout, '_self');
        }
        function actionBars(params, idCli, id) {
            switch (params) {
                case 'form':
                    var rout = "{{route('affFormCli',['idCli'=>':cli', 'id'=>':id'])}}";
                    rout = rout.replace(':id', id);
                    rout = rout.replace(':cli', idCli);
                    window.open(rout, '_self');
                    break;

                case 'del':
                    if (confirm("Voulez-vous retirer cette propriété de la liste des biens acquis pour cet client ?")) {
                        var rout = "{{ route('affaireDesact',['idAffaire'=>':idAffaire']) }}";
                        rout = rout.replace(':idAffaire', id)
                        window.open(rout, '_self');
                    }
                    break;

                default:
                    alert('Action non pris en charge !');
                    break;
            }
        }
    </script>
@endsection
