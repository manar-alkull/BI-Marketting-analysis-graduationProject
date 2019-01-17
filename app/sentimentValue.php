<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sentimentValue extends Model
{
  protected $fillable = array('id',	'polarity' ,	'subjectivity'	,'polarity_confidence' ,	'subjectivity_confidence'	,'post_id' );

  public function Post(){
    return $this->belongsTo('App/Post');
  }

}
