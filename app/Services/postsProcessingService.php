<?php

namespace App\Services;

use App\Post as Post;
use App\sentimentValue as sentimentValue;
use App\Entity as Entity;
use App\LaravelAylienWrapper\Facades\Aylien as Aylien;
use AYLIEN\TextAPI;

class postsProcessingService
{
      public function readFileAndDecode($path){
          $json = json_decode(file_get_contents($path), true);
          return $json;
      }

      public function sentimentAnalysis($post){
          return Aylien::Sentiment( array('text' => $post->textData ));
      }

      public function entityAnalysis($post){
          return Aylien::Entities( array('text' => $post->textData , 'language' => 'en' ) );
      }

      public function tweetToPostModel($tweet){

        $id = $tweet['id_str'];
        $tweet_text = isset($tweet['text']) ? $tweet['text'] : null;
        $user_id = isset($tweet['user']['id_str']) ? $tweet['user']['id_str'] : null;
        $tweet_text = isset($tweet['text']) ? $tweet['text'] : null;
        $date = isset($tweet['created_at']) ? $tweet['created_at'] : null;
        $retweet_count = isset($tweet['retweet_count']) ? $tweet['retweet_count'] : null;
        $favorite_count = isset($tweet['favorite_count']) ? $tweet['favorite_count'] : null;
        $followers_count = isset($tweet['user']['followers_count']) ? $tweet['user']['followers_count'] : null;
        $location = isset($tweet['user']['location']) ? $tweet['user']['location'] : null;




        $post = new post;
        $post->id=  $id;
        $post->customer_id =  $user_id;
        $post->textData = $tweet_text;
        $post->socialMedia = 'twitter';
        $post->date = gmdate('Y-m-d H:i:s', strtotime($date) );
        $post->retweet_count = $retweet_count;
        $post->likes_count = $favorite_count;
        $post->customer_followers_count = $followers_count;
        $post->location = $location;
        return $post;
      }

      public function sentiment_entity($count){
          $posts = Post::where('analysed', 0)->take($count)->get();
          var_dump("fetching post form db ....");
          foreach ($posts as $post) {
            try{
            var_dump("anlysis   -->    ".$post->id);
          $sentimentResult = $this->sentimentAnalysis($post);
          if($sentimentResult != null){
              sentimentValue::create([
                'polarity' => $sentimentResult->polarity,
                'subjectivity' => $sentimentResult->subjectivity	,
                'polarity_confidence' => $sentimentResult->polarity_confidence ,
              	'subjectivity_confidence' => $sentimentResult->subjectivity_confidence	,
                'post_id' => $post->id
              ]);
          }

          $entityResult = $this->entityAnalysis($post);
          if($entityResult != null){
              var_dump($entityResult);
              if ( isset($entityResult->entities->keyword) ){
                $keywords = $entityResult->entities->keyword;
              foreach ($keywords as $keyword) {
                    Entity::create([
                      'name'=> $keyword,
                      'post_id' => $post->id
                    ]);
              }
            }
          }


          $post->analysed=true;
          $post->save();


        }
        catch(\UnexpectedValueException $e){
          echo "$e";
        }
      }

      }
}
