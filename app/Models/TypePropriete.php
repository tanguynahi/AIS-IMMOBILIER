<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypePropriete extends Model
{
    protected $table = "ImmoTypePropriete";
    protected $primaryKey = "ID_TYPE_PROPRIETE";
    public $timestamps = false;

    protected $fillable = [
        "ID_TYPE_PROPRIETE" ,
        "LIB_TYPE",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
    ];
    use HasFactory;

    public static function dataListe(int $statut) {
       return TypePropriete::orderBy('LIB_TYPE')
       ->where('STATUT', $statut)->get();
    }

    public static function libelleSurID(int $id) {
        $data = TypePropriete::find($id);
        if (isset($data->ID_TYPE_PROPRIETE) && $data->ID_TYPE_PROPRIETE>0) {
            return strtoupper($data->LIB_TYPE);
        }else{ return new TypePropriete; }
    }
}
