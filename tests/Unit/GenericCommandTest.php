<?php

namespace AhmedShuaib\LPackage\Tests\Unit;

use AhmedShuaib\LPackage\Providers\PackageServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class GenericCommandTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return PackageServiceProvider::class;
    }

    public function testMakeGeneratePackage() {

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
        $this->assertTrue(File::exists("{$basePath}/src/Providers/{$packageName}ServiceProvider.php"));
        // Add more assertions for other generated files and folders

        // Clean up the generated package files
        // File::deleteDirectory($basePath);
    }

    public function testMakeControllerInPackage()
    {
        $basePath = base_path('Blog/src/Http/Controllers');
        $this->artisan('make:package-controller', [
            'name' => 'TestController',
            '--package' => 'Blog',
        ])->assertExitCode(0);

        $this->assertTrue(File::exists(base_path('Blog/src/Http/Controllers/TestController.php')));
    }

    public function testMakeModelInPackage() {

        $basePath = base_path('Blog/src/Models');
        $this->artisan('make:package-model', [
            'name' => 'TestModel',
            '--package' => 'Blog',
        ])->assertExitCode(0);

        $this->assertTrue(File::exists(base_path('Blog/src/Models/TestModel.php')));

    }

    public function testDeleteDir() {
        $filesystem = new Filesystem();
        $basePath = base_path('Blog/src');
        $filesystem->deleteDirectory($basePath);
        $filesystem->deleteDirectory(base_path("Blog"));
        $this->assertTrue(!is_dir('Blog'));
    }

}
