<?php

use MRTech\LaravelDependencyGraph\Classes\DependencyChecker;
use MRTech\LaravelDependencyGraph\Tests\stubs\Manager;

it('DependencyChecker class can create object', function () {
    expect(new DependencyChecker())->toBeTruthy();
});

it('DependencyChecker class can generate DependencyList array', function () {
    $d = new DependencyChecker();
    dump($d->getDependencyList(Manager::class));
    expect($d)->toBeTruthy();
});
