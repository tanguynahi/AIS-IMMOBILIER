<?php

namespace App\Models;
use Help;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visiteurs extends Model
{
    protected $table = "ImmoVisiteur";
    protected $primaryKey = "ID_VISITEUR";
    public $timestamps = false;

    protected $fillable = [
        "ID_VISITEUR",
        "IP_VISITEUR",
        "MAP_VISITEUR",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
    ];
    use HasFactory;

    public static function verifier($map,$ip)
    {
        $verifier = Visiteurs::where('MAP_VISITEUR', $map)
                            ->where('IP_VISITEUR',$ip)
                            ->first();
        if (!empty($verifier) && $verifier->ID_VISITEUR > 0) {
            return $verifier;
        } else {
            return 0;
        }
    }
    public static function saveLog()
    {
        $activity = new Visiteurs;

        $agent = $_SERVER['HTTP_USER_AGENT'] ?? '';

        if (preg_match('/Linux/i', $agent)) $os = 'Linux';
        elseif (preg_match('/Mac/i', $agent)) $os = 'Mac';
        elseif (preg_match('/iPhone/i', $agent)) $os = 'iPhone';
        elseif (preg_match('/iPad/i', $agent)) $os = 'iPad';
        elseif (preg_match('/Droid/i', $agent)) $os = 'Droid';
        elseif (preg_match('/Unix/i', $agent)) $os = 'Unix';
        elseif (preg_match('/Windows/i', $agent)) $os = 'Windows';
        else $os = 'Unknown';

        if (preg_match('/Firefox/i', $agent)) $br = 'Firefox';
        elseif (preg_match('/Mac/i', $agent)) $br = 'Mac';
        elseif (preg_match('/Chrome/i', $agent)) $br = 'Chrome';
        elseif (preg_match('/Opera/i', $agent)) $br = 'Opera';
        elseif (preg_match('/MSIE/i', $agent)) $br = 'IE';
        else $br = 'Unknown'; //  Unknown = Inconnue
        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');


        $activity->MAP_VISITEUR = $br . '/' . $os;;
        $activity->MAP_VISITEUR = $br . '/' . $os;;
        $activity->MAP_VISITEUR = $br . '/' . $os;;
        // $activity->MAP_VISITEUR = self::getMacAddress();
        $activity->IP_VISITEUR = Help::getIp();
        $activity->STATUT = Help::$ACTIF;
        $activity->DATECREA = Help::dhSys();

        $verifier = self::verifier($activity->MAP_VISITEUR, $activity->IP_VISITEUR);
        if (!$verifier) {
            $activity->save();

        }
    }
}
