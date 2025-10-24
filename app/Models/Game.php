<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'sport',
        'team1_id',
        'team2_id',
        'team1_score',
        'team2_score',
        'status',
        'played_at',
        'venue',
    ];

    protected $casts = [
        'played_at' => 'datetime',
    ];

    public function stats()
    {
        return $this->hasMany(GamePlayerStat::class);
    }
}
