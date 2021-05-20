<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tournament_user extends Model
{
    protected $table = 'tournament_user';
    protected $primaryKey = 'id_tournament_user';
    public $timestamps = false;

    protected $fillable = ['fk_Userid_User', 'fk_Tournamentid_Tournament','victories'];

}
