<?php

namespace AhmedShuaib\LPackage\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class PackageGenerator extends Command
{
    protected $signature = 'make:package {name}';
    protected $description = 'Generate all necessary files and folders for package development';

    public function handle()
    {
        $packageName = $this->argument('name');
        $path = base_path($packageName);

        if (File::exists($path)) {
            $this->error("Directory '{$packageName}' already exists!");
            return;
        }

        // Create directories
        File::makeDirectory($path, 0755, true);
        File::makeDirectory("{$path}/src", 0755, true);
        File::makeDirectory("{$path}/src/Controllers", 0755, true);
        File::makeDirectory("{$path}/src/Models", 0755, true);
        File::makeDirectory("{$path}/src/Providers", 0755, true);
        File::makeDirectory("{$path}/src/Events", 0755, true);
        File::makeDirectory("{$path}/src/Middleware", 0755, true);
        File::makeDirectory("{$path}/src/Exceptions", 0755, true);
        File::makeDirectory("{$path}/src/config", 0755, true);
        File::makeDirectory("{$path}/src/database/migrations", 0755, true);
        File::makeDirectory("{$path}/src/resources/views", 0755, true);
        File::makeDirectory("{$path}/src/routes", 0755, true);




        // Create files
        File::put("{$path}/src/Providers/{$packageName}ServiceProvider.php", $this->generateServiceProviderContent($packageName));

        File::put("{$path}/src/Controllers/ExampleController.php", $this->generateControllerContent($packageName));
        File::put("{$path}/src/Models/Example.php", $this->generateModelContent($packageName));
        File::put("{$path}/src/Providers/EventServiceProvider.php", $this->generateEventServiceProviderContent($packageName));
        File::put("{$path}/src/Events/ExampleEvent.php", $this->generateEventContent($packageName));
        File::put("{$path}/src/Middleware/ExampleMiddleware.php", $this->generateMiddlewareContent($packageName));
        File::put("{$path}/src/Exceptions/ExampleException.php", $this->generateExceptionContent($packageName));
        File::put("{$path}/src/config/lpackage.php", $this->generateConfigContent());
        File::put("{$path}/src/database/migrations/create_lpackage_table.php", $this->generateMigrationContexnt());
        File::put("{$path}/src/resources/views/welcome.blade.php", $this->generateViewContent());
        File::put("{$path}/src/routes/web.php", $this->generateWebRoutesContent($packageName));
        File::put("{$path}/src/routes/api.php", $this->generateApiRoutesContent($packageName));

        File::put("{$path}/composer.json", $this->generateComposerContent($packageName));
        File::put("{$path}/.gitignore", "/vendor/\n/.idea/\n");

        $this->info("Package '{$packageName}' generated successfully!");

        return true;
    }

    private function generateServiceProviderContent(string $packageName)
    {
        return <<<EOT
        <?php

        namespace {$packageName};

        use Illuminate\Support\ServiceProvider;

        class {$packageName}ServiceProvider extends ServiceProvider
        {
            public function boot()
            {
                // Add your package's boot logic here
            }

            public function register()
            {
                // Add your package's register logic here
            }
        }
        EOT;
    }

    private function generateComposerContent(string $packageName)
    {
        return <<<EOT
        {
            "name": "vendor_name/{$packageName}",
            "description": "A Laravel package to create a directory with all necessary files for package development.",
            "type": "library",
            "license": "MIT",
            "authors": [
                {
                    "name": "Your Name",
                    "email": "your_email@example.com"
                }
            ],
            "require": {
                "php": "^7.3 || ^8.0",
                "illuminate/support": "^8.0 || ^9.0"
            },
            "autoload": {
                "psr-4": {
                    "VendorName\\\\{$packageName}\\\\": "src/"
                }
            },
            "extra": {
                "laravel": {
                    "providers": [
                        "VendorName\\\\{$packageName}\\\\Providers\\\\{$packageName}ServiceProvider"
                    ]
                }
            }
        }
        EOT;
    }


    private function generateControllerContent($package) {
        $stub = file_get_contents(base_path('vendor/laravel/framework/src/Illuminate/Routing/Console/stubs/controller.stub'));
        $stub = str_replace('{{ namespace }}', $package, $stub);
        $stub = str_replace('{{ class }}', $package, $stub);
        $stub = str_replace('use {{ rootNamespace }}Http\Controllers\Controller;', 'use Illuminate\Routing\Controller;', $stub);
        return $stub;
    }

    private function generateModelContent($package) {
        $stub = file_get_contents(base_path('vendor/laravel/framework/src/Illuminate/Foundation/Console/stubs/model.stub'));
        $stub = str_replace('{{ namespace }}', $package, $stub);
        $stub = str_replace('{{ class }}', $package, $stub);
        return $stub;
    }

    private function generateEventServiceProviderContent($package) {
        $stub = file_get_contents(base_path('vendor/laravel/framework/src/Illuminate/Foundation/Console/stubs/provider.stub'));
        $stub = str_replace('{{ namespace }}', $package, $stub);
        $stub = str_replace('{{ class }}', $package, $stub);
        return $stub;
    }

    private function generateEventContent($package) {
        $stub = file_get_contents(base_path('vendor/laravel/framework/src/Illuminate/Foundation/Console/stubs/event.stub'));
        $stub = str_replace('{{ namespace }}', $package, $stub);
        $stub = str_replace('{{ class }}', $package, $stub);
        return $stub;
    }

    private function generateMiddlewareContent($package) {
        $stub = file_get_contents(base_path('vendor/laravel/framework/src/Illuminate/Routing/Console/stubs/middleware.stub'));
        $stub = str_replace('{{ namespace }}', $package, $stub);
        $stub = str_replace('{{ class }}', $package, $stub);
        return $stub;
    }

    private function generateExceptionContent($package) {
        $stub = file_get_contents(base_path('vendor/laravel/framework/src/Illuminate/Foundation/Console/stubs/exception.stub'));
        $stub = str_replace('{{ namespace }}', $package, $stub);
        $stub = str_replace('{{ class }}', $package, $stub);
        return $stub;
    }

    private function generateConfigContent() {
        return <<<EOT
        <?php

        return [
            'option' => env('LPACKAGE_OPTION', 'default_value'),
        ];
        EOT;
    }

    private function generateMigrationContexnt() {
        $stub = file_get_contents(base_path('vendor/laravel/framework/src/Illuminate/Foundation/Console/stubs/exception.stub'));
        return $stub;
    }

    private function generateViewContent() {
        $stub = file_get_contents(base_path('vendor/laravel/framework/src/Illuminate/Auth/Console/stubs/make/views/layouts/app.stub'));
        return $stub;
    }

    private function generateWebRoutesContent($package) {
        return <<<EOT
        <?php

        use Illuminate\Support\Facades\Route;
        use {$package}\Controllers\ExampleController;

        Route::group(['middleware' => 'web'], function () {
            Route::get('{$package}', [ExampleController::class, 'index']);
        });
        EOT;
    }

    private function generateApiRoutesContent($package) {
        return <<<EOT
        <?php

        use Illuminate\Support\Facades\Route;
        use {$package}\Controllers\ExampleController;

        Route::group(['middleware' => ['api']], function () {
            Route::get('{$package}/example', [ExampleController::class, 'index']);
        });
        EOT;
    }
}
