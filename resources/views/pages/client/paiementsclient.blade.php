@extends('layouts.c_template', ['titre' => $titre])

@section('content')
    @include('partials.client.breadcrumb-navcli', ['LBL' => 'Paiements'])
    <div class="submit-address dashboard-list">
        <h4>Fichier des paiements effectués</h4>
        <div class="row">
            <div class="col-lg-12">
                @livewire('paiements-client', ['id'=>$idclient])
            </div>
        </div>
    </div>
@endsection
