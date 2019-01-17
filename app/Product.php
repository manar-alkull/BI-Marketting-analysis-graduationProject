<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $fillable = array('id','name' , 'brand_id' , 'abstract' , 'manufacturer');

  public function Posts(){
    $this->hasMany('App\Post');
  }

  public function Study(){
    $this->belongsTo('App\Study');
  }

  public function users(){
      return $this->belongsToMany('App\Models\Auth\User','product_user','product_id','user_id');
  }
}
