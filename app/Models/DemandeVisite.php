<?php

namespace App\Models;

use Help;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DemandeVisite extends Model {

    protected $table = "ImmoDemandeVisite";
    protected $primaryKey = "ID_DEMANDE_VISIT";
    public $timestamps = false;

    protected $fillable = [
        "ID_DEMANDE_VISIT" ,
        "ID_PROPRIETES" ,
        "ID_CLIENT" ,
        "DATE_VISIT" ,
        "TYPE_DEMAND" ,
        "HEUR_VISIT" ,
        "MESSAGE" ,
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "ID_ENTREPRISE",
        "MOTIFS",
        "ID_UTILISATEUR",
        "AVATAR",
        "LIB_CLIENT",
        "ADRESSE",
        "ADR_EMAIL",
        "CONTACT",
        "LIB_PROPRIETE",
        "LIB_TYPE",
        "LIB_CATEGORIE",
        "PRIX_HT",
        "PRIX_PROMO",
        "EN_PROMOTION",
        "ADRESSE_P",
        "IMG_DEFAULT",
    ];
    use HasApiTokens, HasFactory, Notifiable;

    public function routeNotificationForMail(){
        return $this->ADR_EMAIL;
    }


    public static function checkDemParJour($idEntreprise, $idPropriete, $email){
        $data = DB::select('
            SELECT
                "ImmoDemandeVisite".*
            FROM
                "ImmoDemandeVisite" INNER JOIN "ImmoProspect"
                ON "ImmoProspect"."ID_PROSPECT" = "ImmoDemandeVisite"."ID_CLIENT"
            WHERE
                "ImmoProspect"."ADR_EMAIL" = \''.$email.'\'
                AND "ImmoDemandeVisite"."STATUT" = '.Help::$ENATTENTE.'
                AND "ImmoDemandeVisite"."ID_PROPRIETES" = '.$idPropriete.'
                AND "ImmoDemandeVisite"."ID_ENTREPRISE" = '.$idEntreprise.'
                AND LEFT("ImmoDemandeVisite"."DATECREA", 8) = \''.date("Ymd").'\'
            LIMIT 2
        ');
        return $data;
    }

    public static function dataListe(int $idEntreprise, $act) {

        $str = '
            SELECT
                "ImmoDemandeVisite".*,
                "ImmoUtilisateur"."AVATAR" as "AVATAR",
                concat("ImmoUtilisateur"."NOM",\' \',"ImmoUtilisateur"."PRENOMS") as "LIB_CLIENT",
                "ImmoUtilisateur"."ADR_EMAIL" as "ADR_EMAIL",
                "ImmoUtilisateur"."CONTACT" as "CONTACT",
                "ImmoProprietesAffaire"."IMG_DEFAULT" as "IMG_DEFAULT",
                "ImmoProprietesAffaire"."LIB_PROPRIETE" as "LIB_PROPRIETE",
                "ImmoProprietesAffaire"."ADRESSE" as "ADRESSE"
            FROM
                "ImmoDemandeVisite" INNER JOIN "ImmoUtilisateur" ON "ImmoUtilisateur"."ID_CLIENT" = "ImmoDemandeVisite"."ID_CLIENT"
                INNER JOIN "ImmoProprietesAffaire" ON "ImmoProprietesAffaire"."ID_PROPRIETES" = "ImmoDemandeVisite"."ID_PROPRIETES"
            WHERE
                "ImmoDemandeVisite"."STATUT" != '.Help::$INACTIF.'
                AND "ImmoDemandeVisite"."ID_ENTREPRISE" = '.$idEntreprise.'
        ';

        if ($act=='tdb') {
            $str .= ' AND LEFT("ImmoDemandeVisite"."DATECREA", 8) = \''.date("Ymd").'\'';
        }
        $str .= ' ORDER BY "ImmoDemandeVisite"."ID_DEMANDE_VISIT" DESC';

        $demandes = DB::select($str);
        return $demandes;
    }

    public static function demListe(int $idEntreprise, $act) {

        $str = '
            SELECT
                "ImmoDemandeVisite".*,
                concat("ImmoProspect"."NOM",\' \',"ImmoProspect"."PRENOMS") as "LIB_CLIENT",
                "ImmoProspect"."ADR_EMAIL" as "ADR_EMAIL",
                "ImmoProspect"."CONTACT" as "CONTACT",
                "ImmoProprietes"."IMG_DEFAULT" as "IMG_DEFAULT",
                "ImmoProprietes"."LIB_PROPRIETE" as "LIB_PROPRIETE",
                "ImmoProprietes"."ADRESSE" as "ADRESSE"
            FROM
                "ImmoDemandeVisite" INNER JOIN "ImmoProspect" ON "ImmoProspect"."ID_PROSPECT" = "ImmoDemandeVisite"."ID_CLIENT"
                INNER JOIN "ImmoProprietes" ON "ImmoProprietes"."ID_PROPRIETES" = "ImmoDemandeVisite"."ID_PROPRIETES"
            WHERE
                "ImmoDemandeVisite"."STATUT" != '.Help::$INACTIF.'
                AND "ImmoDemandeVisite"."ID_ENTREPRISE" = '.$idEntreprise.'
        ';

        if ($act=='tdb') {
            $str .= ' AND LEFT("ImmoDemandeVisite"."DATECREA", 8) = \''.date("Ymd").'\'';
            $str .= ' AND "ImmoDemandeVisite"."STATUT" = '.Help::$ENATTENTE;
        }
        $str .= ' ORDER BY "ImmoDemandeVisite"."ID_DEMANDE_VISIT" DESC';

        $demandes = DB::select($str);
        return $demandes;
    }

    public static function listeDemandeClient($idClient) {
        return DB::select('
            SELECT
                "ImmoDemandeVisite".*,
                concat("ImmoClient"."NOM",\' \',"ImmoClient"."PRENOMS") as "LIB_CLIENT",
                "ImmoClient"."ADR_EMAIL" as "ADR_EMAIL",
                "ImmoClient"."CONTACT" as "CONTACT",
                "ImmoProprietes"."IMG_DEFAULT" as "IMG_DEFAULT",
                "ImmoProprietes"."LIB_PROPRIETE" as "LIB_PROPRIETE",
                "ImmoProprietes"."ADRESSE" as "ADRESSE"
            FROM
                "ImmoDemandeVisite" INNER JOIN "ImmoProspect" ON "ImmoProspect"."ID_PROSPECT" = "ImmoDemandeVisite"."ID_CLIENT"
                INNER JOIN "ImmoClient" ON "ImmoClient"."ID_CLIENT" = "ImmoProspect"."ID_CLIENT"
                INNER JOIN "ImmoProprietes" ON "ImmoProprietes"."ID_PROPRIETES" = "ImmoDemandeVisite"."ID_PROPRIETES"
            WHERE
                "ImmoDemandeVisite"."STATUT" != '.Help::$INACTIF.'
                AND "ImmoClient"."ID_CLIENT" = '.$idClient.'
            ORDER BY
                "ImmoDemandeVisite"."ID_DEMANDE_VISIT" DESC
        ');
    }

    public static function LireSurID($id)
     {
        // $demande = DemandeVisite::selectRaw('
        //     "ImmoDemandeVisite".*,
        //     "ImmoUtilisateur"."AVATAR" as "AVATAR",
        //     concat("ImmoUtilisateur"."NOM",\' \',"ImmoUtilisateur"."PRENOMS") as "LIB_CLIENT",
        //     "ImmoUtilisateur"."ADR_EMAIL" as "ADR_EMAIL",
        //     "ImmoUtilisateur"."CONTACT" as "CONTACT",
        //     "ImmoClient"."ADRESSE" as "ADRESSE",
        //     "ImmoProprietes"."IMG_DEFAULT" as "IMG_DEFAULT",
        //     "ImmoProprietes"."LIB_PROPRIETE" as "LIB_PROPRIETE",
        //     "ImmoProprietes"."PRIX_HT" as "PRIX_HT",
        //     "ImmoProprietes"."ADRESSE" as "ADRESSE_P",
        //     "ImmoTypePropriete"."LIB_TYPE" AS "LIB_TYPE",
        //     "ImmoCategories"."LIB_CATEGORIE" as "LIB_CATEGORIE"
        // ')
        // ->join('ImmoUtilisateur', 'ImmoUtilisateur.ID_CLIENT', '=', 'ImmoDemandeVisite.ID_CLIENT')
        // ->join('ImmoClient', 'ImmoClient.ID_CLIENT', '=', 'ImmoDemandeVisite.ID_CLIENT')
        // ->join('ImmoProprietes', 'ImmoProprietes.ID_PROPRIETES', '=', 'ImmoDemandeVisite.ID_PROPRIETES')
        // ->join('ImmoCategories', 'ImmoCategories.ID_CATEGORIES', '=', 'ImmoProprietes.ID_CATEGORIES')
        // ->join('ImmoTypePropriete', 'ImmoTypePropriete.ID_TYPE_PROPRIETE', '=', 'ImmoProprietes.ID_TYPE_PROPRIETE')
        // ->where('ImmoDemandeVisite.ID_DEMANDE_VISIT', $id)->first();
        // if (!empty($demande->ID_DEMANDE_VISIT)) {
        //     return $demande;
        // }else{ return new DemandeVisite(); }


        // $demande = DB::select('
        //     SELECT
        //         "ImmoDemandeVisite".*,
        //         "ImmoUtilisateur"."AVATAR" as "AVATAR",
        //         concat("ImmoUtilisateur"."NOM",\' \',"ImmoUtilisateur"."PRENOMS") as "LIB_CLIENT",
        //         "ImmoUtilisateur"."ADR_EMAIL" as "ADR_EMAIL",
        //         "ImmoUtilisateur"."CONTACT" as "CONTACT",
        //         "ImmoClient"."ADRESSE" as "ADRESSE",
        //         "ImmoProprietes"."IMG_DEFAULT" as "IMG_DEFAULT",
        //         "ImmoProprietes"."LIB_PROPRIETE" as "LIB_PROPRIETE",
        //         "ImmoProprietes"."PRIX_HT" as "PRIX_HT",
        //         "ImmoProprietes"."ADRESSE" as "ADRESSE_P",
        //         "ImmoTypePropriete"."LIB_TYPE" AS "LIB_TYPE",
        //         "ImmoCategories"."LIB_CATEGORIE" as "LIB_CATEGORIE"
        //     FROM
        //         "ImmoDemandeVisite" INNER JOIN "ImmoUtilisateur" ON "ImmoUtilisateur"."ID_CLIENT" = "ImmoDemandeVisite"."ID_CLIENT"
        //         INNER JOIN "ImmoClient" ON "ImmoClient"."ID_CLIENT" = "ImmoDemandeVisite"."ID_CLIENT"
        //         INNER JOIN "ImmoProprietes" ON "ImmoProprietes"."ID_PROPRIETES" = "ImmoDemandeVisite"."ID_PROPRIETES"
        //         INNER JOIN "ImmoCategories" ON "ImmoCategories"."ID_CATEGORIES" = "ImmoProprietes"."ID_CATEGORIES"
        //         INNER JOIN "ImmoTypePropriete" ON "ImmoTypePropriete"."ID_TYPE_PROPRIETE" = "ImmoProprietes"."ID_TYPE_PROPRIETE"
        //     WHERE
        //         "ImmoDemandeVisite"."STATUT" != '.Help::$INACTIF.'
        //         AND "ImmoDemandeVisite"."ID_DEMANDE_VISIT" = '.$id.'
        //     LIMIT 1
        // ');
        // return $demande[0] ?? null;


        $demande = DB::select('
        SELECT
            "ImmoDemandeVisite".*,
            concat("ImmoProspect"."NOM",\' \',"ImmoProspect"."PRENOMS") as "LIB_CLIENT",
            "ImmoProspect"."ADR_EMAIL" as "ADR_EMAIL",
            "ImmoProspect"."CONTACT" as "CONTACT",
            "ImmoProspect"."ADRESSE" as "ADRESSE",
            "ImmoProprietes"."IMG_DEFAULT" as "IMG_DEFAULT",
            "ImmoProprietes"."LIB_PROPRIETE" as "LIB_PROPRIETE",
            "ImmoProprietes"."PRIX_HT" as "PRIX_HT",
            "ImmoProprietes"."ADRESSE" as "ADRESSE_P",
            "ImmoTypePropriete"."LIB_TYPE" AS "LIB_TYPE",
            "ImmoCategories"."LIB_CATEGORIE" as "LIB_CATEGORIE"
        FROM
            "ImmoDemandeVisite" INNER JOIN "ImmoProspect" ON "ImmoProspect"."ID_PROSPECT" = "ImmoDemandeVisite"."ID_CLIENT"
            INNER JOIN "ImmoProprietes" ON "ImmoProprietes"."ID_PROPRIETES" = "ImmoDemandeVisite"."ID_PROPRIETES"
            INNER JOIN "ImmoCategories" ON "ImmoCategories"."ID_CATEGORIES" = "ImmoProprietes"."ID_CATEGORIES"
            INNER JOIN "ImmoTypePropriete" ON "ImmoTypePropriete"."ID_TYPE_PROPRIETE" = "ImmoProprietes"."ID_TYPE_PROPRIETE"
        WHERE
            "ImmoDemandeVisite"."STATUT" != '.Help::$INACTIF.'
            AND "ImmoDemandeVisite"."ID_DEMANDE_VISIT" = '.$id.'
        LIMIT 1
    ');
    return $demande;

    }

    public static function demLireSurID(int $idEntreprise, $id) {
        $demande = DB::select('
            SELECT
                "ImmoDemandeVisite".*,
                concat("ImmoProspect"."NOM",\' \',"ImmoProspect"."PRENOMS") as "LIB_CLIENT",
                "ImmoProspect"."ADR_EMAIL" as "ADR_EMAIL",
                "ImmoProspect"."CONTACT" as "CONTACT",
                "ImmoProspect"."ADRESSE" as "ADRESSE",
                "ImmoProprietes"."IMG_DEFAULT" as "IMG_DEFAULT",
                "ImmoProprietes"."LIB_PROPRIETE" as "LIB_PROPRIETE",
                "ImmoProprietes"."PRIX_HT" as "PRIX_HT",
                "ImmoProprietes"."ADRESSE" as "ADRESSE_P",
                "ImmoTypePropriete"."LIB_TYPE" AS "LIB_TYPE",
                "ImmoCategories"."LIB_CATEGORIE" as "LIB_CATEGORIE"
            FROM
                "ImmoDemandeVisite" INNER JOIN "ImmoProspect" ON "ImmoProspect"."ID_PROSPECT" = "ImmoDemandeVisite"."ID_CLIENT"
                INNER JOIN "ImmoProprietes" ON "ImmoProprietes"."ID_PROPRIETES" = "ImmoDemandeVisite"."ID_PROPRIETES"
                INNER JOIN "ImmoCategories" ON "ImmoCategories"."ID_CATEGORIES" = "ImmoProprietes"."ID_CATEGORIES"
                INNER JOIN "ImmoTypePropriete" ON "ImmoTypePropriete"."ID_TYPE_PROPRIETE" = "ImmoProprietes"."ID_TYPE_PROPRIETE"
            WHERE
                "ImmoDemandeVisite"."STATUT" != '.Help::$INACTIF.'
                AND "ImmoDemandeVisite"."ID_DEMANDE_VISIT" = '.$id.'
                AND "ImmoDemandeVisite"."ID_ENTREPRISE" = '.$idEntreprise.'
            LIMIT 1
        ');
        return $demande;
    }

    public static function dataDesact(int $idDemande): bool{
        $data = DemandeVisite::find($idDemande);
        if (isset($data->ID_DEMANDE_VISIT)){
            $data->DATEMAJ = Help::dhSys();
            $data->STATUT = Help::$INACTIF;
        }
        return $data->save();
    }

}
