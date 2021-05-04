<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class event_log extends Model
{
    protected $table = 'event_log';
    protected $primaryKey = 'id_Log';
    public $timestamps = false;

    protected $fillable = ['log_Date', 'fk_Userid_User', 'log_text', 'fk_Tournament'];
}
