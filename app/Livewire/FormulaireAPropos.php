<?php

namespace App\Livewire;

use Help;
use Livewire\Component;
use App\Models\APropos;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;

class FormulaireAPropos extends Component {
    
    use WithFileUploads;
    public $us;
    public $ID;
    public $libapropos;
    public $description;
    public $imgID;
    public $image;
    public $apropos;

    protected function rules(){
        return [
            'libapropos' => "required|min:5",
            'description' => "required|min:20",
        ];
    }

    protected $messages = [
        'libapropos.required' => 'Veuillez renseigner une designation pour le service.',
        'libapropos.min' => 'Veuillez renseigner une designation valide, minimum 5 caractères.',
        'description.required' => 'Veuillez renseigner une description pour le service.',
        'description.min' => 'Veuillez renseigner une description valide, minimum 20 caractères.',
    ];

    public function mount($id){
        $this->ID = $id;
        if ($this->ID>0) {
            $data = APropos::find($id);
            if (isset($data->ID_APROPOS) && $data->ID_APROPOS>0) {
                $this->libapropos = $data->TITRE_INFO;
                $this->description = $data->CONTENU_INFO;
            }else{ $this->addError('ajaxmess', 'Une erreur s\'est produite 1001'); }
        }else{ $this->apropos = new APropos(); }
        $this->us = Help::getAuthUser();
    }

    public function saveAPropos(){

        if ($this->ID!=null) {
            (bool) $bError = false;
            $obj = new APropos();
            if ($this->ID>0) {
                $obj = APropos::find($this->ID);
                if (!isset($obj->ID_APROPOS)) {
                    $bError = true;
                    $this->addError('ajaxmess', 'Une erreur s\'est produite 1002');
                }else{
                    $obj->DATEMAJ = Help::dhSys();
                    if (($obj->TITRE_INFO) != $this->libapropos) {
                        $res = APropos::where('TITRE_INFO', ($this->libapropos))
                        ->where('ID_ENTREPRISE', $this->us->ID_ENTREPRISE)->where('STATUT', Help::$ACTIF)->first();
                        if (isset($res->ID_APROPOS)) {
                            $bError = true;
                            $this->addError('ajaxmess', 'Une information apropos existe déjà pour la designation indiquée.');
                        }
                    }
                }
            }else{
                $res = APropos::where('TITRE_INFO', ($this->libapropos))
                ->where('ID_ENTREPRISE', $this->us->ID_ENTREPRISE)->where('STATUT', Help::$ACTIF)->first();
                if (isset($res->ID_APROPOS)) {
                    $bError = true;
                    $this->addError('ajaxmess', 'Une information apropos existe déjà pour la designation indiquée.');
                }
            }
            if ($bError==false) {
                $this->validate();
                $obj->TITRE_INFO = ($this->libapropos);
                $obj->CONTENU_INFO = $this->description;
                if ($this->ID==0) {
                    // Cas creation
                    $obj->STATUT = Help::$ACTIF;
                    $obj->DATECREA = Help::dhSys();
                    $obj->ID_ENTREPRISE = $this->us->ID_ENTREPRISE;
                }
                if (isset($this->image) && $this->image!=null) {
                    $chemin = Help::fRepCree('/ImageApropos/'.$obj->ID_ENTREPRISE);
                    $fileName = trim(time().$this->image->getClientOriginalName());
                    $this->image->StoreAs('ImageApropos/'.$obj->ID_ENTREPRISE.'/', $fileName, "public_cemazone");
                    $obj->PATH_APROPOS = 'ImageApropos/'.$obj->ID_ENTREPRISE.'/'.$fileName;
                }
                $obj->save();
                redirect()->route('aproposList');
            }
        }

    }

    public function render(){
        return view('livewire.formulaire-a-propos');
    }
    
}
