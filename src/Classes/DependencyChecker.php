<?php

namespace MRTech\LaravelDependencyGraph\Classes;

use ReflectionClass;

class DependencyChecker
{
    public function getDependencyList($className, $recursive = true, $level = 1)
    {
        $dependencyList = array();
        $class = new ReflectionClass($className);
        $dependencyList = array_merge($dependencyList, $class->getInterfaceNames());
        if ($parent = $class->getParentClass()) {
            $dependencyList[] = $parent->getName();
            if ($recursive) {
                $dependencyList = array_merge($dependencyList, $this->getDependencyList($parent->getName(), $recursive, $level-1));
            }
        }
        foreach ($class->getTraits() as $trait) {
            $dependencyList[] = $trait->getName();
            if ($recursive) {
                $dependencyList = array_merge($dependencyList, $this->getDependencyList($trait->getName(), $recursive, $level-1));
            }
        }
        return $dependencyList;
    }
    public function getMethods($className)
    {
        $methods = array();
        $class = new ReflectionClass($className);
        foreach ($class->getMethods() as $method) {
            $methods[] = $method->getName();
        }
        foreach ($class->getTraits() as $trait) {
            foreach ($trait->getMethods() as $method) {
                $methods[] = $method->getName();
            }
        }
        return $methods;
    }
    public function getProperties($className)
    {
        $properties = array();
        $class = new ReflectionClass($className);
        foreach ($class->getProperties() as $property) {
            $properties[] = $property->getName();
        }
        return $properties;
    }
}
