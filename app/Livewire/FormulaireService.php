<?php

namespace App\Livewire;

use Help;
use Livewire\Component;
use App\Models\Service;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;

class FormulaireService extends Component
{
    use WithFileUploads;
    public $us;
    public $ID;
    public $libservice;
    public $description;
    public $imgID;
    public $image;
    public $icons;
    public $service;

    protected function rules(){
        return [
            'libservice' => "required|min:5",
            'description' => "required|min:20",
        ];
    }

    protected $messages = [
        'libservice.required' => 'Veuillez renseigner une designation pour le service.',
        'libservice.min' => 'Veuillez renseigner une designation valide, minimum 5 caractères.',
        'description.required' => 'Veuillez renseigner une description pour le service.',
        'description.min' => 'Veuillez renseigner une description valide, minimum 20 caractères.',
    ];

    public function mount($id){
        $this->ID = $id;
        if ($this->ID>0) {
            $data = Service::find($id);
            if (isset($data->ID_SERVICES) && $data->ID_SERVICES>0) {
                $this->libservice = $data->LIB_SERVICE;
                $this->description = $data->DESCRIPTION_SERVICE;
            }else{ $this->addError('ajaxmess', 'Une erreur s\'est produite 1001'); }
        }else{ $this->service = new Service(); }
        $this->us = Help::getAuthUser();
    }

    public function saveService(){

        if ($this->ID!=null) {
            (bool) $bError = false;
            $obj = new Service();
            if ($this->ID>0) {
                $obj = Service::find($this->ID);
                if (!isset($obj->ID_SERVICES)) {
                    $bError = true;
                    $this->addError('ajaxmess', 'Une erreur s\'est produite 1002');
                }else{
                    $obj->DATEMAJ = Help::dhSys();
                    if (($obj->LIB_SERVICE) != $this->libservice) {
                        $res = Service::where('LIB_SERVICE', ($this->libservice))
                        ->where('ID_ENTREPRISE', $this->us->ID_ENTREPRISE)->where('STATUT', Help::$ACTIF)->first();
                        if (isset($res->ID_SERVICES)) {
                            $bError = true;
                            $this->addError('ajaxmess', 'Un service existe déjà pour la designation indiquée.');
                        }
                    }
                }
            }else{
                $res = Service::where('LIB_SERVICE', ($this->libservice))
                ->where('ID_ENTREPRISE', $this->us->ID_ENTREPRISE)->where('STATUT', Help::$ACTIF)->first();
                if (isset($res->ID_SERVICES)) {
                    $bError = true;
                    $this->addError('ajaxmess', 'Un service existe déjà pour la designation indiquée.');
                }
            }
            if ($bError==false) {
                $this->validate();
                $obj->LIB_SERVICE = ($this->libservice);
                $obj->DESCRIPTION_SERVICE = $this->description;
                if ($this->ID==0) {
                    // Cas creation
                    $obj->STATUT = Help::$ACTIF;
                    $obj->DATECREA = Help::dhSys();
                    $obj->ID_ENTREPRISE = $this->us->ID_ENTREPRISE;
                }
                if (isset($this->image) && $this->image!=null) {
                    $chemin = Help::fRepCree('/ImageService/'.$obj->ID_ENTREPRISE);
                    $fileName = trim(time().$this->image->getClientOriginalName());
                    $this->image->StoreAs('ImageService/'.$obj->ID_ENTREPRISE.'/', $fileName, "public_cemazone");
                    $obj->PATH_SERVICE = 'ImageService/'.$obj->ID_ENTREPRISE.'/'.$fileName;
                }
                $obj->save();
                redirect()->route('serviceList');
            }
        }

    }

    public function render(){
        return view('livewire.formulaire-service');
    }
}
