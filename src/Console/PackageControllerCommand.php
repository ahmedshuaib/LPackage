<?php 

namespace AhmedShuaib\LPackage\Console;

use AhmedShuaib\LPackage\Package;
use Illuminate\Routing\Console\ControllerMakeCommand;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Str;

class PackageControllerCommand extends ControllerMakeCommand {


    protected $name = 'make:package-controller';

    protected function getDefaultNamespace($rootNamespace)
    {
        $package = $this->option('package');
        if ($package) {

            $pn = Package::getPackageName($package);

            $package = $pn ? $pn : $package;

            $rootNamespace = $rootNamespace . '\\'. $package . '\\Http\\Controllers';

            $rootNamespace = str_replace('App\\', '', $rootNamespace);
                        
            return $rootNamespace;
        }
        return parent::getDefaultNamespace($rootNamespace);
    }

    protected function getOptions()
    {
        return array_merge(parent::getOptions(), [
            ['package', 'P', InputOption::VALUE_OPTIONAL, 'The name of the package'],
        ]);
    }

    protected function getPath($name)
    {
        $name = str_replace($this->rootNamespace(), '', $name);

        $package = $this->option('package');

        if($package) {

            $rootNamespace = Package::getPackageName($package);

            if($rootNamespace) {
                $name = str_replace($rootNamespace, $package . '\src', $name);
            }

            $path = str_replace('\\', '/', $name).'.php';

            return base_path($path);
        }

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
    }

    protected function qualifyClass($name)
    {
        $name = ltrim($name, '\\/');

        $name = str_replace('/', '\\', $name);

        $rootNamespace = $this->rootNamespace();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        $package = $this->option('package');

        if($package) {
            return $this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name;
        }
        
        return $this->qualifyClass(
            $this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name
        );
    }
}