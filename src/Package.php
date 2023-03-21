<?php

namespace AhmedShuaib\LPackage;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Console\Command;


class Package {

    
    public static function getPackageName($package) {

        if (File::exists(base_path("{$package}/composer.json"))) {
            $composer = json_decode(File::get(base_path("{$package}/composer.json")), true);
            if (isset($composer['autoload']['psr-4'])) {
                foreach ($composer['autoload']['psr-4'] as $namespace => $path) {
                    if (str_ends_with($path, 'src/')) {
                        return rtrim($namespace, '\\');
                    }
                }
            }
        }

        return false;
    }

    public static function qualifyClass($name, $rootNamespace, $commandInstance) {

        $name = ltrim($name, '\\/');

        $name = str_replace('/', '\\', $name);

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        $package = $commandInstance->option('package');
        
        if ($package) {
            return $commandInstance->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name;
        }
        
        return $this->qualifyClass(
            static::getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name,
            $rootNamespace,
            $commandInstance
        );

    }

}