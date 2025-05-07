@extends('layouts.a_template', ['titre' => $titre])

@section('content')
    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Paiements'])
    <div class="submit-address dashboard-list">
        <h4>Suivis des paiements client</h4>
        <div class="row">
            <div class="col-lg-12">
                @livewire('suivis-paiements', ['id'=>$identreprise])
            </div>
        </div>
    </div>
@endsection
