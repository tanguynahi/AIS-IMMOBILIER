<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dto extends Model
{
    protected $fillable = [
        "key",
        "var",
        "id",
    ];
    use HasFactory;
}
