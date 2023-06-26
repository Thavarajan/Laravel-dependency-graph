<?php

use MRTech\LaravelDependencyGraph\Classes\DependencyChecker;
use MRTech\LaravelDependencyGraph\Tests\stubs\Manager;
use MRTech\LaravelDependencyGraph\Tests\stubs\Person;

it('DependencyChecker class can create object', function () {
    expect(new DependencyChecker())->toBeTruthy();
});

it('DependencyChecker class can generate DependencyList Data', function () {
    $d = new DependencyChecker();
    $dependencyData = $d->getDependencyList(Manager::class);
    expect($dependencyData)->toBeTruthy();
});

it('DependencyChecker Manager class Extends person data', function () {
    $d = new DependencyChecker();
    $dependencyData = $d->getDependencyList(Manager::class);
    $string = json_encode($dependencyData, JSON_PRETTY_PRINT);
    $jsonerror = json_last_error();
    expect($jsonerror)->toBeInt()->toBe(0);
    expect($string)->not->toBeEmpty();
    expect($dependencyData->parent->classType)->toBe(Person::class);
})->only();
