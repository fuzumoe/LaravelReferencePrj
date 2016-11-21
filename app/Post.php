<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

//    protected  $table = 'posts';
//    protected  $primaryKey = 'id';
//overriden method $filable  to allow mas execution
   protected $fillable = [
       'title',
       'body',
       'is_admin'
   ];

    public  function users(){
        return $this->belongsToMany('App\User');
    }

    public function photos(){
        return $this->morphMany('App\Photo','imageable');
    }

    public function tags(){
        return $this->morphToMany('App\Tag','taggable');
    }


}

