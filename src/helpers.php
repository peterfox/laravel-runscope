<?php

if (function_exists('app') && !function_exists('runscope_url')) {
    /**
     * Get the root Facade application instance.
     *
     * @param  string $make
     * @return mixed
     */
    function runscope_url($url)
    {
        $runscope = app()->make('Runscope\Runscope');

        return $runscope->getProxifiedUrl($url);
    }
}
