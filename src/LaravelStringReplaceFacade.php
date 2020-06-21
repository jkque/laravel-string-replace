<?php

namespace Jkque\LaravelStringReplace;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jkque\LaravelStringReplace\Skeleton\SkeletonClass
 */
class LaravelStringReplaceFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-string-replace';
    }
}
