@extends('layouts.a_template', ['titre' => $titre])

@section('content')
    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Nouveau message'])
    <div class="submit-address dashboard-list">
        <h4>
            <a type="button" onclick="cancel();" class="mb-10" style="margin-left: 5px">
            <i class="fa fa-angle-double-left"></i>&nbsp;Retour </a>
        </h4>
        @livewire('formulaire-message')
    </div>
@endsection

@section('js')
    <script>
        function cancel() {
            var rout = "{{route('messageList')}}";
            window.open(rout, '_self');
        }
    </script>
@endsection
