<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';
    protected $primaryKey = 'id_Comment';
    public $timestamps = false;

    protected $fillable = ['com_Text', 'Com_Date', 'fk_Userid_User','fk_Tournamentid_Tournament'];
}
