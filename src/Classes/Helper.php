<?php

namespace MRTech\LaravelDependencyGraph\Classes;

class Helper
{
    public function getFormattedData($source, $target, $children)
    {
        if (empty($children)) {
            return ['source' => $source, 'target' => $target];
        }

        return ['source' => $source, 'target' => $target, 'children' => $children];
    }

    public static function getFormattedType(
        \ReflectionNamedType|\ReflectionUnionType|\ReflectionIntersectionType|null $type
    ) {
        if ($type instanceof \ReflectionNamedType) {
            $d = ['name' => $type->getName()];
        } elseif (($type instanceof \ReflectionUnionType) || ($type instanceof \ReflectionIntersectionType)) {
            $d = [];
            foreach ($type->getTypes() as $value) {
                $d[] = Helper::getFormattedType($value);
            }
        } else {
            return $type;
        }

        return $d;
    }
}
