<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table='sections';
    //Relación
    /*public function user(){
        return $this->belongsTo('App\User','user_id');
    }*/
}
