<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\postsProcessingFacade as PostsProcessing;

class AylienPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AylienPosts {count}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fetch (count) post recods that is not analysed form db and analysis them';

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
          $count = $this->argument('count');
          PostsProcessing::sentiment_entity($count);
    }
}
