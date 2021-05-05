<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obtained extends Model
{
    protected $table = 'obtained';
    protected $primaryKey = 'id_Obtained';
    public $timestamps = false;

    protected $fillable = ['name'];


//    protected $Obtained = [
//        'Nuomojamas',
//        'Nupirktas'
//    ];
//    public function getObtained($value)
//    {
//        return Arr::get($this->Obtained, $value);
//    }




}
