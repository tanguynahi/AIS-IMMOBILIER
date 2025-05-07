<?php

namespace App\Livewire;

use Help;
use Livewire\Component;
use App\Models\Affaires;
use App\Models\Paiements;
use Illuminate\Validation\Rule;
use App\Models\ClientRedevances;
use Livewire\Attributes\Validate;

class PaiementsClient extends Component {

    public $datemax;
    public $datemin;
    public $idclient;
    public $idaffaire;
    public $idliaison;
    public $identreprise;

    public $affaires;
    public $liaisons;
    public $paiements;

    protected function rules(){
        return [
            'datemin' => ['required', 'date_format:Y-m-d'],
            'datemax' => ['required', 'date_format:Y-m-d'],
        ];
    }

    protected $messages = [
        'datemin.required' => 'La date debut \'Du\' est obligatoire.',
        'datemin.date_format' => 'Veuillez renseigner une date debut \'Du\' valide.',
        'datemax.required' => 'La date fin \'Au\' est obligatoire.',
        'datemax.date_format' => 'Veuillez renseigner une date fin \'Au\' valide.',
    ];

    public function mount($id){
        $this->affaires = [];
        $this->liaisons = [];
        $this->paiements = [];
        $this->idclient = $id;
        $datJour = Help::DateSys();
        $this->datemax = Help::lastdayOfmonth($datJour);
        $this->datemin = Help::firstdayOfmonth($datJour);
        if ($this->idclient>0){
            $this->affaires = Affaires::cliListaffaireClient($this->idclient);;
        }else{ $this->affaires = []; }
        $this->paiements = Paiements::paiementSurCliIDAffIDLiaisID($this->idclient, 0, 0, $this->datemin, $this->datemax);
    }

    public function getfacturationaffaire(){
        $this->validate();
        if ($this->idaffaire>0){
            $this->liaisons = ClientRedevances::cliListeRedevanceSurAffaire($this->idaffaire);
        }else{ $this->liaisons = []; }
        $this->downloadList();
    }

    public function downloadList(){
        $this->paiements = Paiements::paiementSurCliIDAffIDLiaisID($this->idclient, $this->idaffaire, $this->idliaison,
        $this->datemin, $this->datemax);
    }

    public function render(){
        return view('livewire.paiements-client');
    }

}
