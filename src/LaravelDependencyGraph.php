<?php

namespace MRTech\LaravelDependencyGraph;

use MRTech\LaravelDependencyGraph\Classes\DependencyChecker;

class LaravelDependencyGraph
{
    public function getGraphData(string $className)
    {
        $d = new DependencyChecker();

        return $d->getDependencyList($className);
    }
}
