<?php

namespace AhmedShuaib\LPackage\Providers;

use AhmedShuaib\LPackage\Console\PackageControllerCommand;
use AhmedShuaib\LPackage\Console\PackageGenerator;
use AhmedShuaib\LPackage\Console\PackageMigrationCommand;
use AhmedShuaib\LPackage\Console\PackageModelCommand;
use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider {


    public function boot() {
        if($this->app->runningInConsole()) {

            $filesystem = $this->app->make(\Illuminate\Filesystem\Filesystem::class);
            $customStubPath = null; // Set this to the path containing your custom stubs, or leave it as null for default stubs

            $creator = new \Illuminate\Database\Migrations\MigrationCreator($filesystem, $customStubPath);
            $composer = $this->app->make(\Illuminate\Support\Composer::class);

            $this->commands([
                PackageGenerator::class,
                PackageControllerCommand::class,
                PackageModelCommand::class,
                PackageMigrationCommand::class
                // new PackageMigrationCommand($creator, $composer)
            ]);
        }
    }

    public function register() {

    }
}