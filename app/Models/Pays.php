<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    protected $table = "Pays";
    protected $primaryKey = "ID_PAYS";
    public $timestamps = false;

    protected $fillable = [
        "ID_PAYS" ,
        "LIB_PAYS",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
    ];
    use HasFactory;

    public static function dataListe(int $statut) {
       return Pays::orderBy('LIB_PAYS')
       ->where('STATUT', $statut)->get();
    }
}
