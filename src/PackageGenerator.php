<?php

namespace AhmedShuaib\LPackage;

use Illuminate\Console\Command;

class PackageGenerator extends Command
{
    protected $signature = 'package:generate {name : The name of the package}';
    protected $description = 'Generate a new Laravel package';

    public function handle()
    {
        $packageName = $this->argument('name');
        $packagePath = base_path("packages/{$packageName}");

        $this->info("Creating package {$packageName}...");
        $this->createPackageDirectory($packagePath);
        $this->copyFiles($packagePath);
        $this->updateComposer($packageName);

        $this->info("Package {$packageName} created successfully!");
    }

    protected function createPackageDirectory($path)
    {
        if (is_dir($path)) {
            $this->error("Package directory {$path} already exists!");
            exit();
        }

        mkdir($path);
        mkdir("{$path}/src");
        mkdir("{$path}/tests");
    }

    protected function copyFiles($path)
    {
        copy(__DIR__ . '/stubs/composer.json', "{$path}/composer.json");
        copy(__DIR__ . '/stubs/package.php', "{$path}/src/Package.php");
        copy(__DIR__ . '/stubs/readme.md', "{$path}/README.md");
        copy(__DIR__ . '/stubs/phpunit.xml', "{$path}/phpunit.xml");
        copy(__DIR__ . '/stubs/gitignore', "{$path}/.gitignore");
    }

    protected function updateComposer($packageName)
    {
        $composerPath = base_path('composer.json');

        $composer = json_decode(file_get_contents($composerPath), true);
        $composer['autoload']['psr-4']["{$packageName}\\"] = "packages/{$packageName}/src";

        file_put_contents($composerPath, json_encode($composer, JSON_PRETTY_PRINT));
    }
}
