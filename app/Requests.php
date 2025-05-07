<?php

class Requests
{
    public $act;
    public $all_status;
    public $all_categories;
    public $pays;
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

    public function __construct(
        $act = '',
        $all_status = 0,
        $all_categories = 0,
        $pays = 0,
        $city = 0,
        $nb_pieces = 0,
        $annee_const = 0,
        $min_area = 0,
        $max_area = 500,
        $min_price = 0,
        $max_price = 15000000,
        $wifi = null,
        $piscine = null,
        $cuisine_equip = null,
        $clim = null,
        $parking = null,
        $securite = null,
        $salle_sport = null,
    ) {
        $this->$act = $act;
        $this->$all_status = $all_status;
        $this->$all_categories = $all_categories;
        $this->$pays = $pays;
        $this->$city = $city;
        $this->$nb_pieces = $nb_pieces;
        $this->$annee_const = $annee_const;
        $this->$min_area = $min_area;
        $this->$max_area = $max_area;
        $this->$min_price = $min_price;
        $this->$max_price = $max_price;
        $this->$wifi = $wifi;
        $this->$piscine = $piscine;
        $this->$cuisine_equip = $cuisine_equip;
        $this->$clim = $clim;
        $this->$parking = $parking;
        $this->$securite = $securite;
        $this->$salle_sport = $salle_sport;
    }
}
