<?php

namespace MRTech\LaravelDependencyGraph\Classes;

class DependencyProperty
{
    public function __construct(
        public string $propName,
        public string $belongsToclass = '',
        public ?string $accessType = null,
        public mixed $propertyType = null,
        public ?string $class = ''
    ) {
    }

    /**
     * Refelction property.
     *
     * @return \ReflectionProperty
     */
    public function getRflectionProperty()
    {
        $c = new \ReflectionClass($this->class);

        return $c->getProperty($this->propName);
    }

    public static function fromReflectionProperty(\ReflectionProperty ...$property)
    {
        $props = [];
        foreach ($property as $prop) {
            $d = new static($prop->getName());
            $d->belongsToclass = $prop->class;
            $d->class = $prop->class;
            $d->accessType = $prop->getModifiers();
            $d->propertyType = Helper::getFormattedType($prop->getType());
            $props[] = $d;
        }

        return $props;
    }
}
