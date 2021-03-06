<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8eb20660d6350fe0871eea88be0a55d2
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfonic\\Builder\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfonic\\Builder\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8eb20660d6350fe0871eea88be0a55d2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8eb20660d6350fe0871eea88be0a55d2::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit8eb20660d6350fe0871eea88be0a55d2::$classMap;

        }, null, ClassLoader::class);
    }
}
