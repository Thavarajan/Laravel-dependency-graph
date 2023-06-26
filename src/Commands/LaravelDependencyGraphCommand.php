<?php

namespace MRTech\LaravelDependencyGraph\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use MRTech\LaravelDependencyGraph\Classes\DependencyChecker;

class LaravelDependencyGraphCommand extends Command
{
    public $signature = 'dependency:generate';

    public $description = 'My command';

    public $dependency;

    public function __construct(DependencyChecker $dependency)
    {
        $this->dependency = $dependency;
        parent::__construct();
    }

    public function handle(): int
    {
        $this->comment('All done');
        $this->generateHtml();

        return self::SUCCESS;
    }

    public function generateHtml()
    {
        $destinationPath = config('laravel-erd.docs_path') ?? base_path('docs/erd/');
        $classname = '';
        // extract data
        $linkDataArray = $this->dependency->getDependencyList($classname);

        if (! File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0o755, true);
        }
        File::put(
            $destinationPath.'/index.html',
            view('erd::index')
                ->with([
                    'routingType' => config('laravel-erd.display.routing') ?? 'AvoidsNodes',

                    // pretty print array to json
                    'docs' => json_encode(
                        [
                            'data' => $linkDataArray,
                        ]
                    ),
                ])
                ->render()
        );

        $this->info("ERD data written successfully to {$destinationPath}");
    }
}
