<?php

namespace App\Models;

use Help;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreuvePaiement extends Model
{
    protected $table = "ImmoPreuvesPaiement";
    protected $primaryKey = "ID_PREUVESPAIEMENT";
    public $timestamps = false;

    protected $fillable = [
        "ID_PREUVESPAIEMENT",
        "ID_PAIEMENTS",
        "PATH_PREUVE_PAY",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "ID_ENTREPRISE",
    ];
    use HasFactory;

    public static function dataListe ($id) {
        return PreuvePaiement::orderBy('ID_PREUVESPAIEMENT', 'desc')
        ->join('ImmoPaiements', 'ImmoPaiements.ID_PAIEMENTS', '=', 'ImmoPreuvesPaiement.ID_PAIEMENTS')
        ->where('ImmoPaiements.ID_PAIEMENTS', '=', $id)
        ->where('ImmoPreuvesPaiement.STATUT', '!=', Help::$INACTIF)->get();
    }
}
