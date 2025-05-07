<?php

namespace App\Notifications;

use Help;
use App\Models\Prospect;
use App\Models\Proprietes;
use App\Models\DemandeVisite;
use Illuminate\Bus\Queueable;
use App\Models\NotificationsUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DemandeClientNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Prospect $prospect, public Proprietes $propriete, public DemandeVisite $demande)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $iduser = $this->prospect->ID_PROSPECT;
        $libuser = $this->prospect->NOM.' '.$this->prospect->PRENOMS;
        $nbmail = NotificationsUser::NbNotifications() + 1;
        return (new MailMessage)
        ->subject('Nouvelle demande de propriete')
        ->view("emails.nouvelle-demande", [
            "id" => $iduser,
            "idmail" => $nbmail,
            'NomPrenoms' => $libuser,
            "demande" => $this->demande,
            "propriete" => $this->propriete
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $iduser = $this->prospect->ID_PROSPECT;
        $libprop = $this->propriete->LIB_PROPRIETE;
        $libtyp = Help::LibelleTypeDemande($this->demande->TYPE_DEMAND ?? 0);
        $libuser = $this->prospect->NOM.' '.$this->prospect->PRENOMS;
        $nbmail = NotificationsUser::NbNotifications() + 1;
        return [
            "message"=>"Une nouvelle demande de $libtyp a été sousmise par $libuser, pour la propriete < $libprop >",
            "identifiant"=>"IMS-$iduser",
            "refmail"=>$nbmail
        ];
    }
}
