@extends('layouts.a_template', ['titre' => $titre])

@section('content')
    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Fiche de Saisie Service'])
    {{-- @livewire('formulaire-service', ['id'=>$id ?? 0]) --}}
    <div>
        <div class="submit-address dashboard-list">
            <h4 class="bg-grea-3"><i class="fa fa-info"></i>&nbsp;Informations de base</h4>
            <div class="search-contents-sidebar">
                <form action="{{route('updatStoreService',['id'=>$service->ID_SERVICES ?? 0])}}" enctype="multipart/form-data" method="post">
                    @csrf
                    @method('post')
                    <div class="row pad-20">
                        <input type="number" class="form-control" wire:model="ID" hidden>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <div class="form-group propertytitle">
                                <label for="libelle" class="form-label">Designation *</label>
                                <input type="text" placeholder="Designation du service" required
                                    class="form-control @error('libservice') is-invalid @enderror" name="libservice" value="{{ old('libservice',$service->LIB_SERVICE) }}">
                                @error('libservice')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-10">
                            <label class="form-label">Image service</label>
                            <input type="file" id="image" accept=".jpg, .png, .jpeg, .avif"
                                class="form-control @error('image') is-invalid @enderror" placeholder="Choisir fichier"
                                name="image">
                            @if (!empty($service->PATH_SERVICE))
                                <img src="{{ asset($service->PATH_SERVICE) }}" alt="images Service" style="height: 150px; width:150px;">
                            @endif
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group message">
                                <label for="desc" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="2"
                                    placeholder="Saisi ici une description...">{{ old('description',$service->DESCRIPTION_SERVICE) }}</textarea>
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
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-fw fa-check-circle-o"></i>Valider
                                </button>
                                <button class="btn btn-outline-secondary" type="button" onclick="cancel();">
                                    <i class="fa fa-fw fa-times-circle-o"></i>Annuler
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function cancel() {
            var rout = "{{ route('serviceList') }}";
            window.open(rout, '_self');
        }
    </script>
@endsection
