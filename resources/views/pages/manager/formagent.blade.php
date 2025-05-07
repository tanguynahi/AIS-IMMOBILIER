@extends('layouts.a_template', ['titre' => $titre])

@section('content')
    @include('partials.manager.breadcrumb-nav', ['LBL' => 'Fiche de Saisie Agent'])
    {{-- @livewire('formulaire-agent', ['id'=>$id ?? 0]) --}}
    <div>
        <div class="submit-address dashboard-list">
            <h4 class="bg-grea-3"><i class="fa fa-info"></i>&nbsp;Informations de base</h4>
            <div class="search-contents-sidebar">
                <form action="{{ route('personnelStoreUpad',['id'=>$agent->ID_PERSONNELS ?? 0]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="row pad-20">
                        {{-- <input type="number" class="form-control" wire:model="ID" hidden> --}}
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-10">
                            <div class="form-group propertytitle">
                                <label for="libelle" class="form-label">Nom *</label>
                                <input type="text" placeholder="Nom agent"
                                    class="form-control @error('nom') is-invalid @enderror" name="nom" required
                                    value="{{ old('nom', $agent->NOM_PERS) }}">
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 mb-10">
                            <div class="form-group propertytitle">
                                <label for="libelle" class="form-label">Prenoms *</label>
                                <input type="text" placeholder="Prenoms agent"
                                    class="form-control @error('prenoms') is-invalid @enderror" name="prenoms" required
                                    value="{{ old('prenoms', $agent->PRENOMS_PERS) }}">
                                @error('prenoms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 mb-10">
                            <div class="form-group">
                                <label for="contact" class="form-label">Contact</label>
                                <input type="text" placeholder="Contact agent"
                                    class="form-control @error('contact') is-invalid @enderror" name="contact"
                                    onKeyPress="if(this.value.length==10) return false;"
                                    value="{{ old('contact', $agent->CONTACT) }}">
                                @error('contact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-10">
                            <div class="form-group">
                                <label for="adremail" class="form-label">E-mail</label>
                                <input type="email" placeholder="Adresse e-mail agent" 
                                    class="form-control @error('adremail') is-invalid @enderror" name="adremail"
                                    onKeyPress="if(this.value.length==50) return false;"
                                    value="{{ old('adremail', $agent->ADR_EMAIL) }}">
                                @error('adremail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-12 mb-10">
                            <div class="form-group">
                                <label>Fonction *</label>
                                <select class="form-control @error('fonctID') is-invalid @enderror" name="fonctID" required>
                                    <option value="">Choisir fonction...</option>
                                    @foreach ($fonctions as $value)
                                        <option value="{{ $value->ID_FONCTION_PERS }}"
                                            {{ old('fonctID', $agent->ID_FONCTION_PERS) == $value->ID_FONCTION_PERS ? 'selected' : '' }}>
                                            {{ $value->LIB_FONCTION }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('fonctID')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-10">
                            <div class="form-group propertytitle">
                                <label for="libelle" class="form-label">Lien Facebook </label>
                                <input type="text" placeholder="Lien page facebook"
                                    class="form-control @error('urlfbk') is-invalid @enderror" name="urlfbk"
                                    value="{{ old('urlfbk', $agent->URL_FBK) }}">
                                @error('urlfbk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-10">
                            <div class="form-group propertytitle">
                                <label for="libelle" class="form-label">Lien Twitter </label>
                                <input type="text" placeholder="Lien page compte twitter"
                                    class="form-control @error('urltwt') is-invalid @enderror" name="urltwt"
                                    value="{{ old('urltwt', $agent->URL_TWT) }}">
                                @error('urltwt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-10">
                            <label class="form-label" style="color: black"><b>Photo</b> </label>
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-12 mb-20">
                                    <input type="file" id="image" accept=".jpg, .png, .jpeg"
                                        class="form-control @error('image') is-invalid @enderror"
                                        placeholder="Choisir fichier" name="image">
                                    @if (!empty($agent->PATH_PERS))
                                        <img src="{{ asset($agent->PATH_PERS) }}" alt="image personne"
                                            style="height: 150px; width:150px;">
                                    @endif
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-fw fa-check-circle-o"></i>Valider
                                    </button>
                                    <button class="btn btn-outline-secondary" type="button" onclick="cancel();">
                                        <i class="fa fa-fw fa-times-circle-o"></i>Annuler
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-10">
                            @error('ajaxmess')
                                <div class="text-center" style="color: red">{{ $message }}</div>
                            @enderror
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
            var rout = "{{ route('agentList') }}";
            window.open(rout, '_self');
        }
    </script>
@endsection
