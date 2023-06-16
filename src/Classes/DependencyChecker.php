<?php

namespace MRTech\LaravelDependencyGraph\Classes;

class DependencyChecker
{
    /**
     * Get Dependency List.
     *
     * @param string $className -
     * @param bool   $recursive get recursive
     * @param int    $level     -
     */
    public function getDependencyList($className, $recursive = true, $level = 1)
    {
        $dependencyList = [];
        $class = new \ReflectionClass($className);

        if (!$level) {
            return $this->getDependencyList($className, 1);
        }

        $dependencyList = array_merge($dependencyList, $class->getInterfaceNames());
        if ($parent = $class->getParentClass()) {
            $dependencyList[] = $parent->getName();
            if ($recursive) {
                $dependencyList = [
                    ...$dependencyList,
                    ...$this->getDependencyList($parent->getName(), $recursive, $level - 1),
                ];
            }
        }

        $constructor = $class->getConstructor();
        if ($constructor) {
            $dependencyList[] = $this->buildConstructor($constructor, $dependencyList, $level);
        }
        foreach ($class->getProperties() as $property) {
            $dependencyList = $this->buildProperty($property, $class, $className, $dependencyList, $level);
        }

        foreach ($class->getTraits() as $trait) {
            $dependencyList[] = $trait->getName();
            if ($recursive) {
                $dependencyList = [
                    ...$dependencyList,
                    ...$this->getDependencyList($trait->getName(), $recursive, $level - 1),
                ];
            }
        }

        return $dependencyList;
    }

    /**
     * Build constructor Dependency.
     *
     * @param \ReflectionMethod $constructor    -
     * @param mixed             $dependencyList -
     * @param mixed             $level          -
     */
    public function buildConstructor($constructor, $dependencyList, $level)
    {
        foreach ($constructor->getParameters() as $param) {
            $dependency = $param->getType()->getName();
            if (!in_array($dependency, $dependencyList)) {
                $dependencyList[] = $dependency;
                if ($level > 1) {
                    $dependencyList = [
                        ...$dependencyList,
                        ...$this->getDependencyList($dependency, $level - 1),
                    ];
                }
            }
        }

        return $dependencyList;
    }

    /**
     * Used to build property related dependency.
     *
     * @param \ReflectionProperty $property       -
     * @param object              $class          -
     * @param string              $className      -
     * @param array               $dependencyList -
     * @param int                 $level          -
     */
    public function buildProperty($property, $class, $className, $dependencyList, $level)
    {
        if ($property->isPublic() && $property->class == $className) {
            $property->setAccessible(true);
            $dependency = get_class($property->getValue($class));
            if (!in_array($dependency, $dependencyList)) {
                $dependencyList[] = $dependency;
                if ($level > 1) {
                    $dependencyList = [
                        ...$dependencyList,
                        ...$this->getDependencyList($dependency, $level - 1),
                    ];
                }
            }
        }

        return $dependencyList;
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
