@extends('layouts.c_template', ['titre' => $titre])

@section('content')
    @include('partials.client.breadcrumb-navcli', ['LBL' => 'Etat Paiement'])
    <div class="submit-address dashboard-list">
        <br />
        <a type="button" onclick="cancel();"
            class="mb-10" style="margin-left: 20px">
            <i class="fa fa-angle-double-left"></i>&nbsp;<b>Acceder à la liste des Paiments</b>
        </a>
        <h4 class="bg-grea-3"><i class="fa fa-info"></i>&nbsp;Etat paiement en ligne</h4>
        <div class="row pad-20">
            <div style="text-align: center; border: 2px solid #EAEDED; padding:20px">
                <h2 style="color: green">{{$titre ?? 'ETAT PAIEMENT'}}</h2>
                <h6>
                    <br />
                    {{$mess ?? 'Paiement en cours...'}} <br />
                </h6>
                <br />
                <button type="button" onclick="cancel();" class="btn-6">Liste des Paiments </button>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script> function cancel() { rout = "{{route('paiemClientList')}}"; window.open(rout, '_self'); } </script>
@endsection
