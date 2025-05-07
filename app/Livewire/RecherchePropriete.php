<?php

namespace App\Livewire;

use Help;
use App\Models\Pays;
use App\Models\Ville;
use Livewire\Component;
use App\Models\Categories;
use App\Models\Proprietes;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\TypePropriete;
use App\Models\AnneeConstruction;
use Illuminate\Support\Facades\DB;

class RecherchePropriete extends Component {
    
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $all_status;
    public $all_categories;
    public $city;
    public $nb_pieces;
    public $annee_const;
    public $min_area;
    public $max_area;
    public $min_price;
    public $max_price;
    public $wifi;
    public $piscine;
    public $cuisine_equip;
    public $clim;
    public $parking;
    public $securite;
    public $salle_sport;

    public $str;
    public $idPays;
    public $nombres;

    public $result = [];
    public $recent = [];

    public $pays = [];
    public $types = [];
    public $villes = [];
    public $annees = [];
    public $categories = [];

    public function mount($request) {

        // dd($request);

        $this->types = TypePropriete::dataListe(Help::$ACTIF);
        $this->categories = Categories::dataListe(Help::$ACTIF);
        $this->annees = AnneeConstruction::dataListe(Help::$ACTIF);

        $this->idPays = 0;
        $this->pays = Pays::dataListe(Help::$ACTIF);
        if (count($this->pays)>0) {
            $this->idPays = $this->pays[0]->ID_PAYS;
        }
        $this->villes = Ville::dataListe($this->idPays, Help::$ACTIF);
        $this->nombres = Proprietes::proprietesFeatured(Help::$ENTREPRISE);

        $this->all_status = $request->all_status;
        $this->all_categories = $request->all_categories;
        $this->city = $request->city;
        $this->nb_pieces = $request->nb_pieces;
        $this->annee_const = $request->annee_const;
        $this->min_area = $request->min_area;
        $this->max_area = $request->max_area;
        $this->min_price = $request->min_price;
        $this->max_price = $request->max_price;
        // $this->wifi = $request->wifi;
        // $this->piscine = $request->piscine;
        // $this->cuisine_equip = $request->cuisine_equip;
        // $this->clim = $request->clim;
        // $this->parking = $request->parking;
        // $this->securite = $request->securite;
        // $this->salle_sport = $request->salle_sport;
    }

    #[On('updateWireChps')]
    public function updateWireChps($p1, $p2, $p3, $p4, $p5){
        $this->all_status = $p1;
        $this->city = $p2;
        $this->all_categories = $p3;
        $this->nb_pieces = $p4;
        $this->annee_const = $p5;
    }

    public function liveSEARCH(){
        // dd($this->all_status, $this->all_categories, $this->city, $this->nb_pieces, $this->annee_const, $this->min_area,
        // $this->max_area, $this->min_price, $this->max_price, $this->wifi, $this->piscine, $this->cuisine_equip, $this->clim,
        // $this->parking, $this->securite, $this->salle_sport );
    }

    public function liste() {

        $str  = '
        SELECT
            "ImmoProprietes".*,
            "ImmoCategories"."ID_TYPE" AS "ID_TYPE",
            "ImmoCategories"."LIB_CATEGORIE" AS "LIB_CATEGORIE",
            "AnneeConstruction"."LIB_ANNEE_CONST" AS "ANNEE",
            "ImmoTypePropriete"."LIB_TYPE" AS "LIB_TYPE",
            CASE "ImmoProprietes"."EN_PROMOTION"
            WHEN true THEN ("ImmoProprietes"."PRIX_HT" - ("ImmoProprietes"."PRIX_HT" * ("ImmoProprietes"."POURCENT_PROMO"/100)))
            ELSE 0
            END AS "PRIX_PROMO"
        FROM
            "ImmoProprietes" INNER JOIN "ImmoCategories" ON "ImmoCategories"."ID_CATEGORIES" = "ImmoProprietes"."ID_CATEGORIES"
            INNER JOIN "ImmoTypePropriete" ON "ImmoTypePropriete"."ID_TYPE_PROPRIETE" = "ImmoProprietes"."ID_TYPE_PROPRIETE"
            LEFT JOIN "AnneeConstruction" ON "AnneeConstruction"."ANNEE_CONST_ID" = "ImmoProprietes"."ANNEE_CONST"
        WHERE
            "ImmoProprietes"."STATUT" = '.Help::$ACTIF.'
            AND "ImmoProprietes"."ID_ENTREPRISE" = '.Help::$ENTREPRISE.'
        ';

        if ($this->all_status!=null && $this->all_status>0){
            $str .= ' AND "ImmoProprietes"."ID_TYPE_PROPRIETE" = '.$this->all_status;
        }
        if ($this->all_categories!=null && $this->all_categories>0){
            $str .= ' AND "ImmoProprietes"."ID_CATEGORIES" = '.$this->all_categories;
        }
        if ($this->city!=null && $this->city>0){
            $str .= ' AND "ImmoProprietes"."ID_VILLE" = '.$this->city;
        }
        if ($this->nb_pieces!=null && $this->nb_pieces>0){
            $str .= ' AND "ImmoProprietes"."NB_PIECES" = '.$this->nb_pieces;
        }
        if ($this->annee_const!=null && $this->annee_const>0){
            $str .= ' AND "ImmoProprietes"."ANNEE_CONST" = '.$this->annee_const;
        }

        if (($this->min_area!=null && $this->max_area!=null) && ($this->min_area>0 && $this->max_area>0)){
            $str .= ' AND "ImmoProprietes"."SUPERFICIE" BETWEEN \''.$this->min_area.'\' AND \''.$this->max_area.'\'';
        }
        if (($this->min_price!=null && $this->max_price!=null) && ($this->min_price>0 && $this->max_price>0)){
            $str .= ' AND "ImmoProprietes"."PRIX_HT" BETWEEN '.$this->min_price.' AND '.$this->max_price;
        }

        if ($this->wifi!=null && $this->wifi==true){
            $str .= ' AND "ImmoProprietes"."WIFI" = 1';
        }
        if ($this->piscine!=null && $this->piscine==true){
            $str .= ' AND "ImmoProprietes"."PISCINE" = 1';
        }
        if ($this->cuisine_equip!=null && $this->cuisine_equip==true){
            $str .= ' AND "ImmoProprietes"."CUSINE_EQUIPE" = 1';
        }
        if ($this->clim!=null && $this->clim==true){
            $str .= ' AND "ImmoProprietes"."CLIMATISATION" = 1';
        }
        if ($this->parking!=null && $this->parking==true){
            $str .= ' AND "ImmoProprietes"."PARKING" = 1';
        }
        if ($this->securite!=null && $this->securite==true){
            $str .= ' AND "ImmoProprietes"."SECURITE" = 1';
        }
        if ($this->salle_sport!=null && $this->salle_sport==true){
            $str .= ' AND "ImmoProprietes"."SALLE_DE_SPORT" = 1';
        }
        $str .= ' ORDER BY "ImmoProprietes"."PRIX_HT" DESC LIMIT 100';

        $datas = DB::select($str);
        // dd($datas);
        return $datas;
    }

    public function render() {

        $this->result = $this->liste();

        if(count($this->result)>0){
            $this->recent = Proprietes::proprieteRecent($this->result[0]->ID_PROPRIETES);
        }else{ $this->recent = []; }

        return view('livewire.recherche-propriete',['result'=>$this->result]);
    }
}
