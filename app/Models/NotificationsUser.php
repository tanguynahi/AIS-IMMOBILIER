<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationsUser extends Model
{
    use HasFactory;

    public static function NbNotifications() {
        $data = DB::select('
            SELECT COUNT ("notifications"."id") as "Nb"
            FROM "notifications"
        ');
        $data = $data[0]->Nb;
        return $data;
    }
}
