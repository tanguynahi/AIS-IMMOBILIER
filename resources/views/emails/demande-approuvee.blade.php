<html>

<head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
</head>
<style>
    body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
    }

    h1 {
        color: #88B04B;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-weight: 900;
        font-size: 40px;
        margin-bottom: 10px;
    }

    p {
        color: #404F5E;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-size: 20px;
        margin: 0;
    }

    i {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left: -15px;
    }

    .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
    }
</style>

<body>
    <div class="card">
        <p>
            Abidjan le: {{ Help::dateheureFormate(Help::dhSys(),'/') }} <br />
            Objet : Demande approuvée</b>.
        </p>
        <p>
            Bonjour {{ $NomPrenoms ?? ',' }},
        </p>
        <p>
            Votre demande de <b>{{Help::LibelleTypeDemande($demande->TYPE_DEMAND ?? 0)}}</b>
            a été approuvée, <br />
            <br />
            @if ($demande->TYPE_DEMAND==1)
            Date visite : {{ $demande->DATE_VISIT ?? 'JJ/MM/AAAA' }} <br />
            Heure : {{ $demande->HEUR_VISIT ?? 'HH:MM' }} <br />
            <br />
            @endif
            Propriete : {{ $propriete->LIB_PROPRIETE ?? 'xxxxxxxxxx' }} <br />
            Categorie : {{ $propriete->LIB_CATEGORIE ?? 'xxxxxxxxxx' }} <br />
            Type : {{ $propriete->LIB_TYPE ?? 'xxxxxxxxxx' }} <br />
            Année : {{ $propriete->ANNEE ?? 'xxxx' }} <br />
            Adresse : {{ $propriete->ADRESSE ?? 'xxxxxx, xxxxxx, xxxxxx' }} <br />
            Prix : <b>{{ Help::formatNombre($propriete->PRIX_HT ?? '0', true) }}</b> <br />
            <br />
            NB: Vous serez contacté dans les heures pour la suite. <br />
            <br />
            Plus d'infos sur nos services : {{ Help::_domaine() }}nous-contacter <br />
            <br />
            Nous vous remercions de la confiance que vous nous accordez. <br />
            Cordialement, <br />
            L'équipe Ligne, disponible 7j/7 via votre espace client <br />
            - Pour une assistance technique <br />
            - Pour une assistance commerciale
            <br />
            Ceci est un mail automatique, vous ne pouvez pas y répondre. <br />
            Contactez-nous directement via votre espace client via la rubrique MESSAGE. <br />
            (ref mail {{ $idmail ?? 'xxxx' }})
        </p>
    </div>
</body>

</html>
