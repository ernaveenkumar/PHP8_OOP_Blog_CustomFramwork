<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0853dd50922b44a725109c71a5f9dd27
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Core\\' => 5,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0853dd50922b44a725109c71a5f9dd27::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0853dd50922b44a725109c71a5f9dd27::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0853dd50922b44a725109c71a5f9dd27::$classMap;

        }, null, ClassLoader::class);
    }
}
