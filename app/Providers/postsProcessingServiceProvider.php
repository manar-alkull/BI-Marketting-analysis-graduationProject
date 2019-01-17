<?php
namespace App\Providers;

use App\Services\postsProcessingService;
use Illuminate\Support\ServiceProvider;

/**
 * Registering User service
 */
class postsProcessingServiceProvider extends ServiceProvider
{

    /**
     * Binding User service
     */
    public function register()
    {
        $this->app->bind('postsProcessingService', function ($app) {
            return new postsProcessingService();
        });
    }
}
