<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    public $timestamps = false;

    protected $fillable = array('product_id' ,'sentiment', 'post_id', 'date' , 'productName','sentiment_scale' , 'price','product','promotion','place'/*,'entites'*/,'day','month','year','cal_promotion','country');
    public function Post(){
        $this->belongsTo('App\Post');
    }

    /*public function Product(){
        return $this->belongsTo('App\Product');
    }*/

}
