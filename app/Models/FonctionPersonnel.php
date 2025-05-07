<?php

namespace App\Models;

use Help;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FonctionPersonnel extends Model {

    protected $table = "FonctionPersonne";
    protected $primaryKey = "ID_FONCTION_PERS";
    public $timestamps = false;

    protected $fillable = [
        "ID_FONCTION_PERS" ,
        "LIB_FONCTION",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "ID_ENTREPRISE",
    ];
    use HasFactory;

    public static function dataListe($id) {
       return FonctionPersonnel::orderBy('LIB_FONCTION')
       ->where('ID_ENTREPRISE', $id)
       ->where('STATUT', Help::$ACTIF)->get();
    }

    public static function dataDesact(int $id): bool{
        $data = FonctionPersonnel::find($id);
        if (isset($data->ID_FONCTION_PERS)){
            $data->DATEMAJ = Help::dhSys();
            ($data->STATUT == 1)? $data->STATUT = Help::$INACTIF: $data->STATUT = Help::$ACTIF;
        }
        return $data->save();
    }
}
