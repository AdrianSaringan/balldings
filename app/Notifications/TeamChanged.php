<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TeamChanged extends Notification
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
            'created' => 'New team added',
            'updated' => 'Team updated',
            'deleted' => 'Team deleted',
            default => 'Team change',
        };

        return [
            'title' => $title,
            'message' => sprintf('%s team "%s" %s.', ucfirst($this->sport), $this->payload['team_name'] ?? 'Team', $this->action),
            'sport' => $this->sport,
            'team' => $this->payload,
        ];
    }
}
