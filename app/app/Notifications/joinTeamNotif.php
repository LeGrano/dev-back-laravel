<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Team;

class joinTeamNotif extends Notification
{
    use Queueable;
    protected $action;
    protected $team;

    /**
     * Create a new notification instance.
     *
     * @param string $action
     * @param Team $team
     */
    public function __construct($action, Team $team)
    {
        $this->action = $action;
        $this->team = $team;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->line('Vous avez reçu une notification de l\'équipe!');
        //TODO Enregistrer les mails dans la bdd
        switch ($this->action) {
            case 'joinTeam':
                $message->line('Un nouveau membre a rejoint l\'équipe!')
                    ->action('Voir l\'équipe', url('http://localhost:8051/liste'))
                    ->line('Merci de faire partie de notre équipe!');
                break;

            case 'leaveTeam':
                $message->line('Un membre a quitté l\'équipe.')
                    ->line('Nous espérons vous revoir bientôt!');
                break;

            case 'addUsers':
                $message->line('Des utilisateurs ont été ajoutés à l\'équipe!')
                    ->action('Voir l\'équipe', url('http://localhost:8051/liste'))
                    ->line('Merci de faire partie de notre équipe!');
                break;
            case 'addTeamPassword':
                $message->line('Un nouveau mot de passe a été ajouté à l\'équipe!')
                    ->action('Voir l\'équipe', url('http://localhost:8051/liste'))
                    ->line('Merci de faire partie de notre équipe!');
                break;
            default:
                // Action par défaut
                break;
        }

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'team' => $this->team->name,
            'sent_at' => now()->toDateTimeString(),
            'action' => $this->action
        ];
    }
}
