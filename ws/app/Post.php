<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table="posts";
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
    public function section(){
        return $this->belongsTo('App\Section','section_id');
    }
}
