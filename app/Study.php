<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    public function User(){
      $this->belongsTo('App\User');
    }

    public function Products(){
      $this->hasMany('App\Products');
    }
}
