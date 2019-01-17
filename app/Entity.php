<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    protected $fillable = array('name' , 'property_id' , 'post_id' , 'sentiment_value');

    public function Post(){
      $this->belongsTo('App\Post');
    }

}
