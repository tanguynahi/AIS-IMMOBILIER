<?php

namespace App\Livewire;

use Help;
use Livewire\Component;
use App\Models\Paiements;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Models\PreuvePaiement;
use Illuminate\Validation\Rule;
use App\Models\ClientRedevances;
use Livewire\Attributes\Validate;

class CreationPaiement extends Component
{
    use WithFileUploads;
    #[Validate('required', message: 'Veuillez indiquer la redevance à payer', onUpdate: false)]
    #[Validate('gt:0', message: 'Veuillez indiquer la redevance à payer', onUpdate: false)]
    public $idLIAIS;
    #[Validate('required', message: 'Veuillez indiquer un mode de paiement valide', onUpdate: false)]
    #[Validate('gt:0', message: 'Veuillez indiquer un mode de paiement valide', onUpdate: false)]
    public $serviceID;
    public $reference;
    public $date;
    public $heure;
    public $montant;
    public $fichier = [];
    public $fichID;

    protected $listeners = ['updateWireChps'];

    protected function rules(){
        return [

            'reference' => [
                "required","min:4",
                Rule::unique('ImmoPaiements', 'REFERENCE_P')->where(function ($query) {
                return $query->where('ImmoPaiements.ID_LIAIS', $this->idLIAIS);
                })
            ],
            'date' => ['required', 'date_format:Y-m-d', 'before_or_equal:'.date("Y-m-d")],
            'heure' => "nullable",
            'montant' => "required|min:100|integer",
            'fichier' => "required",
            'fichier.*' => "image|mimes:jpg,jpeg,png|max:2048",
        ];
    }

    protected $messages = [
        'reference.required' => 'Veuillez renseigner la reference de paiement.',
        'reference.min' => 'Veuillez renseigner une reférence valide, minimum 4 caractères.',
        'reference.unique' => 'Un paiement pour cette facturation porte déjà la reférence que vous avez saisi.',
        'date.required' => 'Veuillez renseigner une date valide du paiement.',
        'date.date_format' => 'Format de date non valide.',
        'date.before_or_equal' => 'La date de paiement ne pas être supérieur à la date du jour.',
        'montant.required' => 'Veuillez saisir un montant du paiement.',
        'montant.min' => 'Veuillez saisir un montant valide, montant minimum requis 100 F.',
        'fichier.required' => 'Vous devez sélectionner au moins une preuve de paiement',
        'fichier.*' => 'fichier requis au format jpg,jpeg,png, taille:2048 octets)',
    ];

    public function mount($idL){

        $this->fichID = 0;
        $this->idLIAIS = $idL;
    }


    #[On('updateWireChps')]
    public function updateWireChps($idL, $idS){
        $this->idLIAIS = $idL;
        $this->serviceID = $idS;
    }

    public function savePaiement(){
        $this->validate();
        $us = Help::getAuthUser();
        $data = ClientRedevances::find($this->idLIAIS);
        if (isset($data->ID_LIAIS) && $data->ID_ENTREPRISE>0){
            (bool) $bError = false;
            (int) $MontantPaiement = $this->montant;
            (int) $MontantTotalPayer = $data->TOTAL_PAYER;
            (int) $MontantTotalAPayer = $data->TOTAL_A_PAYER;
            if ($data->ID_TYPE_PERIODE == 1) {
                // Il s'agit d'un paiement 'Immediat'
                if ($MontantPaiement < $MontantTotalAPayer) {
                    $bError = true;
                    $this->addError('ajaxmessV', 'Le montant à payer ne doit pas être inférieur au montant de la facturation');
                }
            }
            if ($bError==false) {
                if ($MontantTotalPayer == $MontantTotalAPayer) {
                    $bError = true;
                    $this->addError('ajaxmessV', 'Vous êtes à jour de paiement de cette facturation');
                }else{
                    if ($MontantTotalAPayer < ($MontantTotalPayer + $MontantPaiement) ) {
                        (int) $RestApayer = ($MontantTotalAPayer - $MontantTotalPayer);
                        $bError = true;
                        $this->addError('ajaxmessV', 'Le reste a payer pour cette facturation est de '. Help::formatNombre($RestApayer ?? '0', true));
                    }
                }
                if ($bError==false) {
                    $paiement = new Paiements();
                    $paiement->ID_CLIENT = $data->ID_CLIENT;
                    $paiement->ID_LIAIS = $this->idLIAIS;
                    $paiement->REFERENCE_P = $this->reference;
                    $paiement->SERVICE_ID = $this->serviceID;
                    $paiement->LIB_SERVICE_ID = Help::LibelleMoyenSurID($this->serviceID);
                    $paiement->NO_TRANSACTION = 'X';
                    $paiement->MONTANT = $this->montant;
                    $paiement->DATE_PAIEMENT = $this->date;
                    $paiement->HEURE_PAIEMENT = date("his");//$this->heure;
                    $paiement->CHAINEJSON = json_encode($paiement);
                    $paiement->ID_REFPAIEMENT = 0;
                    $paiement->STATUT = Help::$ENATTENTE;
                    $paiement->DATECREA = Help::dhSys();
                    $paiement->ID_ENTREPRISE = $data->ID_ENTREPRISE;
                    if ($paiement->save()){
                            // dd($this->fichier);
                        foreach ($this->fichier as $key=>$file) {
                            $preuve = new PreuvePaiement();
                            $fileName = trim(time().'FPAY-'.$file->getClientOriginalName());
                            $file->StoreAs("FichiersPaiement/".$paiement->ID_ENTREPRISE, $fileName, 'public_cemazone');
                            $preuve->PATH_PREUVE_PAY = "FichiersPaiement/".$paiement->ID_ENTREPRISE."/".$fileName;
                            $preuve->STATUT = Help::$ACTIF;
                            $preuve->DATECREA = Help::dhSys();
                            $preuve->ID_PAIEMENTS = $paiement->ID_PAIEMENTS;
                            $preuve->ID_ENTREPRISE = $paiement->ID_ENTREPRISE;
                            $preuve->save();
                        }
                        return redirect()->route('paiemClientList');
                    }else{ $this->addError('ajaxmessV', 'Echec de validation.'); }
                }
            }
        }else{ $this->addError('ajaxmessV', 'Une erreur s\'est produite.'); }
    }

    public function render() {
        return view('livewire.creation-paiement', ['idLIAIS'=>$this->idLIAIS, 'serviceID'=>$this->serviceID]);
    }
}
