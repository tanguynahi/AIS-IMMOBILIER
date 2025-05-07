<?php

namespace App\Livewire;

use Help;
use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\FonctionPersonnel;
use Livewire\Attributes\Validate;

class FormulaireFonction extends Component {

    public $us;
    public $ID;
    public $libfonction;
    public $fonction;

    protected function rules(){
        return [
            'libfonction' => "required|min:5",
        ];
    }

    protected $messages = [
        'libfonction.required' => 'Veuillez renseigner une designation pour la fonction.',
        'libfonction.min' => 'Veuillez renseigner une designation valide, minimum 5 caractères.',
    ];

    public function mount($id){
        $this->ID = $id;
        if ($this->ID>0) {
            $data = FonctionPersonnel::find($id);
            if (isset($data->ID_FONCTION_PERS) && $data->ID_FONCTION_PERS>0) {
                $this->libfonction = $data->LIB_FONCTION;
            }else{ $this->addError('ajaxmess', 'Une erreur s\'est produite 1001'); }
        }else{ $this->fonction = new FonctionPersonnel(); }
        $this->us = Help::getAuthUser();
    }

    public function saveFonction(){

        if ($this->ID!=null) {
            (bool) $bError = false;
            $obj = new FonctionPersonnel();
            if ($this->ID>0) {
                $obj = FonctionPersonnel::find($this->ID);
                if (!isset($obj->ID_FONCTION_PERS)) {
                    $bError = true;
                    $this->addError('ajaxmess', 'Une erreur s\'est produite 1002');
                }else{
                    $obj->DATEMAJ = Help::dhSys();
                    if (strtoupper($obj->LIB_FONCTION) != strtoupper($this->libfonction)) {
                        $res = FonctionPersonnel::where('LIB_FONCTION', strtoupper($this->libfonction))
                        ->where('ID_ENTREPRISE', $this->us->ID_ENTREPRISE)->where('STATUT', Help::$ACTIF)->first();
                        if (isset($res->ID_FONCTION_PERS)) {
                            $bError = true;
                            $this->addError('ajaxmess', 'Une designation fonction existe déjà pour la designation indiquée.');
                        }
                    }
                }
            }else{
                $res = FonctionPersonnel::where('LIB_FONCTION', ($this->libfonction))
                ->where('ID_ENTREPRISE', $this->us->ID_ENTREPRISE)->where('STATUT', Help::$ACTIF)->first();
                if (isset($res->ID_FONCTION_PERS)) {
                    $bError = true;
                    $this->addError('ajaxmess', 'Une designation fonction existe déjà pour la designation indiquée.');
                }
            }
            if ($bError==false) {
                $this->validate();
                $obj->LIB_FONCTION = strtoupper($this->libfonction);
                if ($this->ID==0) {
                    // Cas creation
                    $obj->STATUT = Help::$ACTIF;
                    $obj->DATECREA = Help::dhSys();
                    $obj->ID_ENTREPRISE = $this->us->ID_ENTREPRISE;
                }
                $obj->save();
                redirect()->route('fonctionList');
            }
        }

    }

    public function render(){
        return view('livewire.formulaire-fonction');
    }
    
}
