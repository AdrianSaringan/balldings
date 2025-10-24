<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamePlayerStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'user_id',
        'team_id',
        'sport',
        'points',
        'rebounds',
        'assists',
        'steals',
        'blocks',
        'fouls',
        'minutes',
        'kills',
        'aces',
        'digs',
        'vb_blocks',
        'vb_assists',
        'receptions',
        'errors',
        'sets_played',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
