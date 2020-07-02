<?php

namespace Jkque\StringReplace;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jkque\StringReplace\Skeleton\SkeletonClass
 */
class StringReplaceFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'string-replace';
    }
}
