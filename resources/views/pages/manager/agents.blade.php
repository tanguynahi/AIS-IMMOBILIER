@extends('layouts.a_template', ['titre' => $titre])

@section('content')
    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Agents/Personnels'])
    <div class="submit-address dashboard-list">
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
        <a type="button" onclick="form();" class="btn btn-outline-primary" style="margin-left: 20px">
            <i class="fa fa-plus"></i>&nbsp;&nbsp;Nouvel agent
        </a>
        <h4>Liste des agents/Personnels</h4>
        <div class="row pad-20">
            <div class="our-team">
                @if (count($agents) > 0)
                    <div class="container">
                        <div class="row">
                            @foreach ($agents as $key => $value)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="team-5">
                                        <div class="team-info">
                                            <img src="{{ asset($value->PATH_PERS ?? 'assets/img/avatar/avatar-12.png') }}"
                                                alt="agent-5" style="height: 420px">
                                            <div class="overlay">
                                                <div class="text-section">
                                                    <div class="social-list">
                                                        <i class="fa fa-facebook"></i>
                                                        <i class="fa fa-twitter"></i>
                                                    </div>
                                                    <a href="{{ route('agentForm', ['id' => $value->ID_PERSONNELS]) }}"
                                                        class="btn btn-primary">Modifier </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="team-box">
                                            <div class="team-details">
                                                <i class="fa fa-user user"></i>
                                                <div>
                                                    <h4>
                                                        @php
                                                            $lib = $value->PRENOMS_PERS . ' ' . $value->NOM_PERS;
                                                        @endphp
                                                        {{ Help::strCut($lib ?? 'xxxxx', 0, 15, '..') }}
                                                    </h4>
                                                    <p>{{ Help::strCut($value->LIB_FONCTION ?? 'xxxxx', 0, 20, '..') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <p class="text-center">
                        <i class="fa fa-angle-double-left"></i>
                        <b>Aucun agents trouvés.</b>
                        <i class="fa fa-angle-double-right"></i>
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function form() {
            var rout = "{{ route('agentForm', ['id' => '0']) }}";
            window.open(rout, '_self');
        }

        function deleted(params) {
            if (confirm("Voulez-vous supprimer cet enregistrement ?")) {
                var rout = "{{ route('agentDesact', ['idAgent' => ':idAgent']) }}";
                rout = rout.replace(':idAgent', params)
                window.open(rout, '_self');
            }
        }
    </script>
@endsection
