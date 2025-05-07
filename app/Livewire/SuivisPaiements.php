<?php

namespace App\Livewire;

use Help;
use App\Models\Client;
use Livewire\Component;
use App\Models\Affaires;
use App\Models\Paiements;
use Illuminate\Validation\Rule;
use App\Models\ClientRedevances;
use Livewire\Attributes\Validate;

class SuivisPaiements extends Component {
    
    public $datemax;
    public $datemin;
    public $idclient;
    public $idaffaire;
    public $idliaison;
    public $identreprise;

    public $clients;
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
        $this->clients = [];
        $this->affaires = [];
        $this->liaisons = [];
        $this->paiements = [];
        $this->identreprise = $id;
        $datJour = Help::DateSys();
        $this->datemax = Help::lastdayOfmonth($datJour);
        $this->datemin = Help::firstdayOfmonth($datJour);
        $this->clients = Client::cliListe($this->identreprise);
        $this->paiements = Paiements::paiementListe(0, $this->identreprise, 0, 0, $this->datemin, $this->datemax);
    }

    public function getaffaireclient(){
        $this->validate();
        if ($this->idclient>0){
            $this->affaires = Affaires::affaireSurClientID($this->identreprise, $this->idclient);
        }else{ $this->affaires = []; }
        $this->downloadList();
    }

    public function getfacturationaffaire(){
        $this->validate();
        if ($this->idaffaire>0){
            $this->liaisons = ClientRedevances::cliListeRedevanceSurAffaire($this->idaffaire);
        }else{ $this->liaisons = []; }
        $this->downloadList();
    }

    public function downloadList(){
        $this->paiements = Paiements::paiementListe($this->idclient, $this->identreprise, $this->idaffaire, $this->idliaison,
        $this->datemin, $this->datemax);
    }

    public function render(){
        return view('livewire.suivis-paiements');
    }

}
