<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use TwitterAPIExchange;

class twitterServiceProvider extends ServiceProvider
{


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {



          $this->app->singleton(TwitterAPIExchange::class, function ($app ) {

            $settings = array(
              'oauth_access_token' => "926397164372353024-Mywo6hLjrEXmsBbFcLVIdMNtRoLXyum",
              'oauth_access_token_secret' => "nUHVn2wCNzZY9nA7dQK881yVCPyQD2XSZvfpc9pkfBQPo",
              'consumer_key' => "ReVclgAvW9IVi8I8Pnnxz4W2x",
              'consumer_secret' => "knbjG6P9Plr730YjXnWehMmHhvytDN7tIYyyk81xUOag8DZfu3"
            );
              return  new TwitterAPIExchange($settings);
          });
    }
}
