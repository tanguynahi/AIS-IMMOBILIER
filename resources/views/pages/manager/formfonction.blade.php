@extends('layouts.a_template', ['titre' => $titre])

@section('content')
    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Fiche de Saisie Fonction'])
    @livewire('formulaire-fonction', ['id'=>$id ?? 0])
@endsection

@section('js') <script> function cancel() {
var rout = "{{route('fonctionList')}}"; window.open(rout, '_self'); } </script> @endsection
