<?php

namespace MRTech\LaravelDependencyGraph\Commands;

use Illuminate\Console\Command;

class LaravelDependencyGraphCommand extends Command
{
    public $signature = 'laravel-dependency-graph';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
