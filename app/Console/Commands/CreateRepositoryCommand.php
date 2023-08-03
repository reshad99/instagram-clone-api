<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repo {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Repository';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $needle = 'Repository';
        $name = $this->argument('name');
        $defaultNamespace = 'App\Repositories';

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
            $this->error("$needle already exists");
            return;
        }

        // Check if the directory for the file exists, and create it if it doesn't
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        $stub = file_get_contents(__DIR__ . '/Stubs/repository.stub');

        $stub = str_replace($defaultNamespace, $namespace, $stub);
        $stub = str_replace('DummyClass', $name, $stub);

        if (str_contains($name, $needle))
            $modelName = rtrim($name, $needle);

        $stub = str_replace('Test::', $modelName. '::', $stub);

        file_put_contents($path, $stub);

        $this->info("$needle has been created succesfully");
    }
}
