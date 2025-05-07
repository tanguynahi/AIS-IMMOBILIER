<?php

namespace App\Models;

use Help;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class APropos extends Model
{
    protected $table = "ImmoAPropos";
    protected $primaryKey = "ID_APROPOS";
    public $timestamps = false;

    protected $fillable = [
        "ID_APROPOS" ,
        "TITRE_INFO",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "ID_ENTREPRISE",
        "CONTENU_INFO",
        "PATH_APROPOS",
    ];
    use HasFactory;

    public static function dataListe($id) {
       return APropos::orderBy('TITRE_INFO')
       ->where('STATUT', Help::$ACTIF)
       ->where('ID_ENTREPRISE', $id)->get();
    }

    public static function dataDesact(int $id): bool{
        $data = APropos::find($id);
        if (isset($data->ID_APROPOS)){
            $data->DATEMAJ = Help::dhSys();
            ($data->STATUT == 1)? $data->STATUT = Help::$INACTIF: $data->STATUT = Help::$ACTIF;
        }
        return $data->save();
    }

    public static function LireSurID($id): APropos {
        $apropos = APropos::where('ID_APROPOS', $id)
        ->first();
        if(!empty($apropos->ID_APROPOS)) return $apropos;
        else return new APropos();
    }

}
