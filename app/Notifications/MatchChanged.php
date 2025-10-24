<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MatchChanged extends Notification
{
    use Queueable;

    public function __construct(
        public string $sport,
        public string $action, // created|updated|deleted
        public array $payload = []
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $title = match ($this->action) {
            'created' => 'New match scheduled',
            'updated' => 'Match updated',
            'deleted' => 'Match canceled',
            default => 'Match change',
        };

        $teams = trim(($this->payload['team_a'] ?? '-') . ' vs ' . ($this->payload['team_b'] ?? '-'));
        $when = $this->payload['match_date'] ?? null;
        $venue = $this->payload['venue'] ?? null;

        $msg = match ($this->action) {
            'created' => sprintf('%s match %s on %s at %s.', ucfirst($this->sport), $teams, $when ?: 'TBA', $venue ?: 'TBA'),
            'updated' => sprintf('%s match %s has been updated.', ucfirst($this->sport), $teams),
            'deleted' => sprintf('%s match %s has been canceled.', ucfirst($this->sport), $teams),
            default => sprintf('%s match %s changed.', ucfirst($this->sport), $teams),
        };

        return [
            'title' => $title,
            'message' => $msg,
            'sport' => $this->sport,
            'match' => $this->payload,
        ];
    }
}
