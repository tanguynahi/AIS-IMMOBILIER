<?php

namespace App\Models;

use Help;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    protected $table = "ImmoServices";
    protected $primaryKey = "ID_SERVICES";
    public $timestamps = false;

    protected $fillable = [
        "ID_SERVICES" ,
        "LIB_SERVICE",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "ID_ENTREPRISE",
        "ICONS_SERVICE",
        "DESCRIPTION_SERVICE",
        "PATH_SERVICE",
    ];
    use HasFactory;

    public static function dataListe($id) {
       return Service::orderBy('LIB_SERVICE')
       ->where('STATUT', Help::$ACTIF)
       ->where('ID_ENTREPRISE', $id)->get();
    }

    public static function dataDesact(int $id): bool{
        $data = Service::find($id);
        if (isset($data->ID_SERVICES)){
            $data->DATEMAJ = Help::dhSys();
            ($data->STATUT == 1)? $data->STATUT = Help::$INACTIF: $data->STATUT = Help::$ACTIF;
        }
        return $data->save();
    }

    public static function LireSurID($id): Service {
        $service = Service::where('ID_SERVICES', $id)
        ->first();
        if(!empty($service->ID_SERVICES)) return $service;
        else return new Service();
    }
}
