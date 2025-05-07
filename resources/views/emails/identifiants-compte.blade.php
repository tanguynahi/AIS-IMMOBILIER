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
            Objet : Mot de passe et / ou Identifiant Immobilier-Store.
        </p>
        <p>
            Bonjour {{ $NomPrenoms ?? ',' }},<br />
            Compte client : IMS-{{ $id ?? 'xxxxxx' }}
        </p>
        <p>
            <br />
            Votre nouvel identifiant client chez Immobilier-Store vient d'être créer, voici vos paramètres : <br />
            <br />
            Login : {{ $login ?? (IMS - $id ?? 'xxxxxx') }}<br />
            Mot de passe : {{ $mdp ?? '012024' }} <br />
            <br />
            NB: Vous avez 48h pour modifier votre mot de passe. <br />
            <br />
            Connectez vous à votre espace client via ce lien : <br />
            <br />
            {{ Help::_domaine() }}connexion <br />
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
