<?php

namespace App\Models;

use Help;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\ProprietesAffaire;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Affaires extends Model
{
    protected $table = "ImmoAffaires";
    protected $primaryKey = "ID_AFFAIRES";
    public $timestamps = false;

    protected $fillable = [
        "ID_AFFAIRES",
        "ID_CLIENT",
        "ID_PROPRIETES",
        "LIB_PROPRIETE",
        "ID_TYPE_PROPRIETE",
        "LIB_TYPE",
        "ID_CATEGORIES",
        "LIB_CATEGORIE",
        "ADRESSE",
        "IMG_DEFAULT",
        "MONTANT",
        "TOTAL_A_PAYER",
        "DATE_CONCLUS",
        "DESCRIPTIF",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "ID_UTILISATEUR",
        "ID_ENTREPRISE",
        "LIB_CLIENT",
        "NOM",
        "PRENOMS",
        "CONTACT",
        "ADRESSE_CLI",
    ];
    use HasFactory;

    public static function NbAffaireClient($idclient){
        return Affaires::where('ID_CLIENT', $idclient)
        ->where('STATUT', Help::$ACTIF)->count();
    }
    public static function NbAffaire($id) {
        return Affaires::where('ID_ENTREPRISE', $id)->count();
    }
    public static function dataListe($idEntreprise) {
        $data = DB::select('
            SELECT
                "ImmoAffaires".*,
                concat("ImmoClient"."NOM",\' \',"ImmoClient"."PRENOMS") as "LIB_CLIENT"
            FROM
                "ImmoAffaires" INNER JOIN "ImmoClient"
                ON "ImmoClient"."ID_CLIENT" = "ImmoAffaires"."ID_CLIENT"
            WHERE
                "ImmoAffaires"."STATUT" = '.Help::$ACTIF.'
                AND "ImmoAffaires"."ID_ENTREPRISE" = '.$idEntreprise.'
        ');
        return $data;
    }

    public static function cliListaffaireClient($idClient) {
        $data = DB::select('
            SELECT
                "ImmoAffaires".*
            FROM
                "ImmoAffaires" INNER JOIN "ImmoClient"
                ON "ImmoClient"."ID_CLIENT" = "ImmoAffaires"."ID_CLIENT"
            WHERE
                "ImmoAffaires"."STATUT" = '.Help::$ACTIF.'
                AND "ImmoAffaires"."ID_CLIENT" = '.$idClient.'
        ');
        return $data;
    }

    public static function affaireSurClientID($idEntreprise, $idClient) {
        $data = DB::select('
            SELECT
                "ImmoAffaires".*
            FROM
                "ImmoAffaires" INNER JOIN "ImmoClient"
                ON "ImmoClient"."ID_CLIENT" = "ImmoAffaires"."ID_CLIENT"
            WHERE
                "ImmoAffaires"."STATUT" = '.Help::$ACTIF.'
                AND "ImmoAffaires"."ID_CLIENT" = '.$idClient.'
                AND "ImmoAffaires"."ID_ENTREPRISE" = '.$idEntreprise.'
        ');
        return $data;
    }

    public static function proprieteAcquisClient($idClient) {
        $data = DB::select('
            SELECT
                "ImmoAffaires".*
            FROM
                "ImmoAffaires" INNER JOIN "ImmoClient"
                ON "ImmoClient"."ID_CLIENT" = "ImmoAffaires"."ID_CLIENT"
            WHERE
                "ImmoAffaires"."STATUT" = '.Help::$ACTIF.'
                AND "ImmoAffaires"."ID_CLIENT" = '.$idClient.'
        ');
        return $data;
    }

    public static function affaireSurID($idEntreprise, $idAffaire) {
        $data = DB::select('
            SELECT
                "ImmoAffaires".*
            FROM
                "ImmoAffaires" INNER JOIN "ImmoClient"
                ON "ImmoClient"."ID_CLIENT" = "ImmoAffaires"."ID_CLIENT"
            WHERE
                "ImmoAffaires"."STATUT" = '.Help::$ACTIF.'
                AND "ImmoAffaires"."ID_AFFAIRES" = '.$idAffaire.'
                AND "ImmoAffaires"."ID_ENTREPRISE" = '.$idEntreprise.'
            LIMIT 1
        ');
        if (isset($data[0])) $data = $data[0];
        else $data = new Affaires();
        return $data;
    }

    public static function cliLireAffaireClient($idAffaire) {
        $data = DB::select('
            SELECT
                "ImmoAffaires".*,
                "ImmoClient"."NOM" as "NOM",
                "ImmoClient"."PRENOMS" as "PRENOMS",
                "ImmoClient"."CONTACT" as "CONTACT",
                "ImmoClient"."ADRESSE" as "ADRESSE_CLI"
            FROM
                "ImmoAffaires" INNER JOIN "ImmoClient"
                ON "ImmoClient"."ID_CLIENT" = "ImmoAffaires"."ID_CLIENT"
            WHERE
                "ImmoAffaires"."STATUT" != '.Help::$INACTIF.'
                AND "ImmoAffaires"."ID_AFFAIRES" = '.$idAffaire.'
            LIMIT 1
        ');
        if (isset($data[0])) $data = $data[0];
        else $data = new Affaires();
        return $data;
    }

    public static function lireAffaireClientSurID($idEntreprise, $idAffaire) {
        $data = DB::select('
            SELECT
                "ImmoAffaires".*,
                "ImmoClient"."NOM" as "NOM",
                "ImmoClient"."PRENOMS" as "PRENOMS",
                "ImmoClient"."CONTACT" as "CONTACT",
                "ImmoClient"."ADRESSE" as "ADRESSE_CLI"
            FROM
                "ImmoAffaires" INNER JOIN "ImmoClient"
                ON "ImmoClient"."ID_CLIENT" = "ImmoAffaires"."ID_CLIENT"
            WHERE
                "ImmoAffaires"."STATUT" != '.Help::$INACTIF.'
                AND "ImmoAffaires"."ID_AFFAIRES" = '.$idAffaire.'
                AND "ImmoAffaires"."ID_ENTREPRISE" = '.$idEntreprise.'
            LIMIT 1
        ');
        if (isset($data[0])) $data = $data[0];
        else $data = new Affaires();
        return $data;
    }

    public static function ProprietesAcquisClient($idAffaire, $idProprietes, $idEntreprise) {
        return Affaires::selectRaw('"ImmoAffaires".*')
        ->join('ImmoClient', 'ImmoClient.ID_CLIENT', '=', 'ImmoAffaires.ID_CLIENT')
        ->join('ImmoProprietesAffaire', 'ImmoProprietesAffaire.ID_AFFAIRES', '=', 'ImmoAffaires.ID_AFFAIRES')
        ->where('ImmoAffaires.ID_AFFAIRES', $idAffaire)->where('ImmoProprietesAffaire.ID_PROPRIETES_AFF', $idProprietes)
        ->where('ImmoAffaires.ID_ENTREPRISE', $idEntreprise)->first();
    }

    public static function LireSurID(int $id){
        $data = Affaires::find($id);
        if (isset($data->ID_AFFAIRES))return $data;
        else new Affaires;
    }

    public static function dataSave(Request $request, Affaires $obj, Proprietes $data): Affaires{
        if($request->id > 0){
            $obj = self::LireSurID($request->id);
            if(!isset($obj->ID_AFFAIRES)) return new Affaires();
            else $obj->DATEMAJ = Help::dhSys();
        }else{
            $obj->STATUT = Help::$ACTIF;
            $obj->DATECREA = Help::dhSys();
        }
        $obj->LIB_PROPRIETE = $data->LIB_PROPRIETE;
        $obj->ID_TYPE_PROPRIETE = $data->ID_TYPE_PROPRIETE;
        $obj->LIB_TYPE = TypePropriete::libelleSurID($obj->ID_TYPE_PROPRIETE);
        $obj->ID_CATEGORIES = $data->ID_CATEGORIES;
        $obj->LIB_CATEGORIE = Categories::libelleSurID($obj->ID_CATEGORIES);
        $obj->ADRESSE = $data->ADRESSE;
        $obj->IMG_DEFAULT = $data->IMG_DEFAULT;
        $obj->ID_CLIENT = $request->Client;
        $obj->ID_PROPRIETES = $request->Propriete;
        $obj->MONTANT = $request->Montant;
        $obj->DESCRIPTIF = $request->Descrip;
        $obj->TOTAL_A_PAYER = $request->Total;
        $obj->DATE_CONCLUS = $request->Date;
        if($obj->save()){
            $property = ProprietesAffaire::LireSurID($obj->ID_AFFAIRES , $obj->ID_PROPRIETES);
            if(isset($property->ID_PROPRIETES_AFF) && $property->ID_PROPRIETES_AFF>0){
                $property->DATEMAJ = Help::dhSys();
            }else{
                $property->STATUT = Help::$ACTIF;
                $property->DATECREA = Help::dhSys();
                $property->ID_AFFAIRES = $obj->ID_AFFAIRES;
                $property->ID_PROPRIETES = $obj->ID_PROPRIETES;
                $property->ID_ENTREPRISE = $obj->ID_ENTREPRISE;
            }
            $property->LIB_PROPRIETE = $data->LIB_PROPRIETE;
            $property->ID_CATEGORIES = $data->ID_CATEGORIES;
            $property->LIB_CATEGORIE = Categories::libelleSurID($data->ID_CATEGORIES);
            $property->ID_TYPE_PROPRIETE = $data->ID_TYPE_PROPRIETE;
            $property->LIB_TYPE_PROP = TypePropriete::libelleSurID($data->ID_TYPE_PROPRIETE);
            $property->ADRESSE = $data->ADRESSE;
            $property->LONGITUDE = $data->LONGITUDE;
            $property->LATITUDE = $data->LATITUDE;
            $property->ID_PAYS = $data->ID_PAYS;
            $property->ID_VILLE = $data->ID_VILLE;
            $property->SUPERFICIE = $data->SUPERFICIE;
            $property->NB_CHAMBRES = $data->NB_CHAMBRES;
            $property->NB_PIECES = $data->NB_PIECES;
            $property->NB_SALLE_DE_BAIN = $data->NB_SALLE_DE_BAIN;
            $property->ANNEE_CONST = $data->ANNEE_CONST;
            $property->NB_GARAGE = $data->NB_GARAGE;
            $property->WIFI = $data->WIFI;
            $property->PISCINE = $data->PISCINE;
            $property->CUSINE_EQUIPE = $data->CUSINE_EQUIPE;
            $property->CLIMATISATION = $data->CLIMATISATION;
            $property->PARKING = $data->PARKING;
            $property->SECURITE = $data->SECURITE;
            $property->SALLE_DE_SPORT = $data->SALLE_DE_SPORT;
            $property->PRIX_HT = $data->PRIX_HT;
            $property->DESCRIPTIF = $data->DESCRIPTIF;
            $property->EST_NOUVEAU = $data->EST_NOUVEAU;
            $source = public_path() . $data->IMG_DEFAULT;
            if (file_exists($source)) {
                $file = $data->IMG_DEFAULT;
                $fileName = str_replace('/PhotoPropriete/', '', $file);
                $destination = public_path().'/PhotoProprieteAffaire/'. $fileName;
                copy($source, $destination);
                $obj->IMG_DEFAULT = '/PhotoProprieteAffaire/'. $fileName;
                $property->IMG_DEFAULT = $obj->IMG_DEFAULT;
            }
            $obj->save();
            $property->save();
            return $obj;
        }else{ return new Affaires(); }
    }

    public static function dataDesact(int $id): bool{
        $data = Affaires::find($id);
        if (isset($data->ID_AFFAIRES)){
            $data->DATEMAJ = Help::dhSys();
            ($data->STATUT == 1)? $data->STATUT = Help::$INACTIF: $data->STATUT = Help::$ACTIF;
        }
        return $data->save();
    }
}
