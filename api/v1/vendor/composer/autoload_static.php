<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit251396a14f96fa8e9d6192feaffc42dc
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'B' => 
        array (
            'Bramus' => 
            array (
                0 => __DIR__ . '/..' . '/bramus/router/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit251396a14f96fa8e9d6192feaffc42dc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit251396a14f96fa8e9d6192feaffc42dc::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit251396a14f96fa8e9d6192feaffc42dc::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
