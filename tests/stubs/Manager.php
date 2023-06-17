<?php

namespace MRTech\LaravelDependencyGraph\Tests\stubs;

class Person
{
    public string $name;
}

class Manager extends Person
{
    public string $assistant;
}
