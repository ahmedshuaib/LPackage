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


}