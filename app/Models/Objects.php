<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Objects extends Model
{
    protected $table = 'objects';
    protected $primaryKey = 'id_team';
    public $timestamps = false;

    protected $fillable = ['Name', 'Obtain'];
}
