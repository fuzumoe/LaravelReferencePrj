<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag  extends Model
{
    //

    public function posts(){
        return $this->morphedByMany('App\Post','taggable');
    }

    public function vidoes(){
        return $this->morphedByMany('App\Post','taggable');
    }

}
