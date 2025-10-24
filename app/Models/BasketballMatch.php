<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasketballMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_a',
        'team_b',
        'match_date',
        'venue',
        'score_team_a',
        'score_team_b',
        'winner',
        'status',
        'referee_id',
    ];
}
