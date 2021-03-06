<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit82bc5a2c73d0dc6c23ff1dc5bd13ed7e
{
    public static $files = array (
        '60d8f7e3a596462f9586cc5ceb74306d' => __DIR__ . '/../..' . '/src/lib/simple_html_dom.php',
    );

    public static $prefixLengthsPsr4 = array (
        'K' =>
        array (
            'Konimbo\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Konimbo\\' =>
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Konimbo\\CategoryArchive' => __DIR__ . '/../..' . '/src/category_archive.php',
        'Konimbo\\KonimboWebsite' => __DIR__ . '/../..' . '/src/konimbo_website.class.php',
        'Konimbo\\Product' => __DIR__ . '/../..' . '/src/product.class.php',
        'Konimbo\\Utils' => __DIR__ . '/../..' . '/src/utils.class.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit82bc5a2c73d0dc6c23ff1dc5bd13ed7e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit82bc5a2c73d0dc6c23ff1dc5bd13ed7e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit82bc5a2c73d0dc6c23ff1dc5bd13ed7e::$classMap;

        }, null, ClassLoader::class);
    }
}
