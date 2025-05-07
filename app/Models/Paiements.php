<?php

namespace App\Models;

use Help;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paiements extends Model
{
    protected $table = "ImmoPaiements";
    protected $primaryKey = "ID_PAIEMENTS";
    public $timestamps = false;

    protected $fillable = [
        "ID_PAIEMENTS",
        "ID_CLIENT",
        "ID_LIAIS",
        "REFERENCE_P",
        "SERVICE_ID",
        "LIB_SERVICE_ID",
        "NO_TRANSACTION",
        "MONTANT",
        "DATE_PAIEMENT",
        "HEURE_PAIEMENT",
        "SOLDE_AVANT",
        "SOLDE_APRES",
        "CHAINEJSON",
        "ID_REFPAIEMENT",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "ID_ENTREPRISE",
        "MOTIFS",
        "ID_UTILISATEUR",
        "LIB_REDEVANCES",
        "LIB_PERIODE",
        "LIB_PROPRIETE",
    ];
    use HasFactory;

    public static function tdbStats($id){
        $data = DB::select('
            SELECT SUM("ImmoPaiements"."MONTANT") AS "MONTANT"
            FROM "ImmoPaiements"
            WHERE "ImmoPaiements"."STATUT" = 1 AND "ImmoPaiements"."ID_ENTREPRISE" = '.$id.'
        ');
        if (isset($data[0])) return $data[0];
        else return new Paiements;
    }

    public static function dataListe ($id) {
        return Paiements::query()
        ->selectRaw('"ImmoPaiements".*, "ImmoRefPaiement"."STATUT_CODE" as "STATUT_CODE"')
        ->leftJoin('ImmoRefPaiement', 'ImmoRefPaiement.ID_REFPAIEMENT', '=', 'ImmoPaiements.ID_PAIEMENTS')
        ->orderBy('ImmoPaiements.ID_PAIEMENTS', 'desc')
        ->where('ImmoRefPaiement.ID_LIAIS', '=', $id)
        ->where('ImmoRefPaiement.STATUT_CODE', '>', 0)->get();
    }

    public static function checkReferencePaiement ($idLiais, $Reference) {
        return Paiements::where('ImmoPaiements.ID_LIAIS', $idLiais)
        ->where('ImmoPaiements.REFERENCE_P', $Reference)->first();
    }

    public static function paiementListe($idCli, $idEntreprise, $idAff, $idLiais, $dmin, $dmax) {
        $str = '
            SELECT
                "ImmoPaiements".*,
                "ImmoAffaires"."LIB_PROPRIETE" AS "LIB_PROPRIETE",
                concat("ImmoClient"."NOM",\' \',"ImmoClient"."PRENOMS") as "LIB_CLIENT",
                "TypePeriode"."LIB_PERIODE" as "LIB_PERIODE",
                "ImmoRedevances"."LIB_REDEVANCES" as "LIB_REDEVANCES"
            FROM
                "ImmoPaiements" INNER JOIN "ImmoClientRedevances" ON "ImmoClientRedevances"."ID_LIAIS" = "ImmoPaiements"."ID_LIAIS"
                INNER JOIN "ImmoAffaires" ON "ImmoAffaires"."ID_AFFAIRES" = "ImmoClientRedevances"."ID_AFFAIRES"
                INNER JOIN "ImmoClient" ON "ImmoClient"."ID_CLIENT" = "ImmoClientRedevances"."ID_CLIENT"
                INNER JOIN "ImmoRedevances" ON "ImmoRedevances"."ID_REDEVANCES" = "ImmoClientRedevances"."ID_REDEVANCES"
                INNER JOIN "TypePeriode" ON "TypePeriode"."ID_TYPE_PERIODE" = "ImmoClientRedevances"."ID_TYPE_PERIODE"
            WHERE
                "ImmoPaiements"."ID_ENTREPRISE" = '.$idEntreprise.'
                AND LEFT("ImmoPaiements"."DATECREA", 8) BETWEEN \''.str_replace('-', '', $dmin).'\'
                AND \''.str_replace('-', '', $dmax).'\'
        ';
        if ($idCli>0){ $str .= ' AND "ImmoPaiements"."ID_CLIENT" = '.$idCli; }
        if ($idLiais>0){ $str .= ' AND "ImmoPaiements"."ID_LIAIS" = '.$idLiais; }
        if ($idAff>0){ $str .= ' AND "ImmoClientRedevances"."ID_AFFAIRES" = '.$idAff; }
        $str .= ' ORDER BY "ID_PAIEMENTS" DESC';
        $data = DB::select($str);
        return $data;
    }

    public static function listePaiementClientSurID($idClient) {
        $data = DB::select('
            SELECT
                "ImmoPaiements".*,
                "ImmoAffaires"."LIB_PROPRIETE" AS "LIB_PROPRIETE",
                concat("ImmoClient"."NOM",\' \',"ImmoClient"."PRENOMS") as "LIB_CLIENT",
                "TypePeriode"."LIB_PERIODE" as "LIB_PERIODE",
                "ImmoRedevances"."LIB_REDEVANCES" as "LIB_REDEVANCES"
            FROM
                "ImmoPaiements" INNER JOIN "ImmoClientRedevances" ON "ImmoClientRedevances"."ID_LIAIS" = "ImmoPaiements"."ID_LIAIS"
                INNER JOIN "ImmoAffaires" ON "ImmoAffaires"."ID_AFFAIRES" = "ImmoClientRedevances"."ID_AFFAIRES"
                INNER JOIN "ImmoClient" ON "ImmoClient"."ID_CLIENT" = "ImmoClientRedevances"."ID_CLIENT"
                INNER JOIN "ImmoRedevances" ON "ImmoRedevances"."ID_REDEVANCES" = "ImmoClientRedevances"."ID_REDEVANCES"
                INNER JOIN "TypePeriode" ON "TypePeriode"."ID_TYPE_PERIODE" = "ImmoClientRedevances"."ID_TYPE_PERIODE"

            WHERE
                "ImmoPaiements"."ID_CLIENT" = '.$idClient.'
            ORDER BY "ID_PAIEMENTS" DESC
        ');
        return $data;
    }

    public static function paiementSurCliIDAffIDLiaisID($idClient, $idAff, $idLiais, $dmin, $dmax) {
        $str = '
            SELECT
                "ImmoPaiements".*,
                "ImmoAffaires"."LIB_PROPRIETE" AS "LIB_PROPRIETE",
                concat("ImmoClient"."NOM",\' \',"ImmoClient"."PRENOMS") as "LIB_CLIENT",
                "TypePeriode"."LIB_PERIODE" as "LIB_PERIODE",
                "ImmoRedevances"."LIB_REDEVANCES" as "LIB_REDEVANCES"
            FROM
                "ImmoPaiements" INNER JOIN "ImmoClientRedevances" ON "ImmoClientRedevances"."ID_LIAIS" = "ImmoPaiements"."ID_LIAIS"
                INNER JOIN "ImmoAffaires" ON "ImmoAffaires"."ID_AFFAIRES" = "ImmoClientRedevances"."ID_AFFAIRES"
                INNER JOIN "ImmoClient" ON "ImmoClient"."ID_CLIENT" = "ImmoClientRedevances"."ID_CLIENT"
                INNER JOIN "ImmoRedevances" ON "ImmoRedevances"."ID_REDEVANCES" = "ImmoClientRedevances"."ID_REDEVANCES"
                INNER JOIN "TypePeriode" ON "TypePeriode"."ID_TYPE_PERIODE" = "ImmoClientRedevances"."ID_TYPE_PERIODE"
            WHERE
                "ImmoPaiements"."ID_CLIENT" = '.$idClient.'
                AND LEFT("ImmoPaiements"."DATECREA", 8) BETWEEN \''.str_replace('-', '', $dmin).'\'
                AND \''.str_replace('-', '', $dmax).'\'
        ';
        if ($idLiais>0){ $str .= ' AND "ImmoPaiements"."ID_LIAIS" = '.$idLiais; }
        if ($idAff>0){ $str .= ' AND "ImmoClientRedevances"."ID_AFFAIRES" = '.$idAff; }
        $str .= ' ORDER BY "ID_PAIEMENTS" DESC';
        $data = DB::select($str);
        return $data;
    }

    public static function listePaiementAffaireSurID($idAffaire) {
        $data = DB::select('
            SELECT
                "ImmoPaiements".*,
                "ImmoAffaires"."LIB_PROPRIETE" AS "LIB_PROPRIETE",
                concat("ImmoClient"."NOM",\' \',"ImmoClient"."PRENOMS") as "LIB_CLIENT",
                "TypePeriode"."LIB_PERIODE" as "LIB_PERIODE",
                "ImmoRedevances"."LIB_REDEVANCES" as "LIB_REDEVANCES"
            FROM
                "ImmoPaiements" INNER JOIN "ImmoClientRedevances" ON "ImmoClientRedevances"."ID_LIAIS" = "ImmoPaiements"."ID_LIAIS"
                INNER JOIN "ImmoAffaires" ON "ImmoAffaires"."ID_AFFAIRES" = "ImmoClientRedevances"."ID_AFFAIRES"
                INNER JOIN "ImmoClient" ON "ImmoClient"."ID_CLIENT" = "ImmoClientRedevances"."ID_CLIENT"
                INNER JOIN "ImmoRedevances" ON "ImmoRedevances"."ID_REDEVANCES" = "ImmoClientRedevances"."ID_REDEVANCES"
                INNER JOIN "TypePeriode" ON "TypePeriode"."ID_TYPE_PERIODE" = "ImmoClientRedevances"."ID_TYPE_PERIODE"
            WHERE
                "ImmoClientRedevances"."ID_AFFAIRES" = '.$idAffaire.'
        ');
        return $data;
    }

    public static function listePaiementLiaisonSurID($idLiais, $idEntreprise) {
        $data = DB::select('
            SELECT
                "ImmoPaiements".*,
                "ImmoAffaires"."LIB_PROPRIETE" AS "LIB_PROPRIETE",
                concat("ImmoClient"."NOM",\' \',"ImmoClient"."PRENOMS") as "LIB_CLIENT",
                "TypePeriode"."LIB_PERIODE" as "LIB_PERIODE",
                "ImmoRedevances"."LIB_REDEVANCES" as "LIB_REDEVANCES"
            FROM
                "ImmoPaiements" INNER JOIN "ImmoClientRedevances" ON "ImmoClientRedevances"."ID_LIAIS" = "ImmoPaiements"."ID_LIAIS"
                INNER JOIN "ImmoAffaires" ON "ImmoAffaires"."ID_AFFAIRES" = "ImmoClientRedevances"."ID_AFFAIRES"
                INNER JOIN "ImmoClient" ON "ImmoClient"."ID_CLIENT" = "ImmoClientRedevances"."ID_CLIENT"
                INNER JOIN "ImmoRedevances" ON "ImmoRedevances"."ID_REDEVANCES" = "ImmoClientRedevances"."ID_REDEVANCES"
                INNER JOIN "TypePeriode" ON "TypePeriode"."ID_TYPE_PERIODE" = "ImmoClientRedevances"."ID_TYPE_PERIODE"
            WHERE
                "ImmoPaiements"."ID_LIAIS" = '.$idLiais.'
                AND "ImmoPaiements"."ID_ENTREPRISE" = '.$idEntreprise.'
        ');
        return $data;
    }

    public static function cliLirePaiementSurID($idPaiement) {
        $data = DB::select('
            SELECT
                "ImmoPaiements".*,
                "ImmoClientRedevances"."ID_AFFAIRES" as "ID_AFFAIRES"
            FROM
                "ImmoPaiements" INNER JOIN "ImmoClientRedevances"
                ON "ImmoClientRedevances"."ID_LIAIS" = "ImmoPaiements"."ID_LIAIS"
            WHERE
               "ImmoPaiements"."ID_PAIEMENTS" = '.$idPaiement.'
            LIMIT 1
        ');
        if (isset($data[0])) $data = $data[0];
        else $data = new Paiements();
        return $data;
    }

    public static function lirePaiementSurID($idPaiement, $idEntreprise) {
        $data = DB::select('
            SELECT
                "ImmoPaiements".*,
                "ImmoClientRedevances"."ID_AFFAIRES" as "ID_AFFAIRES"
            FROM
                "ImmoPaiements" INNER JOIN "ImmoClientRedevances"
                ON "ImmoClientRedevances"."ID_LIAIS" = "ImmoPaiements"."ID_LIAIS"
            WHERE
                "ImmoPaiements"."ID_PAIEMENTS" = '.$idPaiement.'
                AND "ImmoPaiements"."ID_ENTREPRISE" = '.$idEntreprise.'
            LIMIT 1
        ');
        if (isset($data[0])) $data = $data[0];
        else $data = new Paiements();
        return $data;
    }

    public static function dataDesact(int $idPaiement): bool{
        $data = Paiements::find($idPaiement);
        if (isset($data->ID_PAIEMENTS)){
            $data->DATEMAJ = Help::dhSys();
            $data->STATUT = Help::$INACTIF;
        }
        return $data->save();
    }
}
