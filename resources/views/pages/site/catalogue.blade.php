@extends('layouts.s_template', ['titre' => $titre])

@section('content')
    @include('partials.site.sub-banner', ['element' => 'Catalogue Propriétés'])
    @livewire('recherche-propriete', ['request' => $request])
@endsection

@section('js')
    <script>
        $("#IDPays").on('change', function() {
            var id = $("#IDPays").val();
            var url = "{{ route('donneVilleList', ['IDPays' => ':IDPays']) }}";
            url = url.replace(":IDPays", id);
            $.ajax({
                type: "get",
                url: url,
                contentType: "application/json",
                success: function(data) {
                    console.log(data);
                    $('#IDVille').empty();
                    var valeur = `<option value="" selected disabled>Choisir ville..</option>`;
                    if (data.length > 0) {
                        valeur = `<option value="0">Tous</option>`;
                        data.forEach((d) => {
                            valeur +=
                                ` <option value="${ d.ID_VILLE }">${ d.LIB_VILLE }</option>`;
                        });
                    }
                    $('#IDVille').append(valeur);
                },
                error: function(data) {
                    console.log(data);
                    $("#output").text('Erreur interne du serveur !');
                }
            });
        });
    </script>
@endsection
