<?php

namespace AhmedShuaib\LPackage\Providers;

use AhmedShuaib\LPackage\Console\InstallPackageCommand;
use AhmedShuaib\LPackage\Console\PackageControllerCommand;
use AhmedShuaib\LPackage\Console\PackageGenerator;
use AhmedShuaib\LPackage\Console\PackageMigrationCommand;
use AhmedShuaib\LPackage\Console\PackageModelCommand;
use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider {


    public function boot() {
        if($this->app->runningInConsole()) {
            $this->commands([
                PackageGenerator::class,
                PackageControllerCommand::class,
                PackageModelCommand::class,
                PackageMigrationCommand::class,
                InstallPackageCommand::class
            ]);
        }
    }

    public function register() {

    }
}