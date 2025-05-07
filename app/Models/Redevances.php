<?php

namespace App\Models;

use Help;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Redevances extends Model
{
    protected $table = "ImmoRedevances";
    protected $primaryKey = "ID_REDEVANCES";
    public $timestamps = false;

    protected $fillable = [
        "ID_REDEVANCES",
        "LIB_REDEVANCES",
        "ID_TYPE_REDEVANCES",
        "ID_TYPE_PERIODE",
        "DESCRIPTIF",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "ID_ENTREPRISE",
        "ID_UTILISATEUR",
        "LIB_TYPE",
        "LIB_PERIODE",
    ];
    use HasFactory;

    public static function listeTypeMontant(){
        return [
            ['id'=>1, 'libelle'=>'Fixe'],
            ['id'=>2, 'libelle'=>'Variable'],
        ];
    }

    public static function dataListe($idEntreprise) {
        $data = DB::select('
            SELECT
                "ImmoRedevances".*,
                "TypePeriode"."LIB_PERIODE" AS "LIB_PERIODE",
                "ImmoTypePropriete"."LIB_TYPE" AS "LIB_TYPE"
            FROM
                "ImmoRedevances" INNER JOIN "TypePeriode" ON "TypePeriode"."ID_TYPE_PERIODE" = "ImmoRedevances"."ID_TYPE_PERIODE"
                INNER JOIN "ImmoTypePropriete" ON "ImmoTypePropriete"."ID_TYPE_PROPRIETE" = "ImmoRedevances"."ID_TYPE_REDEVANCES"
            WHERE
                "ImmoRedevances"."STATUT" = '.Help::$ACTIF.'
                AND "ImmoRedevances"."ID_ENTREPRISE" = '.$idEntreprise.'
        ');
        return $data;
    }

    public static function redevanceSurID($idEntreprise, $idRedevance) {
        $data = DB::select('
            SELECT
                "ImmoRedevances".*,
                "TypePeriode"."LIB_PERIODE" AS "LIB_PERIODE",
                "ImmoTypePropriete"."LIB_TYPE" AS "LIB_TYPE"
            FROM
                "ImmoRedevances" INNER JOIN "TypePeriode" ON "TypePeriode"."ID_TYPE_PERIODE" = "ImmoRedevances"."ID_TYPE_PERIODE"
                INNER JOIN "ImmoTypePropriete" ON "ImmoTypePropriete"."ID_TYPE_PROPRIETE" = "ImmoRedevances"."ID_TYPE_REDEVANCES"
            WHERE
                "ImmoRedevances"."STATUT" = '.Help::$ACTIF.'
                AND "ImmoRedevances"."ID_REDEVANCES" = '.$idRedevance.'
                AND "ImmoRedevances"."ID_ENTREPRISE" = '.$idEntreprise.'
            LIMIT 1
        ');
        if (isset($data[0])) {$data = $data[0];}
        return $data;
    }

    public static function LireSurID(int $idRedevances){
        $data = Redevances::find($idRedevances);
        if (isset($data->ID_REDEVANCES)) return $data;
        else new Redevances;
    }

    public static function dataSave(Request $request, Redevances $obj): Redevances{
        if($request->id > 0){
            $obj = self::LireSurID($request->id);
            if(!isset($obj->ID_REDEVANCES)) return new Redevances();
            else $obj->DATEMAJ = Help::dhSys();
        }else{
            $obj->STATUT = Help::$ACTIF;
            $obj->DATECREA = Help::dhSys();
        }
        $obj->LIB_REDEVANCES = $request->lib;
        $obj->ID_TYPE_REDEVANCES = $request->typ;
        $obj->ID_TYPE_PERIODE = $request->period;
        $obj->DESCRIPTIF = $request->desc;
        if($obj->save()) return $obj;
        else return new Redevances();
    }

    public static function dataDesact(int $idRedevance): bool{
        $data = Redevances::find($idRedevance);
        if (isset($data->ID_REDEVANCES)){
            $data->DATEMAJ = Help::dhSys();
            ($data->STATUT == 1)? $data->STATUT = Help::$INACTIF: $data->STATUT = Help::$ACTIF;
        }
        return $data->save();
    }

    public static function libelleSurID($id) {
        $data = Redevances::find($id);
        if (isset($data->ID_REDEVANCES) && $data->ID_REDEVANCES>0) {
            return $data->LIB_REDEVANCES;
        }else{ return 'xxxxxxxxxx'; }
    }
}
