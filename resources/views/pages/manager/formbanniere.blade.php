@extends('layouts.a_template', ['titre' => $titre])

@section('content')
    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Fiche bannière'])
    {{-- @livewire('form-banniere',['id'=>$id]) --}}


    <div>
        <div class="alert alert-2 alert-warning alert-dismissible fade show" role="alert" id="sv-mess"
            style="display: none">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="submit-address dashboard-list">
            <form method="post" action="{{ route('storeUpdateBanniere',['id' =>$banniere->ID_BANNIERES ?? 0 ]) }}" enctype="multipart/form-data">
                @csrf 
                     @method('Post')        
                <h4 class="bg-grea-3">
                    <i class="fa fa-info"></i>&nbsp;
                    @if (empty($banniere->ID_BANNIERES))
                        Nouvelle Saisie
                    @else
                        Mise à Jour bannière n° <b>{{ $banniere->ID_BANNIERES ?? '' }}</b>


                    @endif
                </h4>
                <div class="search-contents-sidebar">
                    <div class="row pad-20">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group propertytitle">
                                <label class="form-label">Titre</label>
                                <input type="text" class="form-control @error('libelle') is-invalid @enderror"
                                    name="libelle" placeholder="Titre de la bannière" value="{{ old('libelle',$banniere->TITRE_INFO) }}" />
                                @error('libelle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group message">
                                <label class="form-label">Description</label>
                                <textarea type="text" class="form-control @error('description') is-invalid @enderror" name="description"
                                    placeholder="Description.." rows="4">{{ old('description',$banniere->CONTENU_INFO) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <p style="font-size: 100%">Joindre une image, taille maximum 2Mo </p>
                            <input type="file"
                                class="form-control @error('avatar') is-invalid @enderror
                            @error('avatar') is-invalid @enderror @error('avatar.*') is-invalid @enderror"
                                name="avatar" accept=".jpg, .png, .jpeg" id="file-selector">

                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('avatar.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <p id="status"></p>
                            <img class="img-fluid" src="{{ asset($avatar ?? $banniere->PATH_BAN ?? '') }}" id="output"  />
                        </div>
                        <div class="col-md-12">
                            @error('ajaxmess')
                                <div class="text-center" style="color: red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row pad-20">
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit" >
                                    <i class="fa fa-fw fa-check-circle-o"></i>Valider
                                </button>
                                <button class="btn btn-outline-secondary" type="button" onclick="cancel();">
                                    <i class="fa fa-fw fa-times-circle-o"></i>Annuler
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function cancel() {
            rout = "{{ route('banniereList') }}";
            window.open(rout, '_self');
        }
        const status = document.getElementById('status');
        const output = document.getElementById('output');
        if (window.FileList && window.File && window.FileReader) {
            document.getElementById('file-selector').addEventListener('change', event => {
                output.src = '';
                status.textContent = '';
                const file = event.target.files[0];
                if (file == undefined) {
                    output.src = '/images/avatar-bg.png';
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
    </script>
@endsection
 