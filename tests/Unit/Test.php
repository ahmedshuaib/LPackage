<?php

namespace LPackage\Tests\Unit;

use Orchestra\Testbench\TestCase;
use AhmedShuaib\LPackage\Providers\PackageServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class Test extends TestCase {

    protected function getPackageProviders($app) {
        return PackageServiceProvider::class;
    }
    
    /** @test */
    public function create_package_test() {
        $packageName = 'Blog';
        $basePath = base_path($packageName);

        // Clean up any previous test files
        if (File::exists($basePath)) {
            File::deleteDirectory($basePath);
        }

        // Run the command
        Artisan::call('package:generate', ['name' => $packageName]);

        // Assert that the package files were created
        $this->assertTrue(File::exists($basePath));
        $this->assertTrue(File::exists("{$basePath}/src/Providers/{$packageName}ServiceProvider.php"));
        // Add more assertions for other generated files and folders

        // Clean up the generated package files
        File::deleteDirectory($basePath);
    }

}