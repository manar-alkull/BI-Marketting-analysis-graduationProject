<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function posts(){
      $this->hasMany('App\Post');
    }
}
