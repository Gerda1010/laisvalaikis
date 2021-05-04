<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $table = 'tournament';
    protected $primaryKey = 'id_Tournament';
    public $timestamps = false;

    protected $fillable = ['Name', 'MaximumTeams', 'StartDate', 'State','StartEvent', 'fk_Organizerid_User', 'fk_Userid_User', 'fk_Gameid_Game' ];
}
