@extends('layouts.a_template', ['titre' => $titre])


@section('content')
    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Bannière site'])
    <div class="dashboard-list">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <br />
        <div class="photo-gallery pg-2">
            <div class="container">
                <div class="main-title text-center">
                    {{-- <h1>Properties Gallery</h1> --}}
                    <p class="mb-30"><u>Images defilantes du site vitrine</u></p>
                    <a type="button" onclick="form(0);" class="btn btn-outline-primary mb-20" style="margin-left: 20px">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;Ajouter
                    </a>
                </div>

                <div class="row">
                    @if (count($banniers) > 0)
                        @foreach ($banniers as $key => $value)
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="property-box">
                                    <div class="property-photo">
                                        <a href="#" class="property-img">
                                            <img class="d-block w-100"
                                                src="{{ asset($value->PATH_BAN ?? 'img/properties/properties-1.png') }}"
                                                alt="Image">
                                        </a>
                                    </div>
                                    <div class="detail">
                                        <h1 class="title">
                                            <a href="#">
                                                {{ $value->TITRE_INFO }}
                                            </a>
                                        </h1>
                                        <div class="location">
                                            <a href="#">
                                                {!! $value->CONTENU_INFO ?? '' !!}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="footer">
                                        <a type="button" onclick="deletedata({{ $value->ID_BANNIERES }})">
                                            <i class="fa fa-fw fa-times-circle-o"></i>Supprimer
                                        </a>
                                        <span>
                                            <a type="button" onclick="form({{ $value->ID_BANNIERES }})">
                                                <i class="fa fa-pencil"></i>Modifier
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                <a>
                                    <div class="tag">Supprimer</div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="col-lg-12 col-md-12 col-sm-12 filtr-item" data-category="2">
                            <div class="main-title text-center">>
                                <p>
                                    <i class="fa fa-angle-double-left"></i>
                                    Aucune image chargée
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
        function form(param) {
            var rout = "{{ route('banniereForm', ['id' => ':id']) }}";
            rout = rout.replace(':id', param)
            window.open(rout, '_self');
        }

        function deletedata(idFile) {
            var url = "{{ route('banniereDesact', ['idFile' => ':idFile']) }}";
            url = url.replace(":idFile", idFile);
            if (confirm("Voulez-vous supprimer ce fichier ?")) {
                window.open(url, '_self');
            }
        }
    </script>
@endsection
