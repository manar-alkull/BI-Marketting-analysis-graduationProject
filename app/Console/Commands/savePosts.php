<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Services\postsProcessingFacade as PostsProcessing;
use App\Post as Post;
use App\Product as Product;

class savePosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'savePosts {date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'save post that is exist in the files inside the folder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      try {

        $directory = $this->argument('date');
        //$directory = storage_path()."/json/$date";
    //    var_dump($date);
        $files = File::allFiles($directory);
        foreach ($files as $file)
          {
            try{

            $productName =  substr($file->getFileName(),0,-14);//get the product name without the history
            $product = Product::firstOrCreate(['name' => $productName]);

            echo ("saving ($product->name) posts \n " );

            $decodedJson = PostsProcessing::readFileAndDecode($directory."/".$file->getFileName() );

            foreach ($decodedJson['statuses'] as $tweet) {

              $post = PostsProcessing::tweetToPostModel($tweet);
              $fetchedPost =  Post::find($post->id);
              if($fetchedPost == null){
                var_dump('saving post -->   '.$post->id);
                  $post->product_id = $product->id;
                  $post->save();
                }
              else{
                if( !isset($fetchedPost->retweet_count) ){
                  //var_dump($fetchedPost);
                  var_dump('modifying post -->   '.$post->id);

                    $fetchedPost->update(array(
                      'location' => $post->location ,
                      'retweet_count' => $post->retweet_count,
                      'likes_count' => $post->likes_count,
                      'customer_followers_count' => $post->customer_followers_count
                    ));
                  }
                }
            }
          } catch (Exception $e) {
              var_dump($e->errorInfo);
          }
          }
        } catch (\Illuminate\Database\QueryException $e) {
            var_dump($e->errorInfo);
        }
    }
}
