<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypePeriode extends Model
{
    protected $table = "TypePeriode";
    protected $primaryKey = "ID_TYPE_PERIODE";
    public $timestamps = false;

    protected $fillable = [
        "ID_TYPE_PERIODE" ,
        "LIB_PERIODE",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
    ];
    use HasFactory;

    public static function dataListe($statut) {
        return TypePeriode::orderBy('ID_TYPE_PERIODE')
        ->where('STATUT', $statut)->get();
    }
    
    public static function libelleSurID($id) {
        $data = TypePeriode::find($id);
        if (isset($data->ID_TYPE_PERIODE) && $data->ID_TYPE_PERIODE>0) {
            return $data->LIB_PERIODE;
        }else{ return 'xxxxxxxxxx'; }
    }
}
