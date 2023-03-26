<?php 

namespace AhmedShuaib\LPackage\Tests\Unit;

use AhmedShuaib\LPackage\Providers\PackageServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase;

class MigrationCommandTest extends TestCase {

    protected function getPackageProviders($app)
    {
        return PackageServiceProvider::class;
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('filesystems.default', 'test');
        $app['config']->set('filesystems.disks.test', [
            'driver' => 'local',
            'root' => __DIR__.'/temp',
        ]);    
    }

    public function test_package_migration_file_creation()
    {
        $packageName = 'Blog';
        $migrationName = 'create_test_table';
        $path = base_path("{$packageName}/src/migrations");

        // Ensure the migration directory is clean before the test.
        if (File::exists($path)) {
            File::deleteDirectory($path);
        }

        // Call the make:package-migration command.
        Artisan::call('make:package-migration', [
            'name' => $migrationName,
            '--package' => $packageName,
            '--create' => 'test',
        ]);

        // Assert the migration file is created at the expected path.
        $migrationFiles = File::allFiles($path);
        $this->assertCount(1, $migrationFiles);
        $this->assertStringContainsString($migrationName, $migrationFiles[0]->getFilename());
    }

    public function tearDown(): void
    {
        // Clean up the migration directory after the test.
        $packageName = 'Blog';
        $path = base_path("{$packageName}/src/migrations");
        if (File::exists($path)) {
            File::deleteDirectory($path);
        }

        File::deleteDirectory(base_path("Blog"));
        $this->assertTrue(!is_dir('Blog'));

        parent::tearDown();
    }
}