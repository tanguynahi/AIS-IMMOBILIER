@extends('layouts.a_template', ['titre' => $titre])

@section('content')
    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Fiche de Saisie Categorie'])
    {{-- @livewire('formulaire-categorie', ['id'=>$id ?? 0]) --}}


    <div>
        <div class="submit-address dashboard-list">
            <h4 class="bg-grea-3"><i class="fa fa-info"></i>&nbsp;Informations de base</h4>
            <form action="{{ route('storCategorieUpd',['id'=>$categorie->ID_CATEGORIES ?? 0]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="search-contents-sidebar">
                    <div class="row pad-20">
                        <input type="number" class="form-control" wire:model="ID" hidden>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group propertytitle">
                                <label for="libelle" class="form-label">Designation *</label>
                                <input type="text" placeholder="Designation de la catégorie"
                                    class="form-control @error('libcategorie') is-invalid @enderror" name="libcategorie"
                                    value="{{ old('libcategorie', $categorie->LIB_CATEGORIE) }}">
                                @error('libcategorie')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-10">
                            <div class="form-group">
                                <label class="form-label">Type *</label>
                                <select class="form-control @error('typebien') is-invalid @enderror" name="typebien">
                                    <option value="0">Choisir type..</option>
                                    @foreach ($types as $v)
                                        <option value="{{ $v->ID_TYPE }}"
                                            {{ old('typebien', $categorie->ID_TYPE) == $v->ID_TYPE ? 'selected' : '' }}>
                                            {{ $v->LIB_TYPE }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('typebien')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-10">
                            <label class="form-label">Image categorie</label>
                            <input type="file" id="{{ $imgID ?? 0 }}" accept=".jpg, .png, .jpeg"
                                class="form-control @error('image') is-invalid @enderror" placeholder="Choisir fichier"
                                name="image">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group message">
                                <label for="desc" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="2"
                                    placeholder="Saisi ici une description...">{{ old('description',$categorie->DESCRIPTION_CATEGORIE) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            @error('ajaxmess')
                                <div class="text-center" style="color: red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row pad-20">
                            <div class="col-12">
                                <button class="btn btn-primary"  type="submit">
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
            var rout = "{{ route('categorieList') }}";
            window.open(rout, '_self');
        }
    </script>
@endsection
