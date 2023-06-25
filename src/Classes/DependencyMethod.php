<?php

namespace MRTech\LaravelDependencyGraph\Classes;

class DependencyMethod
{
    public function __construct(
        public string $methodName,
        public string $belongsToclass = '',
        public ?array $params = null,
        public mixed $returnType = [],
        public ?string $accessType = null
    ) {
    }

    public static function fromMethod(\ReflectionMethod ...$methods)
    {
        $rmethods = [];
        foreach ($methods as $method) {
            $d = new static($method->getName());
            $d->belongsToclass = $method->class;
            $d->params = [];
            foreach ($method->getParameters() as $value) {
                array_push($d->params, [
                    'name' => $value->getName(),
                    'type' => $value->getType(),
                    'class' => $method->class,
                ]);
            }
            \array_push(
                $d->returnType,
                Helper::getFormattedType($method->getReturnType())
            );
            $rmethods[] = $d;
        }

        return $rmethods;
    }
}
