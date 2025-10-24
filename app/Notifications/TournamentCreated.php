<?php

namespace App\Notifications;

use App\Models\Tournament;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TournamentCreated extends Notification
{
    use Queueable;

    public function __construct(public Tournament $tournament)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New tournament created',
            'message' => sprintf('A new %s tournament "%s" has been added.', $this->tournament->sport, $this->tournament->name),
            'tournament_id' => $this->tournament->id,
            'name' => $this->tournament->name,
            'sport' => $this->tournament->sport,
            'start_date' => $this->tournament->start_date,
            'end_date' => $this->tournament->end_date,
            'venue' => $this->tournament->venue,
            'status' => $this->tournament->status,
            'created_at' => $this->tournament->created_at,
        ];
    }
}
