<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basketball extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_name',
        'coach_name',
        'number_of_players',
        'coach_user_id',
    ];

    // Kung table mo ay hindi "basketballs"
    // protected $table = 'basketball_teams';
}
