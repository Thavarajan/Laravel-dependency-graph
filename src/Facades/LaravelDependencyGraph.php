<?php

namespace MRTech\LaravelDependencyGraph\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MRTech\LaravelDependencyGraph\LaravelDependencyGraph
 */
class LaravelDependencyGraph extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \MRTech\LaravelDependencyGraph\LaravelDependencyGraph::class;
    }
}
