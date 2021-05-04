<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    protected $table = 'matches';
    protected $primaryKey = 'id_team_match';
    public $timestamps = false;

    protected $fillable = ['fk_Team1', 'fk_Team2','result1','result2', 'fk_Tournamentid_Tournament','winner' ];
}
