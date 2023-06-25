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
            $d->parent = DependencyData::fromClass($parent);
            if ($recursive) {
                $this->getDependencyList($parent->getName(), $d->parent, $recursive, $level - 1);
            }
        }

        $constructor = $class->getConstructor();
        if ($constructor) {
            $this->buildConstructor($constructor, $d, $level);
        }
        $d->methods = $this->getMethods($class);
        $d->properties = $this->getProperties($class);
        foreach ($d->properties as $property) {
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
        foreach ($constructor->getParameters() as $param) {
            $dependency = $param->getType()->getName();
            $dependencyData->children[] = DependencyData::fromType($param->getType());
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
     * @param DependencyProperty $property       -
     * @param DependencyData     $dependencyData -
     * @param string             $className      -
     * @param int                $level          -
     */
    public function buildProperty(DependencyProperty $dProperty, DependencyData $dependencyData, $className, $level)
    {
        $property = $dProperty->getRflectionProperty();
        if ($property->isPublic() && $property->class == $className) {
            $dependency = $property->getType();
            if ($dependency instanceof \ReflectionClass) {
                $dependencyData->children[] = DependencyData::fromType($dependency);
                if ($level > 1) {
                    $dependencyData->children =
                        $this->getDependencyList($dependency, null, true, $level - 1)
                    ;
                }
            }
        }
    }

    /**
     * Get array of reflection methods.
     *
     * @param string $className -
     *
     * @return DependencyMethod[]
     */
    public function getMethods($className)
    {
        $methods = [];
        if ($className instanceof \ReflectionClass) {
            $class = $className;
        } else {
            $class = new \ReflectionClass($className);
        }
        $methods = DependencyMethod::fromMethod(...$class->getMethods());
        foreach ($class->getTraits() as $trait) {
            foreach ($trait->getMethods() as $method) {
                $methods[] = $method->getName();
            }
            array_push($methods, DependencyMethod::fromMethod(...$trait->getMethods()));
        }

        return $methods;
    }

    /**
     * Get Properties.
     *
     * @param string $className -
     *
     * @return DependencyProperty[]
     */
    public function getProperties($className)
    {
        if ($className instanceof \ReflectionClass) {
            $class = $className;
        } else {
            $class = new \ReflectionClass($className);
        }

        return DependencyProperty::fromReflectionProperty(...$class->getProperties());
    }
}
