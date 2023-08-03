<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $defaultNamespace = 'App\Services';

        // Extract the namespace and name from the given argument
        $namespace = $defaultNamespace;
        if (str_contains($name, '/')) {
            $parts = explode('/', $name);
            $name = array_pop($parts);
            $namespace .= '\\' . implode('\\', $parts);
        }

        $convertNamespace = str_replace('\\', '/', $namespace);
        $path = "$convertNamespace/$name.php";

        if (file_exists($path)) {
            $this->error('Service already exists');
            return;
        }

        // Check if the directory for the file exists, and create it if it doesn't
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        $stub = file_get_contents(__DIR__ . '/Stubs/service.stub');

        $stub = str_replace($defaultNamespace, $namespace, $stub);
        $stub = str_replace('DummyService', $name, $stub);

        file_put_contents($path, $stub);

        $this->info('Service has been created succesfully');
    }
}
