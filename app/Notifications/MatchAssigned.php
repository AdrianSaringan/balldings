<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MatchAssigned extends Notification
{
    use Queueable;

    public function __construct(public string $sport, public array $payload)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New match assignment',
            'message' => sprintf('You have been assigned to a %s match: %s vs %s on %s at %s.',
                $this->sport,
                $this->payload['team_a'] ?? '-',
                $this->payload['team_b'] ?? '-',
                $this->payload['match_date'] ?? '-',
                $this->payload['venue'] ?? '-' ),
            'sport' => $this->sport,
            'team_a' => $this->payload['team_a'] ?? null,
            'team_b' => $this->payload['team_b'] ?? null,
            'match_date' => $this->payload['match_date'] ?? null,
            'venue' => $this->payload['venue'] ?? null,
            'match_id' => $this->payload['id'] ?? null,
        ];
    }
}
