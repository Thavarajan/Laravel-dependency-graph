<?php

namespace MRTech\LaravelDependencyGraph\Tests\stubs;

class Employee extends Person
{
    public string $department;
    public Manager $reportTo;
}
