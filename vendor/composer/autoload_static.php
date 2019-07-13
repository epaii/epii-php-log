<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbae3818d4de79e19cee2c2edd57da6fe
{
    public static $prefixLengthsPsr4 = array (
        'e' => 
        array (
            'epii\\log\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'epii\\log\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbae3818d4de79e19cee2c2edd57da6fe::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbae3818d4de79e19cee2c2edd57da6fe::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}