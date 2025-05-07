<?php

namespace App\Models;

use Help;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categories extends Model {

    protected $table = "ImmoCategories";
    protected $primaryKey = "ID_CATEGORIES";
    public $timestamps = false;

    protected $fillable = [
        "ID_CATEGORIES" ,
        "LIB_CATEGORIE",
        "ID_TYPE",
        "LIB_TYPE",
        "DESCRIPTION_CATEGORIE",
        "ICONS_CATEGORIE",
        "PATH_CATEGORIE",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "ID_ENTREPRISE",
    ];
    use HasFactory;

    public static function ListeIndex() {
        return Categories::orderBy('ID_CATEGORIES', 'desc')
        ->whereRaw('
        "ImmoCategories"."ID_CATEGORIES" IN
        (
        SELECT "ImmoProprietes"."ID_CATEGORIES"
        FROM "ImmoProprietes" INNER JOIN "ImmoCategories"
        ON "ImmoProprietes"."ID_CATEGORIES" = "ImmoCategories"."ID_CATEGORIES"
        WHERE "ImmoProprietes"."STATUT" = ? AND "ImmoCategories"."STATUT" = ?
        )', [Help::$ACTIF, Help::$ACTIF])
        ->where('ImmoCategories.STATUT', Help::$ACTIF)->get();
    }
    
    public static function dataListe($id) {
        return Categories::selectRaw('
        "ImmoCategories"."ID_CATEGORIES" as "ID_CATEGORIES",
        "ImmoCategories"."LIB_CATEGORIE" as "LIB_CATEGORIE",
        "ImmoCategories"."ID_TYPE" as "ID_TYPE",
        "TypeOffres"."LIB_TYPE" as "LIB_TYPE",
        "ImmoCategories"."DESCRIPTION_CATEGORIE" as "DESCRIPTION_CATEGORIE",
        "ImmoCategories"."ICONS_CATEGORIE" as "ICONS_CATEGORIE",
        "ImmoCategories"."PATH_CATEGORIE" as "PATH_CATEGORIE",
        "ImmoCategories"."STATUT" as "STATUT",
        "ImmoCategories"."DATECREA" as "DATECREA",
        "ImmoCategories"."DATEMAJ" as "DATEMAJ",
        "ImmoCategories"."ID_ENTREPRISE" as "ID_ENTREPRISE"
       ')
       ->join('TypeOffres', 'TypeOffres.ID_TYPE', '=', 'ImmoCategories.ID_TYPE')
       ->orderBy('LIB_CATEGORIE')
       ->where('ImmoCategories.ID_ENTREPRISE', $id)
       ->where('ImmoCategories.STATUT', Help::$ACTIF)->get();
    }

    public static function LireSurID($id) {
        $data = Categories::where('ID_CATEGORIES', $id)
        ->first();
        if (!empty($data->ID_CATEGORIES)) return $data;
        else return new Categories;
    }

    public static function libelleSurID(int $id) {
        $data = Categories::find($id);
        if (isset($data->ID_CATEGORIES) && $data->ID_CATEGORIES>0) {
            return strtoupper($data->LIB_CATEGORIE);
        }else{ return new Categories; }
    }

    public static function dataDesact(int $id): bool{
        $data = Categories::find($id);
        if (isset($data->ID_CATEGORIES)){
            $data->DATEMAJ = Help::dySys();
            ($data->STATUT == 1)? $data->STATUT = Help::$INACTIF: $data->STATUT = Help::$ACTIF;
        }
        return $data->save();
    }
    
}
