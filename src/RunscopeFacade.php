<?php

namespace Runscope;

use Illuminate\Support\Facades\Facade;

/**
 * Description of RunscopeFacade
 *
 * @author sly
 */
class RunscopeFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Runscope\Runscope';
    }
}