<?php

namespace App\Models;

use Help;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Personnels extends Model {
    
    protected $table = "ImmoPersonnels";
    protected $primaryKey = "ID_PERSONNELS";
    public $timestamps = false;

    protected $fillable = [
        "ID_PERSONNELS" ,
        "NOM_PERS",
        "PRENOMS_PERS",
        "CONTACT",
        "ADR_EMAIL",
        "URL_FBK",
        "URL_TWT",
        "ID_FONCTION_PERS",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "ID_ENTREPRISE",
        "PATH_PERS",
        "LIB_FONCTION",
    ];
    use HasFactory;

    public static function dataListe($idEntreprise) {
        return Personnels::selectRaw('"ImmoPersonnels".*, "FonctionPersonne"."LIB_FONCTION" as "LIB_FONCTION"')
        ->join('FonctionPersonne', 'FonctionPersonne.ID_FONCTION_PERS', '=', 'ImmoPersonnels.ID_FONCTION_PERS')
        ->where('ImmoPersonnels.ID_PERSONNELS', '!=', 1)
        ->where('ImmoPersonnels.STATUT', Help::$ACTIF)
        ->where('ImmoPersonnels.ID_ENTREPRISE', $idEntreprise)->get();
    }

    public static function liste($idEntreprise) {
        return Personnels::selectRaw('
        "ImmoPersonnels"."ID_PERSONNELS" as "ID_PERSONNELS",
        concat("ImmoPersonnels"."NOM_PERS",\' \',"ImmoPersonnels"."PRENOMS_PERS",\' (\',"FonctionPersonne"."LIB_FONCTION",\')\') as "LIB_PERS"')
        ->join('FonctionPersonne', 'FonctionPersonne.ID_FONCTION_PERS', '=', 'ImmoPersonnels.ID_FONCTION_PERS')
        ->where('ImmoPersonnels.ID_PERSONNELS', '!=', 1)
        ->where('ImmoPersonnels.STATUT', Help::$ACTIF)
        ->where('ImmoPersonnels.ID_ENTREPRISE', $idEntreprise)->get();
    }

    public static function LireSurID($id): Personnels{
        $personnel = Personnels::where('ID_PERSONNELS', $id)->first();
        if(!empty($personnel->ID_PERSONNELS)) return $personnel;
        else return new Personnels();
    }

    public static function dataDesact(int $id): bool{
        $data = Personnels::find($id);
        if (isset($data->ID_PERSONNELS)){
            $data->DATEMAJ = Help::dhSys();
            ($data->STATUT == 1)? $data->STATUT = Help::$INACTIF: $data->STATUT = Help::$ACTIF;
        }
        return $data->save();
    }

}
