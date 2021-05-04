<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'Game';
    protected $primaryKey = 'id_Game';
    public $timestamps = false;

    protected $fillable = ['Name', 'NumberOfMembers', 'fk_Objectid_Object'];
}
