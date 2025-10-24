<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Basketball;
use App\Models\Volleyball;

class Bracket extends Model
{
    use HasFactory;

    protected $fillable = [
        'sport',
        'team1_id',
        'team2_id',
        'round',
        'status',
        'winner',
        'bracket_type',
        'tournament_name',
    ];

    // Relationships
    public function team1()
    {
        return $this->belongsTo(User::class, 'team1_id');
    }

    public function team2()
    {
        return $this->belongsTo(User::class, 'team2_id');
    }

    // Accessors for team names based on sport
    public function getTeam1NameAttribute(): ?string
    {
        if ($this->sport === 'basketball') {
            return optional(Basketball::find($this->team1_id))->team_name;
        }
        if ($this->sport === 'volleyball') {
            return optional(Volleyball::find($this->team1_id))->team_name;
        }
        return null;
    }

    public function getTeam2NameAttribute(): ?string
    {
        if ($this->sport === 'basketball') {
            return optional(Basketball::find($this->team2_id))->team_name;
        }
        if ($this->sport === 'volleyball') {
            return optional(Volleyball::find($this->team2_id))->team_name;
        }
        return null;
    }
}
