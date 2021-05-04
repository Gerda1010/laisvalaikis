<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StartEvent extends Model
{
    protected $table = 'startevent';
    protected $primaryKey = 'id_StartEvent';
    public $timestamps = false;

    protected $fillable = ['name'];



}
