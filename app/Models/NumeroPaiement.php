<?php

namespace App\Models;

use Help;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NumeroPaiement extends Model
{
    protected $table = "ImmoNumeroPaiement";
    protected $primaryKey = "ID_NUMERO_PAIEMENT";
    public $timestamps = false;

    protected $fillable = [
        "ID_NUMERO_PAIEMENT",
        "DATE_PAIEMENT",
        "NUMERO",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
    ];
    use HasFactory;

    public static function GetNumTransaction() : string {
        $Num = NumeroPaiement::orderBy('ID_NUMERO_PAIEMENT', 'desc')
        ->where('DATE_PAIEMENT', Help::DateSys())
        ->where('STATUT', Help::$ACTIF)->get()->first();
        if(isset($Num->ID_NUMERO_PAIEMENT) && $Num->ID_NUMERO_PAIEMENT>0) {
            // Existant
            $Num->DATEMAJ = date('Ymd');
            $Num->NUMERO = $Num->NUMERO + 1;
        }else{
            // Inexistant
            $Num = new NumeroPaiement();
            $Num->NUMERO = 1;
            $Num->STATUT = Help::$ACTIF;
            $Num->DATECREA = date('Ymd');
            $Num->DATE_PAIEMENT = date('Ymd');
        }
        $Num->save();
        return strtoupper(Str::random(4)).'2-'.date('ymdHi').'-'.Help::NumericToStr($Num->NUMERO, 3);
    }

}
