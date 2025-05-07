<?php

namespace App\Models;

use Help;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientRedevances extends Model
{
    protected $table = "ImmoClientRedevances";
    protected $primaryKey = "ID_LIAIS";
    public $timestamps = false;

    protected $fillable = [
        "ID_LIAIS",
        "ID_AFFAIRES",
        "ID_CLIENT",
        "ID_PROPRIETES",
        "ID_REDEVANCES",
        "MONTANT_REDEV",
        "ID_TYPE_PERIODE",
        "MONTANT_PERIOD",
        "NB_FREQUENCE",
        "DATE_DBT_PAY",
        "DATE_NXT_PAY",
        "DATE_FIN_PAY",
        "TOTAL_A_PAYER",
        "TOTAL_PAYER",
        "REST_A_PAYER",
        "TOTAL_RESIDUEL",
        "DATE_LIAIS",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "ID_ENTREPRISE",
        "ID_UTILISATEUR",
        "LIB_CLIENT",
        "LIB_PROPRIETE",
        "LIB_PERIODE",
        "LIB_REDEVANCES",
        "MONTANT_AFF",
        "DATE_CONCLUS",
    ];
    use HasFactory;

    public static function dataListe($idEntreprise) {
        $data = DB::select('
            SELECT
                "ImmoClientRedevances".*,
                "ImmoProprietesAffaire"."LIB_PROPRIETE" AS "LIB_PROPRIETE",
                concat("ImmoClient"."NOM",\' \',"ImmoClient"."PRENOMS") as "LIB_CLIENT",
                "TypePeriode"."LIB_PERIODE" as "LIB_PERIODE",
                "ImmoRedevances"."LIB_REDEVANCES" as "LIB_REDEVANCES"
            FROM
                "ImmoClientRedevances" INNER JOIN "ImmoClient" ON "ImmoClient"."ID_CLIENT" = "ImmoClientRedevances"."ID_CLIENT"
                INNER JOIN "ImmoProprietesAffaire" ON "ImmoProprietesAffaire"."ID_AFFAIRES" = "ImmoClientRedevances"."ID_AFFAIRES"
                INNER JOIN "ImmoRedevances" ON "ImmoRedevances"."ID_REDEVANCES" = "ImmoClientRedevances"."ID_REDEVANCES"
                INNER JOIN "TypePeriode" ON "TypePeriode"."ID_TYPE_PERIODE" = "ImmoClientRedevances"."ID_TYPE_PERIODE"
            WHERE
                "ImmoClientRedevances"."STATUT" = '.Help::$ACTIF.'
                AND "ImmoClientRedevances"."ID_ENTREPRISE" = '.$idEntreprise.'
        ');
        return $data;
    }

    public static function checkLiaisonSurRedevanceAffaire($idEntreprise, $idRedevance, $idAffaire) {
        $data = DB::select('
            SELECT
                "ImmoClientRedevances".*
            FROM
                "ImmoClientRedevances" INNER JOIN "ImmoAffaires" ON "ImmoAffaires"."ID_AFFAIRES" = "ImmoClientRedevances"."ID_AFFAIRES"
                INNER JOIN "ImmoRedevances" ON "ImmoRedevances"."ID_REDEVANCES" = "ImmoClientRedevances"."ID_REDEVANCES"
            WHERE
                "ImmoClientRedevances"."STATUT" = '.Help::$ACTIF.'
                AND "ImmoClientRedevances"."ID_AFFAIRES" = '.$idAffaire.'
                AND "ImmoClientRedevances"."ID_REDEVANCES" = '.$idRedevance.'
                AND "ImmoClientRedevances"."ID_ENTREPRISE" = '.$idEntreprise.'
            LIMIT 1
        ');
        if (isset($data[0])) return $data[0];
        else return new ClientRedevances;
    }

    public static function LireSurID(int $id){
        $data = ClientRedevances::find($id);
        if (isset($data->ID_LIAIS))return $data;
        else new ClientRedevances;
    }

    public static function dataSave(Request $request, ClientRedevances $obj): ClientRedevances{
        if($request->id > 0){
            $obj = self::LireSurID($request->id);
            if(!isset($obj->ID_LIAIS)) return new ClientRedevances();
            else $obj->DATEMAJ = Help::dhSys();
        }else{
            $obj->STATUT = Help::$ACTIF;
            $obj->DATECREA = Help::dhSys();
        }
        $obj->ID_AFFAIRES = $request->Affaire;
        $obj->ID_CLIENT = $request->Client;
        $obj->ID_PROPRIETES = $request->Propriete;
        $obj->ID_REDEVANCES = $request->Redevance;
        $obj->MONTANT_REDEV = $request->MontRed;
        $obj->ID_TYPE_PERIODE = $request->Period;
        $obj->MONTANT_PERIOD = $request->MontPeriod;
        $obj->NB_FREQUENCE = $request->Freq;
        $obj->DATE_DBT_PAY = $request->DateDeb;
        $obj->DATE_NXT_PAY = $request->DateNext;
        $obj->DATE_FIN_PAY = $request->DateFin;
        $obj->TOTAL_A_PAYER = $request->Total;
        $obj->REST_A_PAYER = $request->Rest;
        $obj->DATE_LIAIS = $request->Date;
        if($obj->save()) return $obj;
        else return new ClientRedevances();
    }

    public static function dataDesact(int $id): bool{
        $data = ClientRedevances::find($id);
        if (isset($data->ID_LIAIS)){
            $data->DATEMAJ = Help::dhSys();
            ($data->STATUT == 1)? $data->STATUT = Help::$INACTIF: $data->STATUT = Help::$ACTIF;
        }
        return $data->save();
    }

    public static function cliListeRedevanceSurAffaire($idAffaire) {
        $data = DB::select('
            SELECT
                "ImmoClientRedevances".*,
                "ImmoProprietesAffaire"."LIB_PROPRIETE" AS "LIB_PROPRIETE",
                concat("ImmoClient"."NOM",\' \',"ImmoClient"."PRENOMS") as "LIB_CLIENT",
                "TypePeriode"."LIB_PERIODE" as "LIB_PERIODE",
                "ImmoRedevances"."LIB_REDEVANCES" as "LIB_REDEVANCES"
            FROM
                "ImmoClientRedevances" INNER JOIN "ImmoClient" ON "ImmoClient"."ID_CLIENT" = "ImmoClientRedevances"."ID_CLIENT"
                INNER JOIN "ImmoProprietesAffaire" ON "ImmoProprietesAffaire"."ID_AFFAIRES" = "ImmoClientRedevances"."ID_AFFAIRES"
                INNER JOIN "ImmoRedevances" ON "ImmoRedevances"."ID_REDEVANCES" = "ImmoClientRedevances"."ID_REDEVANCES"
                INNER JOIN "TypePeriode" ON "TypePeriode"."ID_TYPE_PERIODE" = "ImmoClientRedevances"."ID_TYPE_PERIODE"
            WHERE
                "ImmoClientRedevances"."STATUT" = '.Help::$ACTIF.'
                AND "ImmoClientRedevances"."ID_AFFAIRES" = '.$idAffaire.'
        ');
        return $data;
    }

    public static function listeRedevanceSurAffaire($idEntreprise, $idAffaire) {
        $data = DB::select('
            SELECT
                "ImmoClientRedevances".*,
                "ImmoProprietesAffaire"."LIB_PROPRIETE" AS "LIB_PROPRIETE",
                concat("ImmoClient"."NOM",\' \',"ImmoClient"."PRENOMS") as "LIB_CLIENT",
                "TypePeriode"."LIB_PERIODE" as "LIB_PERIODE",
                "ImmoRedevances"."LIB_REDEVANCES" as "LIB_REDEVANCES"
            FROM
                "ImmoClientRedevances" INNER JOIN "ImmoClient" ON "ImmoClient"."ID_CLIENT" = "ImmoClientRedevances"."ID_CLIENT"
                INNER JOIN "ImmoProprietesAffaire" ON "ImmoProprietesAffaire"."ID_AFFAIRES" = "ImmoClientRedevances"."ID_AFFAIRES"
                INNER JOIN "ImmoRedevances" ON "ImmoRedevances"."ID_REDEVANCES" = "ImmoClientRedevances"."ID_REDEVANCES"
                INNER JOIN "TypePeriode" ON "TypePeriode"."ID_TYPE_PERIODE" = "ImmoClientRedevances"."ID_TYPE_PERIODE"
            WHERE
                "ImmoClientRedevances"."STATUT" = '.Help::$ACTIF.'
                AND "ImmoClientRedevances"."ID_AFFAIRES" = '.$idAffaire.'
                AND "ImmoClientRedevances"."ID_ENTREPRISE" = '.$idEntreprise.'
        ');
        return $data;
    }

    public static function cliLireFacturationSurID($idLiais) {
        $data = DB::select('
            SELECT
                "ImmoClientRedevances".*,
                "TypePeriode"."LIB_PERIODE" as "LIB_PERIODE",
                "ImmoRedevances"."LIB_REDEVANCES" as "LIB_REDEVANCES"
            FROM
                "ImmoClientRedevances" INNER JOIN "TypePeriode" ON "TypePeriode"."ID_TYPE_PERIODE" = "ImmoClientRedevances"."ID_TYPE_PERIODE"
                INNER JOIN "ImmoRedevances" ON "ImmoRedevances"."ID_REDEVANCES" = "ImmoClientRedevances"."ID_REDEVANCES"
            WHERE
                "ImmoClientRedevances"."STATUT" = '.Help::$ACTIF.'
                AND "ImmoClientRedevances"."ID_LIAIS" = '.$idLiais.'
            LIMIT 1
        ');
        if (isset($data[0])) return $data[0];
        else return new ClientRedevances;
    }

    public static function lireFacturationSurID($idEntreprise, $idLiais) {
        $data = DB::select('
            SELECT
                "ImmoClientRedevances".*,
                "TypePeriode"."LIB_PERIODE" as "LIB_PERIODE",
                "ImmoRedevances"."LIB_REDEVANCES" as "LIB_REDEVANCES"
            FROM
                "ImmoClientRedevances" INNER JOIN "TypePeriode"
                ON "TypePeriode"."ID_TYPE_PERIODE" = "ImmoClientRedevances"."ID_TYPE_PERIODE"
                INNER JOIN "ImmoRedevances" ON "ImmoRedevances"."ID_REDEVANCES" = "ImmoClientRedevances"."ID_REDEVANCES"
            WHERE
                "ImmoClientRedevances"."STATUT" = '.Help::$ACTIF.'
                AND "ImmoClientRedevances"."ID_LIAIS" = '.$idLiais.'
                AND "ImmoClientRedevances"."ID_ENTREPRISE" = '.$idEntreprise.'
            LIMIT 1
        ');
        if (isset($data[0])) return $data[0];
        else return new ClientRedevances;
    }

}
