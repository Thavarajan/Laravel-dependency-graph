<?php

namespace MRTech\LaravelDependencyGraph\Classes;

class DependencyData
{
    public function __construct(
        public string $classType,
        public ?DependencyData $parent = null,
        /**
         * Reflection methods.
         *
         * @var DependencyMethod[]
         */
        public ?array $methods = [],
        /**
         * Refelction proerpty.
         *
         * @var null|DependencyProperty[]
         */
        public ?array $properties = [],
        /**
         * Children Dependency Data.
         *
         * @var DependencyData[]
         */
        public array $children = [],
        public array $traits = []
    ) {
    }

    public static function fromType(\ReflectionType $type)
    {
        if ($type instanceof \ReflectionNamedType) {
            $d = new static($type->getName());
        } elseif (($type instanceof \ReflectionUnionType) || ($type instanceof \ReflectionIntersectionType)) {
            $d = [];
            foreach ($type->getTypes() as $value) {
                $d[] = new static($value);
            }
        } else {
            return $type;
        }

        return $d;
    }

    public static function fromClass(\ReflectionClass $type)
    {
        if ($type instanceof \ReflectionClass) {
            $d = new static($type->getName());
        } else {
            return $type;
        }

        return $d;
    }
}
