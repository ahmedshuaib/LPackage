<?php

namespace AhmedShuaib\LPackage\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Input\InputOption;

class PackageMigrationCommand extends Command {

    protected $signature = 'make:package-migration {name : The name of the migration.}
    {--create= : The table to be created.}
    {--table= : The table to migrate.}
    {--path= : The location where the migration file should be created.}
    {--package= : The package where the migration file should be created.}';

    protected $description = 'Create a new migration file for a package';

    public function handle()
    {
        $name = $this->argument('name');
        $create = $this->option('create');
        $table = $this->option('table');
        $path = $this->option('path');
        $package = $this->option('package');

        if($package) {
            $path = "{$package}/src/database/migrations";
        }

        $options = [
            'name' => $name,
            '--path' => $path
        ];

        if($create) {
            $options['--create'] = $create;
        }
        else if($table) {
            $options['--table'] = $table;
        }

        Artisan::call('make:migration', $options);

        $this->info(Artisan::output());
    }


}