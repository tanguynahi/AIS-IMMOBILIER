@extends('layouts.c_template', ['titre' => $titre])

@section('content')
    @include('partials.client.breadcrumb-navcli', ['LBL' => 'Nouveau message'])
    <div class="submit-address dashboard-list">
        <h4>
            <a type="button" onclick="cancel();" class="mb-10" style="margin-left: 5px">
                <i class="fa fa-angle-double-left"></i>&nbsp;Retour
            </a>
        </h4>
        @livewire('form-message-cli')
    </div>
@endsection

@section('js')
    <script>
        function cancel() {
            var rout = "{{ route('messageListCli') }}";
            window.open(rout, '_self');
        }
    </script>
@endsection
