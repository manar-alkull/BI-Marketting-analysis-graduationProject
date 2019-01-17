<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
      protected $fillable = array('id','location' , 'textData' , 'date' , 'product_id' , 'customer_id', 'socialMedia' , 'retweet_count' , 'likes_count' , 'customer_followers_count');


      protected $primaryKey = 'id';

      public $incrementing = false;

      public function entitys(){
        return $this->hasMany('App\Entity');
      }

    public function entitys2(){
        return $this->hasMany('App\Entity')->select(['id','name']);
    }

      public function Product(){
       return $this->belongsTo('App\Product');
     }

    public function Customer(){
        return $this->belongsTo('App\Customer');
          }

      public function sentimetValue(){
        return $this->hasOne('App\sentimentValue');
      }

    public function sentimetValue2(){
        return $this->hasOne('App\sentimentValue')->select(['id','polarity','polarity_confidence']);
    }


}
