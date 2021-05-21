<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMatch extends Model
{
    protected $table = 'userMatch';
    protected $primaryKey = 'id_Match';
    public $timestamps = false;

    protected $fillable = ['fk_Participantid_User', 'fk_Participantid_User1','result1','result2', 'fk_Tournamentid_Tournament','winner' ];
}
