<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'state';
    protected $primaryKey = 'id_Status';
    public $timestamps = false;

    protected $fillable = ['name'];



}
