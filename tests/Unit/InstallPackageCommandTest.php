<?php

namespace AhmedShuaib\LPackage\Tests\Unit;

use AhmedShuaib\LPackage\Providers\PackageServiceProvider;
use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\File;

class InstallPackageCommandTest extends TestCase {


    protected function getPackageProviders($app)
    {
        return PackageServiceProvider::class;
    }

    /** @test */
    public function it_can_install_vue_js() {
        $name = "Blog";
        $packagePath = base_path('Blog');
        $this->artisan("make:package-install", [
            "framework" => 'vue',
            "--package" => $name
        ])
        ->assertExitCode(0);

        $this->assertTrue(file_exists($packagePath . '/package.json'));
        $this->assertTrue(is_dir($packagePath . '/node_modules/vue'));

        // Clean up the created package folder
        File::deleteDirectory($packagePath);
    }

}