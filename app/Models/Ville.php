<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    protected $table = "Ville";
    protected $primaryKey = "ID_VILLE";
    public $timestamps = false;

    protected $fillable = [
        "ID_VILLE" ,
        "LIB_VILLE",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "ID_PAYS",
    ];
    use HasFactory;

    public static function dataListe($id, $statut) {
       return Ville::orderBy('LIB_VILLE')
       ->where('ID_PAYS', $id)->where('STATUT', $statut)->get();
    }

    public static function libelleSurID(int $id) {
        $data = Ville::find($id);
        if (isset($data->ID_VILLE) && $data->ID_VILLE>0) {
            return strtoupper($data->LIB_VILLE);
        }else{ return new Ville; }
    }
}
