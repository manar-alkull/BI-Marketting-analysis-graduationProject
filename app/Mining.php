<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mining extends Model
{
    public $timestamps = false;

    protected $fillable = array('product_id' ,'sentiment', 'post_id', 'date' , 'productName','sentiment_scale' , 'price','product','promotion','place'/*,'entites'*/,'day','month','year','cal_promotion','country');
    public function Post(){
        $this->belongsTo('App\Post');
    }

    public function Product(){
        return $this->belongsTo('App\Product');
    }

    public function setData($analysis)
    {
        $this->product_id = $analysis->product_id ;
        $this->post_id = $analysis->post_id ;
        $this->date = $analysis->date ;
        $this->productName = $analysis->productName ;
        $this->sentiment_scale = $analysis->sentiment_scale ;
        $this->price = $analysis->price+1 ;
        $this->product = $analysis->product+1 ;
        $this->place = $analysis->place ;
        $this->day = $analysis->day ;
        $this->month = $analysis->month ;
        $this->year = $analysis->year ;
        $this->cal_promotion = $analysis->cal_promotion ;
        $this->country = $analysis->country ;
        $this->sentiment=$analysis->sentiment;
    }
}
