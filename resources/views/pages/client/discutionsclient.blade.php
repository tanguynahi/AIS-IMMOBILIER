@extends('layouts.c_template', ['titre' => $titre])

@section('content')
    @include('partials.client.breadcrumb-navcli', ['LBL' => 'Fil de discutions'])
    <div class="submit-address dashboard-list">
        <br />
        <a type="button" onclick="cancel();"
            class="mb-10" style="margin-left: 20px">
            <i class="fa fa-angle-double-left"></i>&nbsp;<b>Retour</b>
        </a>
        <h4> <u>Sujet:</u> {{$infosmessage->SUJET ?? 'Aucun'}} </h4>
        @livewire('discutions-message-cli', ['id'=>$id])
    </div>
@endsection

@section('js')
    <script>
        function cancel() {
            var rout = "{{route('messageListCli')}}";
            window.open(rout, '_self');
        }
    </script>
@endsection
