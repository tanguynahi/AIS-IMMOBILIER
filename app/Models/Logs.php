<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $table = "ImmoLogs";
    protected $primaryKey = "ID_LOGS";
    public $timestamps = false;

    protected $fillable = [
        "ID_LOGS" ,
        "TITRE",
        "CONTENU",
        "DATECREA",
        "IDCONCERNE",
    ];
    use HasFactory;
}
