<?php

namespace App\Models;

use Help;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "ImmoUtilisateur";
    protected $primaryKey = "ID_UTILISATEUR";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "ID_UTILISATEUR",
        "NOM",
        "PRENOMS",
        "CONTACT",
        "ADR_EMAIL",
        "LOGIN",
        "MOT_DE_PASSE",
        "SEL",
        "MDP_A_LA_CNX",
        "ID_PROFIL",
        "ID_CLIENT",
        "USER_ONLINE",
        "AVATAR",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "ID_PERSONNELS",
        "ID_ENTREPRISE",
        "email",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function routeNotificationForMail()
    {
        return $this->ADR_EMAIL;
    }


    public static function connexion(String $login, String $password): User
    {
        $user = User::LireLogin($login);
        if ($user->ID_UTILISATEUR > 0) {
            $user->USER_ONLINE = false;
            if (Help::HashVerifier($password, $user->SEL, $user->MOT_DE_PASSE)) {
                $user->USER_ONLINE = true;
                $user->save();
                $user->SEL = "";
                $user->MOT_DE_PASSE = "";
                Help::to_session($user);
            }
            return $user;
        }
        return new User();
    }

    public static function LireLogin(String $login): User
    {
        $user = User::where('LOGIN', $login)->first();
        if (isset($user->ID_UTILISATEUR) && $user->ID_UTILISATEUR > 0) return $user;
        else return new User();
    }

    public static function LireSurID($id): User
    {
        $user = User::where('ID_UTILISATEUR', $id)->first();
        if (isset($user->ID_UTILISATEUR) && $user->ID_UTILISATEUR > 0) return $user;
        else return new User();
    }

    public static function LireSurIDPERS($idPers): User
    {
        $user = User::where('ID_PERSONNELS', $idPers)
            ->where('STATUT', Help::$ACTIF)->first();
        if (isset($user->ID_UTILISATEUR) && $user->ID_UTILISATEUR > 0) return $user;
        else return new User();
    }


    public static function listeCompUser($idE)
    {
        return DB::select('
            SELECT
                "ImmoUtilisateur"."ID_UTILISATEUR",
                "ImmoUtilisateur"."NOM",
                "ImmoUtilisateur"."PRENOMS",
                "ImmoUtilisateur"."CONTACT",
                "ImmoUtilisateur"."LOGIN",
                "ImmoUtilisateur"."STATUT",
                "FonctionPersonne"."LIB_FONCTION"
            FROM
                "ImmoUtilisateur"
            INNER JOIN "ImmoPersonnels"
                ON "ImmoUtilisateur"."ID_PERSONNELS" = "ImmoPersonnels"."ID_PERSONNELS"
            INNER JOIN "FonctionPersonne"
                ON "FonctionPersonne"."ID_FONCTION_PERS" = "ImmoPersonnels"."ID_FONCTION_PERS"
            WHERE
                "ImmoUtilisateur"."ID_PROFIL" = ?
                AND "ImmoPersonnels"."ID_PERSONNELS" > ?
                AND "ImmoUtilisateur"."STATUT" = ?
                AND "ImmoUtilisateur"."ID_ENTREPRISE" = ?
            ORDER BY
                "ImmoUtilisateur"."ID_UTILISATEUR" DESC
        ', [3, 1, 1, $idE]); // Paramètres sécurisés
    }
}
