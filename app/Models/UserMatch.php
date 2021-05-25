<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMatch extends Model
{
    protected $table = 'user_matches';
    protected $primaryKey = 'id_user_match';
    public $timestamps = false;

    protected $fillable = ['fk_Userid_User1', 'fk_Userid_User2','result1','result2', 'fk_Tournamentid_Tournament','winner' ];
}
