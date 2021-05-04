<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tournament_team extends Model
{
    protected $table = 'tournament_team';
    protected $primaryKey = 'id_Tournament_team';
    public $timestamps = false;

    protected $fillable = ['fk_Teamid_Team', 'fk_Tournamentid_Tournament','victories'];

}
