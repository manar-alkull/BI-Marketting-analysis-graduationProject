<?php
namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Services\Classifier;
use App\Services\postsProcessingFacade as PostsProcessing;
use App\Post;


class TwitterController extends Controller
{
    protected $twitterApi;

    function hashtagSearch($hashtag )
    {

      $this->twitterApi = resolve('TwitterAPIExchange');
      $requestMethod='GET';
      $url = 'https://api.twitter.com/1.1/search/tweets.json';

        $getField="?q=#$hashtag&count=3&lang=en";
        $response=$this->twitterApi->setGetfield($getField)
            ->buildOauth($url,$requestMethod)
            ->performRequest();
            $result=json_decode($response);
                var_dump($result);
              die();
              $posts=  $result->statuses;
              return view('twitterPosts' , ['tweets' => $posts ]);

    }

    function SentimentTest(){
      $post = new post;
      $post->textData = "i love iphone";
      $result = PostsProcessing::sentimentAnalysis($post);
      var_dump($result);
      $result = PostsProcessing::entityAnalysis($post);
      var_dump($result);
      die();

    }

    function SentimentTest1(){
      PostsProcessing::sentiment_entity(0);

    }
    function test($filename){
      $path = storage_path() . "/json/${filename}.txt";

        $decodedJson = PostsProcessing::readFileAndDecode($path);

        foreach ($decodedJson['statuses'] as $tweet) {
          $post = PostsProcessing::tweetToPostModel($tweet);
          $post->save();
          //var_dump($post);
          //die();
        }
        //var_dump($decodedJson);

    }

    public function cleanTest()
    {

        $text="I luv my &lt;3 iphone &amp; you're awsm apple. DisplayIsAwesome, sooo happppppy 🙂 http://www.apple.com";

        $result = shell_exec("python ". app_path()."\Http\Controllers\Car.py " . escapeshellarg($text));

        var_dump($result);
        die();
        return view('adminlte::home');
    }

    public function classify(){
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        ini_set('max_execution_time', 5000); //300 seconds = 5 minutes
        ini_set('memory_limit', '-1');
        //Classifier::classifyPosts();
        Classifier::fixDate();
        echo "<hr>";
        print_r(round((microtime(true)-$_SERVER['REQUEST_TIME_FLOAT'])*1000,2));//execute time
    }


    public function __construct()
  {

  }
}
