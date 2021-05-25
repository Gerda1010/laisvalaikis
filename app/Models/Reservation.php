<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservation';
    protected $primaryKey = 'id_Reservation';
    public $timestamps = false;

    protected $fillable = ['reservation_Date', 'fk_Userid_User', 'fk_Objectid_Object','fk_Tournament'];
}
