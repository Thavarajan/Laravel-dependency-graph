<?php

namespace MRTech\LaravelDependencyGraph\Classes;

class DependencyData
{
    public function __construct(
        public string $classType,
        public string $parent = '',
        public array $children = [],
        public array $traits = []
    ) {
    }
}
