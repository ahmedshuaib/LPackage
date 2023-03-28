<?php

namespace AhmedShuaib\LPackage\Console;

use AhmedShuaib\LPackage\Package;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

class InstallPackageCommand extends Command {


    protected $signature = 'make:package-install {framework : The framework to be installed} {--package= : The package name where the framework will be installed}';
    protected $description = 'Install and configure Vue.js, React.js, or Nuxt.js for a package';


    public function handle() {
        $framework = $this->argument('framework');
        $packageName = $this->option('package');


        // Check if the framework is supported
        if ($framework !== 'vue') {
            $this->error("Unsupported framework '{$framework}'. Only 'vue' is supported at this time.");
            return 1;
        }

        if(!$packageName) {
            $this->error("Please provide the package name with the '--package' option");
            return 1;
        }

        $this->InstallFramework($framework, $packageName);
    }

    protected function InstallFramework($framework, $packageName) {
        switch($framework) {
            case 'vue':
                $this->installVue($packageName);
                break;
            default:
                $this->error("Unsupported framework '{$framework}'.");
                break;
        }
    }

    protected function installVue($packageName) {

        $path = base_path($packageName);

        if(!File::isDirectory($path))
            File::makeDirectory($path);

        $commands = [
            "npm init -y",
            "npm install --save vue"
        ];

        foreach($commands as $command) {

            $this->line("Executing: {$command}");

            $process = new Process(explode(' ', $command));
            $process->setWorkingDirectory($path);
            $process->setTimeout(3600);

            $process->run(function($type, $buffer) {
                if(Process::ERR === $type) {
                    $this->error($buffer);
                }
                else {
                    $this->line($buffer);
                }
            });

            if(!$process->isSuccessful()) {
                $this->error("An error occurred while executing the command: {$command}");
                return;
            }
        }

        $this->info("Vue.js has been successfully installed into the {$packageName}");
    }
}