@extends('layouts.c_template', ['titre' => $titre])

@section('content')
    @include('partials.client.breadcrumb-navcli', ['LBL' => 'Fiche Paiement'])
    @livewire('formulaire-paiement', ['idLIAS'=>$id])
@endsection
@section('js')
    <script>

        var ajaxmess = $('#outmess');
        var ajaxredv = $('#outredv');
        ajaxmess.text(""); ajaxmess.css('color', 'red');
        ajaxredv.text(""); ajaxredv.css('color', 'red');

        function actionLiaison() {
            RazRedChps();
            ajaxredv.text('');
            var id = $("#liais_id").val();
            $("#formPAY").hide('1000');
            $("#chp_redev").hide('1000');
            if (id>0) {
                var url = "{{ route('lireLIAIS', ['id' => ':id']) }}";
                url = url.replace(":id", id);
                $.ajax({
                    type: "get",
                    url: url,
                    contentType: "application/json",
                    success: function(data) {
                        console.log(data);
                        if (typeof data.ID_LIAIS != undefined) {
                            if (data.TOTAL_A_PAYER==data.TOTAL_PAYER) {
                                ajaxredv.css('color', 'green');
                                ajaxredv.focus(); ajaxredv.text('Vous êtes à jour de paiement pour cette redevance !');
                            }else{
                                console.log(data);
                                var montPeriod = new Intl.NumberFormat().format(data.MONTANT_PERIOD);
                                var totalAP = new Intl.NumberFormat().format(data.TOTAL_A_PAYER);
                                var totalP = new Intl.NumberFormat().format(data.TOTAL_PAYER);
                                var totalRAP = new Intl.NumberFormat().format(data.REST_A_PAYER);
                                document.getElementById("period").value = data.LIB_PERIODE;
                                document.getElementById("mont_period").value = montPeriod;
                                document.getElementById("freq").value = data.NB_FREQUENCE;
                                document.getElementById("date").value = data.DATE_LIAIS;
                                document.getElementById("total_mont").value = totalAP;
                                document.getElementById("total_paye").value = totalP;
                                document.getElementById("rest_paye").value = totalRAP;
                                if (data.ID_TYPE_PERIODE!=1 && data.ID_TYPE_PERIODE!=6 ) $("#mont_id").show('1000');
                                else $("#mont_id").hide('1000');
                                $("#chp_redev").show('1000');
                                $("#formPAY").show('1000');
                            }
                        }else{ ajaxredv.focus(); ajaxredv.text('Echec de recupération des informations redevance !'); }
                    }, error: function(data) { ajaxredv.focus(); ajaxredv.text('alert: Erreur interne du serveur !'); }
                });
            }
        }

        function RazRedChps() {
            document.getElementById("period").value = "";
            document.getElementById("mont_period").value = "";
            document.getElementById("freq").value = "";
            document.getElementById("date").value = "";
            document.getElementById("total_mont").value = "";
            document.getElementById("total_paye").value = "";
            document.getElementById("rest_paye").value = "";
        }
        $("#liais_id").on('change', function() { actionLiaison(); });

        function cancel() { rout = "{{route('paiemClientList')}}"; window.open(rout, '_self'); }

        function onlinePAY() {
            ajaxmess.text("");
            document.getElementById("btn2").disabled = true;
            document.getElementById("btn2").innerHTML = 'Patientez...';
            ajaxmess.css('color', 'red');
            var id = $("#liais_id").val();;
            var mont = document.getElementById("mont").value;
            console.log(mont , id);
            var rout = "{{ route('payboxHub') }}";
            var csrf = document.querySelector('meta[name="csrf-token"]').content;
            var csrf_field = '<input type="hidden" name="_token" value=“'+csrf+'”>';
            $('form').append(csrf_field);
            $.ajaxSetup({
                beforeSend: function (xhr, settings) {
                if (settings.url.indexOf(document.domain) >= 0) {xhr.setRequestHeader("X-CSRF-Token", csrf);} }
            });
            $.ajax({
                type: 'post',
                url: rout,
                _token: csrf,
                data: {
                    param: id,
                    montant: mont,
                },
                // console.log(data);
                success: function(res) {
                    console.log(res);
                    if (res.code != '200') {
                        ajaxmess.focus(); ajaxmess.text(res.mess);
                        document.getElementById("btn2").disabled = false;
                        document.getElementById("btn2").innerHTML = 'Passez au paiement';
                    }else{ window.open(res.data, '_self'); }
                },
                error: function(res) {
                    console.log('le log erreur '+res); ajaxmess.focus();
                    document.getElementById("btn2").disabled = false;
                    ajaxmess.text('alert: Erreur interne du serveur dd !');
                    document.getElementById("btn2").innerHTML = 'Passez au paiement';
                }
            });
        }

    </script>
@endsection
