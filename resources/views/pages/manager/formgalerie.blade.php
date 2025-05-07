@extends('layouts.a_template', ['titre' => $titre])

@section('content')
    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Fiche galerie'])
    <div class="alert alert-2 alert-warning alert-dismissible fade show" role="alert" id="sv-mess" style="display: none">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="submit-address dashboard-list">
        <form method="post" action="{{route('galerieValid')}}" enctype="multipart/form-data">
            @csrf
            <h4 class="bg-grea-3"><i class="fa fa-image"></i> Galerie de propriété</h4>
            <div class="row pad-20">
                <input name="IDProprietes" value="{{ $idPropriete ?? 0 }}" style="display: none;" readonly />
                <div class="col-lg-12">
                    <label class="form-label">Image Principale</label>
                    <input type="file" name="DefaultFile" id="file-selector" accept=".jpg, .png, .jpeg"
                        class="form-control" placeholder="Choisir un fichier">
                    <p id="status"></p>
                    <img id="output" style="height: 100px; width: 100px; display: none">
                </div>
                <div class="col-lg-12">
                    <label class="form-label">Images associées</label>
                    <br />
                    <input type="file" accept=".jpg, .png, .jpeg" name="OthersFiles[]" multiple class="form-control"
                        id="file" placeholder="Choisir des fichiers">
                </div>
                <div class="col-lg-12">
                    <br />
                    <label class="form-label">Plans</label>
                    <br />
                    <input type="file" accept=".jpg, .png, .jpeg" name="Plan[]" multiple class="form-control"
                        id="file" placeholder="Choisir des fichiers">
                </div>
            </div>
            <div class="row pad-20">
                <div class="col-12">
                    <button class="btn btn-primary" type="submit" onclick="savedata();">
                        <i class="fa fa-fw fa-check-circle-o"></i>Valider
                    </button>
                    <button class="btn btn-outline-secondary" type="button" onclick="cancel('{{ $idPropriete ?? 0 }}');">
                        <i class="fa fa-fw fa-times-circle-o"></i>Annuler
                    </button>
                </div>
            </div>
        </form>

    </div>
@endsection

@section('js')
    <script>
        const status = document.getElementById('status');
        const output = document.getElementById('output');
        if (window.FileList && window.File && window.FileReader) {
            document.getElementById('file-selector').addEventListener('change', event => {
                output.src = '';
                status.textContent = '';
                const file = event.target.files[0];
                if (file == undefined) {
                    $("#output").hide();
                } else {
                    if (!file.type) {
                        status.textContent =
                            'Error: La propriété File.type ne semble pas être prise en charge sur ce navigateur.';
                        return;
                    }
                    if (!file.type.match('image.*')) {
                        status.textContent = 'Error: Le fichier sélectionné ne semble pas être une image.'
                        return;
                    }
                    const reader = new FileReader();
                    reader.addEventListener('load', event => {
                        output.src = event.target.result;
                        $("#output").show();
                    });
                    reader.readAsDataURL(file);
                }
            });
        }
        function cancel(id) {
            rout = "{{ route('galerieList',['idPropriete'=>':idPropriete']) }}";
            rout = rout.replace(':idPropriete', id);
            window.open(rout, '_self');
        }
    </script>
@endsection
