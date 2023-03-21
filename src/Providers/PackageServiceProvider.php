<?php

namespace AhmedShuaib\LPackage\Providers;

use AhmedShuaib\LPackage\PackageGenerator;
use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider {


    public function boot() {
        if($this->app->runningInConsole()) {
            $this->command([
                PackageGenerator::class,
            ]);
        }
    }

    public function register() {

    }
}