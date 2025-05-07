<?php

namespace App\Livewire;

use Help;
use Livewire\Component;
use App\Models\Affaires;
use App\Models\ClientRedevances;

class FormulairePaiement extends Component {

    public $us;
    public $AffID;
    public $LiasID;
    public $affaires = [];
    public $redevances = [];

    public function mount($idLIAS) {
        $this->LiasID = $idLIAS;
        $this->us = Help::getAuthUser();
        $this->affaires = Affaires::cliListaffaireClient($this->us->ID_CLIENT);
        if ($this->LiasID>0) {
            $liaison = ClientRedevances::find($this->LiasID);
            $this->AffID = $liaison->ID_AFFAIRES;
            $this->getListFacturation();
        }
    }

    public function getListFacturation() {
        $this->redevances = ClientRedevances::cliListeRedevanceSurAffaire($this->AffID);
    }
    public function render() {
        return view('livewire.formulaire-paiement');
    }

}
