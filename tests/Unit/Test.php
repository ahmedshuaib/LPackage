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
        Artisan::call('make:package', ['name' => $packageName]);

        // Assert that the package files were created
        $this->assertTrue(File::exists($basePath));
        $this->assertTrue(File::exists("{$basePath}/src/Providers/EventServiceProvider.php"));
        $this->assertTrue(File::exists("{$basePath}/src/Providers/{$packageName}ServiceProvider.php"));
        $this->assertTrue(File::exists("{$basePath}/src/Models/Example.php"));
        $this->assertTrue(File::exists("{$basePath}/src/resources/views/welcome.blade.php"));
        $this->assertTrue(File::exists("{$basePath}/src/routes/web.php"));
        $this->assertTrue(File::exists("{$basePath}/src/routes/api.php"));
        $this->assertTrue(File::exists("{$basePath}/src/config/lpackage.php"));
        $this->assertTrue(File::exists("{$basePath}/src/Controllers/ExampleController.php"));
        $this->assertTrue(File::exists("{$basePath}/src/Exceptions/ExampleException.php"));
        $this->assertTrue(File::exists("{$basePath}/src/Middleware/ExampleMiddleware.php"));
        // Add more assertions for other generated files and folders

        // Clean up the generated package files
        File::deleteDirectory($basePath);
    }

}