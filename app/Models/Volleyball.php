<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volleyball extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_name',
        'coach_name',
        'num_of_players',
        'coach_user_id',
    ];
}
