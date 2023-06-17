<?php

namespace MRTech\LaravelDependencyGraph\Classes;

class DependencyChecker
{
    /**
     * Get Dependency List.
     *
     * @param string         $className      -
     * @param DependencyData $dependencyData
     * @param bool           $recursive      get recursive
     * @param int            $level          -
     */
    public function getDependencyList($className, $dependencyData = null, $recursive = true, $level = 1)
    {
        if (empty($dependencyData)) {
            $dependencyData = new DependencyData($className);
        }
        $d = $dependencyData;
        $class = new \ReflectionClass($className);

        if (!($level + 1)) {
            return $d;
        }

        $interfaces = $class->getInterfaceNames();
        if (!empty($interfaces)) {
            $d->children[] = $interfaces;
        }
        if ($parent = $class->getParentClass()) {
            $d->parent = $parent->getName();
            if ($recursive) {
                $d->children[] =
                    $this->getDependencyList($parent->getName(), null, $recursive, $level - 1)
                ;
            }
        }

        $constructor = $class->getConstructor();
        if ($constructor) {
            $this->buildConstructor($constructor, $d, $level);
        }
        foreach ($class->getProperties() as $property) {
            $this->buildProperty($property, $d, $className, $level);
        }

        foreach ($class->getTraits() as $trait) {
            $d->traits = $trait->getName();
            if ($recursive) {
                $d->children[] =
                    $this->getDependencyList($trait->getName(), null, $recursive, $level - 1)
                ;
            }
        }

        return $d;
    }

    /**
     * Build constructor Dependency.
     *
     * @param \ReflectionMethod $constructor -
     * @param mixed             $level       -
     */
    public function buildConstructor(\ReflectionMethod $constructor, DependencyData $dependencyData, $level)
    {
        $dependencyList = [];
        foreach ($constructor->getParameters() as $param) {
            $dependency = $param->getType()->getName();
            $dependencyData->children[] = $dependency;
            if ($level > 1) {
                $dependencyData->children[] =
                    $this->getDependencyList($dependency, null, true, $level - 1)
                ;
            }
        }
    }

    /**
     * Used to build property related dependency.
     *
     * @param \ReflectionProperty $property       -
     * @param DependencyData      $dependencyData -
     * @param string              $className      -
     * @param int                 $level          -
     */
    public function buildProperty(\ReflectionProperty $property, DependencyData $dependencyData, $className, $level)
    {
        if ($property->isPublic() && $property->class == $className) {
            $property->setAccessible(true);
            $dependency = $property->getType();
            $dependencyData->children[] = $dependency->getName();
            if ($level > 1) {
                $dependencyData->children =
                    $this->getDependencyList($dependency, null, true, $level - 1)
                ;
            }
        }
    }

    /**
     * Get array of reflection methods.
     *
     * @param string $className -
     *
     * @return \ReflectionMethod[]
     */
    public function getMethods($className)
    {
        $methods = [];
        $class = new \ReflectionClass($className);
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

    /**
     * Get Properties.
     *
     * @param string $className -
     *
     * @return \ReflectionProperty[]
     */
    public function getProperties($className)
    {
        $properties = [];
        $class = new \ReflectionClass($className);
        foreach ($class->getProperties() as $property) {
            $properties[] = $property->getName();
        }

        return $properties;
    }

    public function getFormattedData($source, $target, $children)
    {
        if (empty($children)) {
            return ['source' => $source, 'target' => $target];
        }

        return ['source' => $source, 'target' => $target, 'children' => $children];
    }
}
