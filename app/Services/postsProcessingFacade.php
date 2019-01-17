<?php
namespace App\Services;

use \Illuminate\Support\Facades\Facade;

/**
 * Facade for user service
 */
class postsProcessingFacade extends Facade
{

    /**
     * Returning service name
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'App\Services\postsProcessingService';
    }
}
