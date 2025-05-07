@extends('layouts.c_template', ['titre' => $titre])

@section('content')
    @include('partials.client.breadcrumb-navcli', ['LBL' => 'Ajout document'])

    @if ($message = Session::get('success'))
    <div class="alert alert-2 alert-success alert-dismissible fade show" role="alert">
        <strong>{{ $message }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if ($message = Session::get('error'))
    <div class="alert alert-2 alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ $message }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="submit-address dashboard-list">
        <br />
        <a type="button" onclick="cancel('{{$idPaiement ?? 0}}', '{{$back ?? 'paiemL'}}');"
            class="mb-10" style="margin-left: 20px">
            <i class="fa fa-angle-double-left"></i>&nbsp;<b>Retour</b>
        </a>
        <form method="post" action="{{route('documentValid')}}" enctype="multipart/form-data">
            @csrf
            <h4 class="bg-grea-3"><i class="fa fa-image"></i> Ajout de documents de paiement</h4>
            <div class="row pad-20">
                <input name="param" value="{{ $idPaiement ?? 0 }}" style="display: none;" readonly />
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <label class="form-label">document </label>
                    <input type="file" name="preuves[]" multiple id="file-selector" accept=".jpg, .png, .jpeg"
                    class="form-control" placeholder="Choisir fichier">
                    <p id="status"></p>
                    <img id="output" style="height: 50%; width: 50%; display: none">
                </div>
            </div>
            <div class="row pad-20">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <button type="submit" class="btn-6">Enregistrer</button>
                    <a type="button" onclick="cancel('{{ $idPaiement ?? 0 }}', '{{$back ?? 'paiemL'}}');"
                    class="btn btn-outline-dark" style="margin-left: 20px">Annuler</a>
                    {{-- bomd --}}
                </div>
            </div>
        </form>

    </div>
@endsection

@section('js')
    <script>

        c

        function cancel(id, cle) {
            rout = "{{ route('filePaiementList',['idPaiement'=>':idPaiement', 'back'=>':back']) }}";
            rout = rout.replace(':back', cle);
            rout = rout.replace(':idPaiement', id);
            window.open(rout, '_self');
        }

    </script>
@endsection
