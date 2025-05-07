<?php

namespace App\Models;

use Help;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    protected $table = "ImmoClient";
    protected $primaryKey = "ID_CLIENT";
    public $timestamps = false;

    protected $fillable = [
        "ID_CLIENT" ,
        "CIVILITE",
        "NOM",
        "PRENOMS",
        "CONTACT",
        "NATIONALITE",
        "ADR_EMAIL",
        "LIB_VILLE",
        "ADRESSE",
        "BOITE_POSTALE",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "ID_PAYS",
        "LIB_PAYS",
        "ID_VILLE",
        "AVATAR",
    ];
    use HasFactory;

    public static function NbClient(){
        return Client::count();
    }
    public static function dataListe($idEntreprise) {
        return Client::orderBy('NOM')->join('ImmoClientEntreprise',
        'ImmoClientEntreprise.ID_CLIENT', '=', 'ImmoClient.ID_CLIENT')
        ->where('ID_ENTREPRISE', $idEntreprise)
        ->where('ImmoClientEntreprise.STATUT', Help::$ACTIF)->get();
    }
    public static function cliListe($idEntreprise) {
        $data = DB::select('
            SELECT DISTINCT
                "ImmoClient".*
            FROM
                "ImmoClient" INNER JOIN "ImmoClientEntreprise"
                ON "ImmoClientEntreprise"."ID_CLIENT" = "ImmoClient"."ID_CLIENT"
            WHERE
                "ImmoClient"."ID_CLIENT" IN
                (
                    SELECT
                        "ImmoAffaires"."ID_CLIENT" AS "ID_CLIENT"
                    FROM
                        "ImmoAffaires"
                    WHERE
                        "ImmoAffaires"."STATUT" = 1
                    AND "ImmoAffaires"."ID_ENTREPRISE" = '.$idEntreprise.'
                )
            AND "ImmoClientEntreprise"."STATUT" = 1
            AND "ImmoClientEntreprise"."ID_ENTREPRISE" = '.$idEntreprise.'
        ');
        return $data;
    }

    public static function LireSurEmail(String $email): Client{
        $client = Client::where('ADR_EMAIL', $email)->first();
        if(isset($client->ID_CLIENT) && $client->ID_CLIENT > 0) return $client;
        else return new Client();
    }
    public static function checkOthersEmail(String $currentemail, String $email): Client{
        $client = Client::where('ADR_EMAIL', $email)
        ->where('ADR_EMAIL', '!=', $currentemail)->get()->first();
        if(isset($client->ID_CLIENT) && $client->ID_CLIENT > 0) return $client;
        else return new Client();
    }

    public static function LireSurID($idClient){
        $client = Client::selectRaw('
            "ImmoClient".*,
            "Pays"."LIB_PAYS" as "LIB_PAYS",
            "Ville"."LIB_VILLE" as "LIB_VILLE",
            "ImmoUtilisateur"."AVATAR" as "AVATAR"
        ')
        ->join('ImmoUtilisateur', 'ImmoUtilisateur.ID_CLIENT', '=', 'ImmoClient.ID_CLIENT')
        ->join('Pays', 'Pays.ID_PAYS', '=', 'ImmoClient.ID_PAYS')
        ->join('Ville', 'Ville.ID_VILLE', '=', 'ImmoClient.ID_VILLE')
        ->where('ImmoClient.ID_CLIENT', $idClient)->get()->first();
        if(isset($client->ID_CLIENT)) return $client;
        else return new Client();
    }

    public static function tdbStats($idClient){
        $data = DB::select('
            SELECT
                *
            FROM
            (
                SELECT
                SUM("ImmoClientRedevances"."TOTAL_A_PAYER") AS "TOTAL",
                SUM("ImmoClientRedevances"."TOTAL_PAYER") AS "PAYER",
                SUM("ImmoClientRedevances"."REST_A_PAYER") AS "SOLDE",
                "ImmoAffaires"."ID_AFFAIRES" AS "ID_AFFAIRES",
                "ImmoAffaires"."LIB_PROPRIETE" AS "LIB_PROPRIETE"
                FROM "ImmoClientRedevances"
                INNER JOIN "ImmoAffaires" ON "ImmoAffaires"."ID_AFFAIRES" = "ImmoClientRedevances"."ID_AFFAIRES"
                WHERE
                "ImmoAffaires"."STATUT" = 1
                AND "ImmoClientRedevances"."STATUT" = 1
                AND "ImmoClientRedevances"."ID_CLIENT"= '.$idClient.'
                GROUP BY "ImmoAffaires"."ID_AFFAIRES", "ImmoAffaires"."LIB_PROPRIETE"
            ) AS t
            ORDER BY t."ID_AFFAIRES"
        ');
        if (isset($data[0])) return $data[0];
        else return new Client;
    }

    public static function paiementEnCours($idClient){
        $data = DB::select('
            SELECT
                "ImmoClientRedevances"."ID_LIAIS" as "ID_LIAIS",
                "ImmoClientRedevances"."ID_AFFAIRES" as "ID_AFFAIRES",
                "ImmoClientRedevances"."TOTAL_A_PAYER" as "TOTAL_A_PAYER",
                "ImmoClientRedevances"."TOTAL_PAYER" as "TOTAL_PAYER",
                "ImmoClientRedevances"."REST_A_PAYER" as "REST_A_PAYER",
                "ImmoClientRedevances"."DATE_FIN_PAY" as "DATE_FIN_PAY",
                "ImmoRedevances"."LIB_REDEVANCES" as "LIB_REDEVANCES",
                concat("ImmoAffaires"."LIB_PROPRIETE",\' (\',"ImmoAffaires"."ADRESSE",\')\') as "LIB_PROPRIETE"
            FROM
                "ImmoClientRedevances" INNER JOIN "ImmoAffaires" ON
                "ImmoAffaires"."ID_AFFAIRES" = "ImmoClientRedevances"."ID_AFFAIRES"
                INNER JOIN "ImmoRedevances" ON "ImmoRedevances"."ID_REDEVANCES" = "ImmoClientRedevances"."ID_REDEVANCES"
            WHERE
            "ImmoAffaires"."STATUT" = 1
            AND "ImmoClientRedevances"."STATUT" = 1
            AND "ImmoClientRedevances"."REST_A_PAYER" > 0
            AND "ImmoClientRedevances"."ID_CLIENT" = '.$idClient.'
            ORDER BY "ImmoClientRedevances"."ID_LIAIS" DESC
        ');
        return $data;
    }

}
