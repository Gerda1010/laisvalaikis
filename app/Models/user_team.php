<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user_team extends Model
{
    protected $table = 'user_team';
   // protected $primaryKey = 'fk_Teamid_Team,fk_Userid_User';
    public $timestamps = false;

    protected $fillable = ['fk_Teamid_Team ', 'fk_Userid_User '];
}
