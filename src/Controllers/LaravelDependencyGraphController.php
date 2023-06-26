<?php

namespace MRTech\LaravelDependencyGraph\Controllers;

use Illuminate\Routing\Controller;
use MRTech\LaravelDependencyGraph\Classes\DependencyChecker;

class LaravelDependencyGraphController extends Controller
{
    /**
     * Hold the service.
     *
     * @var DependencyChecker
     */
    public $dependencyChecker;

    /**
     * Constructor.
     *
     * @param  DependencyChecker  $service Reschedule service
     */
    public function __construct(DependencyChecker $service)
    {
        $this->dependencyChecker = $service;
    }
}
