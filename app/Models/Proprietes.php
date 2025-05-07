<?php

namespace App\Models;

use Help;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proprietes extends Model {
    
    protected $table = "ImmoProprietes";
    protected $primaryKey = "ID_PROPRIETES";
    public $timestamps = false;

    protected $fillable = [
        "ID_PROPRIETES" ,
        "LIB_PROPRIETE",
        "ID_TYPE_PROPRIETE",
        "PRIX_HT",
        "ID_CATEGORIES",
        "SUPERFICIE",
        "NB_PIECES",
        "IMG_DEFAULT",
        "EST_NOUVEAU",
        "EN_PROMOTION",
        "POURCENT_PROMO",
        "LONGITUDE",
        "LATITUDE",
        "ID_PAYS",
        "ID_VILLE",
        "ADRESSE",
        "DESCRIPTIF",
        "ANNEE_CONST",
        "NB_CHAMBRES",
        "NB_SALLE_DE_BAIN",
        "NB_GARAGE",
        "WIFI",
        "PISCINE",
        "CUSINE_EQUIPE",
        "CLIMATISATION",
        "PARKING",
        "SECURITE",
        "SALLE_DE_SPORT",
        "URL_VIDEO",
        "URL_VIMEO",
        "CALCUL_HYPOTHEQUE",
        "GOOGLE_MAP",
        "FORM_CONTACT",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "ID_ENTREPRISE",
        "ANNEE",
        "LIB_TYPE",
        "PRIX_PROMO",
        "LIB_CATEGORIE",
        "ID_TYPE"
    ];
    use HasFactory;

    public static function NbPropriete($id) {
        return Proprietes::where('ID_ENTREPRISE', $id)
        ->where('ImmoProprietes.STATUT', Help::$ACTIF)
        ->count();
    }

    public static function dataListe($idEntreprise){
        return Proprietes::selectRaw('
            "ImmoProprietes".*,
            "ImmoCategories"."ID_TYPE" AS "ID_TYPE",
            "ImmoCategories"."LIB_CATEGORIE" as "LIB_CATEGORIE",
            "AnneeConstruction"."LIB_ANNEE_CONST" as "ANNEE",
            "ImmoTypePropriete"."LIB_TYPE" as "LIB_TYPE"
        ')
        ->join('ImmoCategories', 'ImmoCategories.ID_CATEGORIES', '=', 'ImmoProprietes.ID_CATEGORIES')
        ->join('ImmoTypePropriete', 'ImmoTypePropriete.ID_TYPE_PROPRIETE', '=', 'ImmoProprietes.ID_TYPE_PROPRIETE')
        ->leftJoin('AnneeConstruction', 'AnneeConstruction.ANNEE_CONST_ID', '=', 'ImmoProprietes.ANNEE_CONST')
        ->where('ImmoProprietes.STATUT', Help::$ACTIF)
        ->where('ImmoProprietes.ID_ENTREPRISE', $idEntreprise)->orderBy('ID_TYPE_PROPRIETE')->get();
    }

    public static function proprietesTous($idEntreprise){
        return Proprietes::selectRaw('
            "ImmoProprietes".*,
            "ImmoCategories"."ID_TYPE" AS "ID_TYPE",
            "ImmoCategories"."LIB_CATEGORIE" as "LIB_CATEGORIE",
            "AnneeConstruction"."LIB_ANNEE_CONST" as "ANNEE",
            "ImmoTypePropriete"."LIB_TYPE" as "LIB_TYPE"
        ')
        ->join('ImmoCategories', 'ImmoCategories.ID_CATEGORIES', '=', 'ImmoProprietes.ID_CATEGORIES')
        ->join('ImmoTypePropriete', 'ImmoTypePropriete.ID_TYPE_PROPRIETE', '=', 'ImmoProprietes.ID_TYPE_PROPRIETE')
        ->leftJoin('AnneeConstruction', 'AnneeConstruction.ANNEE_CONST_ID', '=', 'ImmoProprietes.ANNEE_CONST')
        ->where('ImmoProprietes.ID_ENTREPRISE', $idEntreprise)->get();
    }

    public static function LireSurID($idProprietes){
        $propriete = Proprietes::selectRaw('
            "ImmoProprietes".*,
            "ImmoCategories"."ID_TYPE" AS "ID_TYPE",
            "ImmoCategories"."LIB_CATEGORIE" as "LIB_CATEGORIE",
            "AnneeConstruction"."LIB_ANNEE_CONST" AS "ANNEE",
            "ImmoTypePropriete"."LIB_TYPE" AS "LIB_TYPE"
        ')
        ->join('ImmoCategories', 'ImmoCategories.ID_CATEGORIES', '=', 'ImmoProprietes.ID_CATEGORIES')
        ->join('ImmoTypePropriete', 'ImmoTypePropriete.ID_TYPE_PROPRIETE', '=', 'ImmoProprietes.ID_TYPE_PROPRIETE')
        ->leftJoin('AnneeConstruction', 'AnneeConstruction.ANNEE_CONST_ID', '=', 'ImmoProprietes.ANNEE_CONST')
        ->where('ImmoProprietes.ID_PROPRIETES', $idProprietes)->first();
        if(isset($propriete->ID_PROPRIETES)) return $propriete;
        else return new Proprietes();
    }

    public static function VerifiIdentifiantProprietes( int $idEntrep, String $libel, String $adress, int $idtype, int $idcateg){
        $propriete = Proprietes::where('LIB_PROPRIETE', $libel)
        ->where('ADRESSE', $adress)
        ->where('ID_TYPE_PROPRIETE', $idtype)
        ->where('ID_CATEGORIES', $idcateg)
        ->where('ID_ENTREPRISE', $idEntrep)->first();
        if(isset($propriete->ID_PROPRIETES)) return $propriete;
        else return new Proprietes();
    }

    public static function dataSave(Request $request, Proprietes $obj): Proprietes{

        if($request->IDProprietes > 0){
            $obj = self::LireSurID($request->IDProprietes);
            if(!isset($obj->ID_PROPRIETES)) return new Proprietes();
            else $obj->DATEMAJ = Help::dhSys();
        }else{
            $obj->IMG_DEFAULT = '';
            $obj->STATUT = Help::$ACTIF;
            $obj->DATECREA = Help::dhSys();
        }

        $obj->LIB_PROPRIETE = $request->LibellePropriete;
        $obj->ID_CATEGORIES = $request->IDCategories;
        $obj->ID_TYPE_PROPRIETE = $request->TypePropriete;

        $obj->ADRESSE = $request->Adresse;
        $obj->LONGITUDE = $request->long;
        $obj->LATITUDE = $request->lat;
        $obj->ID_PAYS = $request->IDPays;
        $obj->ID_VILLE = $request->IDVille;
        $obj->SUPERFICIE = $request->Superficie;
        $obj->NB_CHAMBRES = $request->NbChambres;
        $obj->NB_PIECES = $request->NbPieces;
        $obj->NB_SALLE_DE_BAIN = $request->NbSalleDeBain;
        $obj->ANNEE_CONST = $request->AnneeConst;
        $obj->NB_GARAGE = $request->NbGarages;
        $obj->WIFI = $request->Wifi;
        $obj->PISCINE = $request->Piscine;
        $obj->CUSINE_EQUIPE = $request->Cusine;
        $obj->CLIMATISATION = $request->Climatise;
        $obj->PARKING = $request->Parking;
        $obj->SECURITE = $request->Securite;
        $obj->SALLE_DE_SPORT = $request->SalleDeSport;
        $obj->PRIX_HT = $request->PrixHT;
        $obj->DESCRIPTIF = $request->Descriptif;

        $obj->EST_NOUVEAU = $request->bNouveaute;
        $obj->EN_PROMOTION = $request->bEnPromotion;

        $obj->POURCENT_PROMO = $request->Pourcentage;
        $obj->URL_VIDEO = $request->UrlVideo;
        $obj->URL_VIMEO = $request->UrlVimeo;
        $obj->CALCUL_HYPOTHEQUE = $request->CalcHypoth;
        $obj->GOOGLE_MAP = $request->GoogleMap;

        if($obj->save()) return $obj;
        else return new Proprietes();
    }

    public static function dataDesact(int $idProprietes): bool{
        $data = Proprietes::find($idProprietes);
        if (isset($data->ID_PROPRIETES)){
            $data->DATEMAJ = Help::dhSys();
            ($data->STATUT == 1)? $data->STATUT = Help::$INACTIF: $data->STATUT = Help::$ACTIF;
        }
        return $data->save();
    }

    public static function proprietesIndex($idEntreprise){
        $data = DB::select('
            SELECT
                "ImmoProprietes".*,
                "ImmoCategories"."ID_TYPE" AS "ID_TYPE",
                "ImmoCategories"."LIB_CATEGORIE" AS "LIB_CATEGORIE",
                "AnneeConstruction"."LIB_ANNEE_CONST" AS "ANNEE",
                "ImmoTypePropriete"."LIB_TYPE" AS "LIB_TYPE",
                CASE "ImmoProprietes"."EN_PROMOTION"
                WHEN true THEN ("ImmoProprietes"."PRIX_HT" - ("ImmoProprietes"."PRIX_HT" * ("ImmoProprietes"."POURCENT_PROMO"/100)))
                ELSE 0
                END AS "PRIX_PROMO"
            FROM
                "ImmoProprietes" INNER JOIN "ImmoCategories" ON "ImmoCategories"."ID_CATEGORIES" = "ImmoProprietes"."ID_CATEGORIES"
                INNER JOIN "ImmoTypePropriete" ON "ImmoTypePropriete"."ID_TYPE_PROPRIETE" = "ImmoProprietes"."ID_TYPE_PROPRIETE"
                LEFT JOIN "AnneeConstruction" ON "AnneeConstruction"."ANNEE_CONST_ID" = "ImmoProprietes"."ANNEE_CONST"
            WHERE
                "ImmoProprietes"."STATUT" = '.Help::$ACTIF.'
                AND "ImmoProprietes"."ID_ENTREPRISE" = '.$idEntreprise.'
            ORDER BY RANDOM() LIMIT 12
        ');
        return $data;
    }

    public static function proprietesFeatured($idEntreprise){
        $data = DB::select('
            SELECT
                *
            FROM
            (
                SELECT
                    COUNT("ImmoProprietes"."ID_PROPRIETES") AS "Nb",
                    "ImmoCategories"."ID_CATEGORIES" AS "ID_CATEGORIES",
                    "ImmoCategories"."LIB_CATEGORIE" AS "LIB_CATEGORIE",
                    "ImmoCategories"."PATH_CATEGORIE" AS "PATH_CATEGORIE"
                FROM
                    "ImmoProprietes" INNER JOIN "ImmoCategories"
                    ON "ImmoCategories"."ID_CATEGORIES" = "ImmoProprietes"."ID_CATEGORIES"
                WHERE
                    "ImmoProprietes"."ID_ENTREPRISE" = '. $idEntreprise .'
                    AND "ImmoCategories"."ID_ENTREPRISE" = '. $idEntreprise .'
                    AND "ImmoProprietes"."STATUT" = '.Help::$ACTIF.'
                    AND "ImmoCategories"."STATUT" = '.Help::$ACTIF.'
                GROUP BY
                    "ImmoCategories"."ID_CATEGORIES",
                    "ImmoCategories"."LIB_CATEGORIE",
                    "ImmoCategories"."PATH_CATEGORIE"
            ) AS t
            ORDER BY t."ID_CATEGORIES"
        ');
        return $data;
    }

    public static function nbPropretiesByType($idEntreprise){
        $data = DB::select('
            SELECT
                *
            FROM
            (
                SELECT
                    COUNT("ImmoProprietes"."ID_PROPRIETES") AS "Nb",
                    "ImmoTypePropriete"."LIB_TYPE" AS "LIB_TYPE"
                FROM
                    "ImmoProprietes" INNER JOIN "ImmoTypePropriete"
                    ON "ImmoTypePropriete"."ID_TYPE_PROPRIETE" = "ImmoProprietes"."ID_TYPE_PROPRIETE"
                WHERE
                    "ImmoProprietes"."ID_ENTREPRISE" = '. $idEntreprise .'
                    AND "ImmoProprietes"."STATUT" = '.Help::$ACTIF.'
                    AND "ImmoTypePropriete"."STATUT" = '.Help::$ACTIF.'
                GROUP BY
                    "ImmoTypePropriete"."LIB_TYPE"
            ) AS t
            ORDER BY t."LIB_TYPE"
        ');
        return $data;
    }

    public static function proprietesDetail($idPropriete){
        $data = DB::select('
            SELECT
                "ImmoProprietes".*,
                "ImmoCategories"."ID_TYPE" AS "ID_TYPE",
                "ImmoCategories"."LIB_CATEGORIE" AS "LIB_CATEGORIE",
                "AnneeConstruction"."LIB_ANNEE_CONST" AS "ANNEE",
                "ImmoTypePropriete"."LIB_TYPE" AS "LIB_TYPE",
                CASE "ImmoProprietes"."EN_PROMOTION"
                WHEN true THEN ("ImmoProprietes"."PRIX_HT" - ("ImmoProprietes"."PRIX_HT" * ("ImmoProprietes"."POURCENT_PROMO"/100)))
                ELSE 0
                END AS "PRIX_PROMO"
            FROM
                "ImmoProprietes" INNER JOIN "ImmoCategories" ON "ImmoCategories"."ID_CATEGORIES" = "ImmoProprietes"."ID_CATEGORIES"
                INNER JOIN "ImmoTypePropriete" ON "ImmoTypePropriete"."ID_TYPE_PROPRIETE" = "ImmoProprietes"."ID_TYPE_PROPRIETE"
                LEFT JOIN "AnneeConstruction" ON "AnneeConstruction"."ANNEE_CONST_ID" = "ImmoProprietes"."ANNEE_CONST"
            WHERE
                "ImmoProprietes"."STATUT" = '.Help::$ACTIF.'
                AND "ImmoProprietes"."ID_PROPRIETES" = '.$idPropriete.'
            LIMIT 1
        ');
        if (isset($data[0])) return $data[0];
        else return new Proprietes;
    }

    public static function proprieteSimilar($idCategorie){
        $data = DB::select('
            SELECT
                "ImmoProprietes".*,
                "ImmoCategories"."ID_TYPE" AS "ID_TYPE",
                "ImmoCategories"."LIB_CATEGORIE" AS "LIB_CATEGORIE",
                "AnneeConstruction"."LIB_ANNEE_CONST" AS "ANNEE",
                "ImmoTypePropriete"."LIB_TYPE" AS "LIB_TYPE",
                CASE "ImmoProprietes"."EN_PROMOTION"
                WHEN true THEN ("ImmoProprietes"."PRIX_HT" - ("ImmoProprietes"."PRIX_HT" * ("ImmoProprietes"."POURCENT_PROMO"/100)))
                ELSE 0
                END AS "PRIX_PROMO"
            FROM
                "ImmoProprietes" INNER JOIN "ImmoCategories" ON "ImmoCategories"."ID_CATEGORIES" = "ImmoProprietes"."ID_CATEGORIES"
                INNER JOIN "ImmoTypePropriete" ON "ImmoTypePropriete"."ID_TYPE_PROPRIETE" = "ImmoProprietes"."ID_TYPE_PROPRIETE"
                LEFT JOIN "AnneeConstruction" ON "AnneeConstruction"."ANNEE_CONST_ID" = "ImmoProprietes"."ANNEE_CONST"
            WHERE
                "ImmoProprietes"."STATUT" = '.Help::$ACTIF.'
                AND "ImmoProprietes"."ID_CATEGORIES" = '.$idCategorie.'
            ORDER BY RANDOM() LIMIT 3
        ');
        return $data;
    }

    public static function proprieteRecent($idPropriete){
        $data = DB::select('
            SELECT
                "ImmoProprietes".*,
                "ImmoCategories"."ID_TYPE" AS "ID_TYPE",
                "ImmoCategories"."LIB_CATEGORIE" AS "LIB_CATEGORIE",
                "AnneeConstruction"."LIB_ANNEE_CONST" AS "ANNEE",
                "ImmoTypePropriete"."LIB_TYPE" AS "LIB_TYPE",
                CASE "ImmoProprietes"."EN_PROMOTION"
                WHEN true THEN ("ImmoProprietes"."PRIX_HT" - ("ImmoProprietes"."PRIX_HT" * ("ImmoProprietes"."POURCENT_PROMO"/100)))
                ELSE 0
                END AS "PRIX_PROMO"
            FROM
                "ImmoProprietes" INNER JOIN "ImmoCategories" ON "ImmoCategories"."ID_CATEGORIES" = "ImmoProprietes"."ID_CATEGORIES"
                INNER JOIN "ImmoTypePropriete" ON "ImmoTypePropriete"."ID_TYPE_PROPRIETE" = "ImmoProprietes"."ID_TYPE_PROPRIETE"
                LEFT JOIN "AnneeConstruction" ON "AnneeConstruction"."ANNEE_CONST_ID" = "ImmoProprietes"."ANNEE_CONST"
            WHERE
                "ImmoProprietes"."STATUT" = '.Help::$ACTIF.'
                AND "ImmoProprietes"."ID_PROPRIETES" != '.$idPropriete.'
            ORDER BY RANDOM() LIMIT 3
        ');
        return $data;
    }

    public static function proprieteSearching($idEntreprise, Request $request){
        $str  = '
            SELECT
                "ImmoProprietes".*,
                "ImmoCategories"."ID_TYPE" AS "ID_TYPE",
                "ImmoCategories"."LIB_CATEGORIE" AS "LIB_CATEGORIE",
                "AnneeConstruction"."LIB_ANNEE_CONST" AS "ANNEE",
                "ImmoTypePropriete"."LIB_TYPE" AS "LIB_TYPE",
                CASE "ImmoProprietes"."EN_PROMOTION"
                WHEN true THEN ("ImmoProprietes"."PRIX_HT" - ("ImmoProprietes"."PRIX_HT" * ("ImmoProprietes"."POURCENT_PROMO"/100)))
                ELSE 0
                END AS "PRIX_PROMO"
            FROM
                "ImmoProprietes" INNER JOIN "ImmoCategories" ON "ImmoCategories"."ID_CATEGORIES" = "ImmoProprietes"."ID_CATEGORIES"
                INNER JOIN "ImmoTypePropriete" ON "ImmoTypePropriete"."ID_TYPE_PROPRIETE" = "ImmoProprietes"."ID_TYPE_PROPRIETE"
                LEFT JOIN "AnneeConstruction" ON "AnneeConstruction"."ANNEE_CONST_ID" = "ImmoProprietes"."ANNEE_CONST"
            WHERE
                "ImmoProprietes"."STATUT" = '.Help::$ACTIF.'
                AND "ImmoProprietes"."ID_ENTREPRISE" = '.$idEntreprise.'
        ';

        if (isset($request->all_status) && $request->all_status>0){
            $str .= ' AND "ImmoProprietes"."ID_TYPE_PROPRIETE" = '.$request->all_status;
        }
        if (isset($request->all_categories) && $request->all_categories>0){
            $str .= ' AND "ImmoProprietes"."ID_CATEGORIES" = '.$request->all_categories;
        }
        if (isset($request->city) && $request->city>0){
            $str .= ' AND "ImmoProprietes"."ID_VILLE" = '.$request->city;
        }
        if (isset($request->nb_pieces) && $request->nb_pieces>0){
            $str .= ' AND "ImmoProprietes"."NB_PIECES" = '.$request->nb_pieces;
        }
        if (isset($request->annee_const) && $request->annee_const>0){
            $str .= ' AND "ImmoProprietes"."ANNEE_CONST" = '.$request->annee_const;
        }


        if ((isset($request->min_area) && isset($request->max_area)) && ($request->min_area>0 && $request->max_area>0)){
            $str .= ' AND "ImmoProprietes"."SUPERFICIE" BETWEEN '.$request->min_area.' AND '.$request->max_area;
        }
        if ((isset($request->min_price) && isset($request->max_price)) && ($request->min_price>0 && $request->max_price>0)){
            $str .= ' AND "ImmoProprietes"."PRIX_HT" BETWEEN '.$request->min_price.' AND '.$request->max_price;
        }


        if (isset($request->wifi) && $request->wifi=='on'){
            $str .= ' AND "ImmoProprietes"."WIFI" = 1';
        }
        if (isset($request->piscine) && $request->piscine=='on'){
            $str .= ' AND "ImmoProprietes"."PISCINE" = 1';
        }
        if (isset($request->cuisine_equip) && $request->cuisine_equip=='on'){
            $str .= ' AND "ImmoProprietes"."CUSINE_EQUIPE" = 1';
        }
        if (isset($request->climatisation) && $request->climatisation=='on'){
            $str .= ' AND "ImmoProprietes"."CLIMATISATION" = 1';
        }
        if (isset($request->parking) && $request->parking=='on'){
            $str .= ' AND "ImmoProprietes"."PARKING" = 1';
        }
        if (isset($request->securite) && $request->securite=='on'){
            $str .= ' AND "ImmoProprietes"."SECURITE" = 1';
        }
        if (isset($request->salle_sport) && $request->salle_sport=='on'){
            $str .= ' AND "ImmoProprietes"."SALLE_DE_SPORT" = 1';
        }

        $data = DB::select($str);
        // $data = self::paginate($data, count($data), 4, null, ['path' => Request()->url(), 'query' => Request()->query()]);

        return $data;
    }

    public static function paginate($items, $total , $perPage = 5, $page = null, $options = []){
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage),  $total, $perPage, $page, $options);
    }

    public static function proprieteOnCategories($type, $idCategorie){
        $requete = '
            SELECT
                "ImmoProprietes".*,
                "ImmoCategories"."ID_TYPE" AS "ID_TYPE",
                "ImmoCategories"."LIB_CATEGORIE" AS "LIB_CATEGORIE",
                "AnneeConstruction"."LIB_ANNEE_CONST" AS "ANNEE",
                "ImmoTypePropriete"."LIB_TYPE" AS "LIB_TYPE",
                CASE "ImmoProprietes"."EN_PROMOTION"
                WHEN 1 THEN ("ImmoProprietes"."PRIX_HT" - ("ImmoProprietes"."PRIX_HT" * ("ImmoProprietes"."POURCENT_PROMO"/100)))
                ELSE 0
                END AS "PRIX_PROMO"
            FROM
                "ImmoProprietes" INNER JOIN "ImmoCategories" ON "ImmoCategories"."ID_CATEGORIES" = "ImmoProprietes"."ID_CATEGORIES"
                INNER JOIN "ImmoTypePropriete" ON "ImmoTypePropriete"."ID_TYPE_PROPRIETE" = "ImmoProprietes"."ID_TYPE_PROPRIETE"
                LEFT JOIN "AnneeConstruction" ON "AnneeConstruction"."ANNEE_CONST_ID" = "ImmoProprietes"."ANNEE_CONST"
            WHERE
                "ImmoProprietes"."STATUT" = '.Help::$ACTIF.'
                AND "ImmoCategories"."STATUT" = '.Help::$ACTIF.'
        ';
        if ($type>0) $requete .= ' AND "ImmoProprietes"."ID_TYPE_PROPRIETE" = '.$type;
        if ($idCategorie>0) $requete .= ' AND "ImmoProprietes"."ID_CATEGORIES" = '.$idCategorie;

        $data = DB::select($requete);
        return $data;
    }

    public static function libelleSurID(int $id) {
        $data = Proprietes::find($id);
        if (isset($data->ID_PROPRIETES) && $data->ID_PROPRIETES>0) {
            return strtoupper($data->LIB_PROPRIETE);
        }else{ return new Proprietes; }
    }
    
}
