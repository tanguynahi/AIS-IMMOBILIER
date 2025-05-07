<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProprietesPlan extends Model
{
    protected $table = "ImmoPlanPropriete";
    protected $primaryKey = "ID_PLAN_PROP";
    public $timestamps = false;

    protected $fillable = [
        "ID_PLAN_PROP" ,
        "PATH_PLAN",
        "STATUT",
        "ID_PROPRIETES",
        "DATECREA",
        "DATEMAJ",
    ];
    use HasFactory;

    public static function dataListe(int $id, int $statut) {
        return ProprietesPlan::orderBy('ID_PLAN_PROP', 'desc')
        ->where('ID_PROPRIETES', $id)->where('STATUT', $statut)->get();
    }

}
