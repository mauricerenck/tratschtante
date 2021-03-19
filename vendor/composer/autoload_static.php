<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb07387e0b7fb107646032d477053c460
{
    public static $prefixLengthsPsr4 = array (
        'm' => 
        array (
            'mauricerenck\\Tratschtante\\' => 26,
        ),
        'K' => 
        array (
            'Kirby\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'mauricerenck\\Tratschtante\\' => 
        array (
            0 => __DIR__ . '/../..' . '/utils',
        ),
        'Kirby\\' => 
        array (
            0 => __DIR__ . '/..' . '/getkirby/composer-installer/src',
        ),
    );

    public static $classMap = array (
        'Kirby\\ComposerInstaller\\CmsInstaller' => __DIR__ . '/..' . '/getkirby/composer-installer/src/ComposerInstaller/CmsInstaller.php',
        'Kirby\\ComposerInstaller\\Installer' => __DIR__ . '/..' . '/getkirby/composer-installer/src/ComposerInstaller/Installer.php',
        'Kirby\\ComposerInstaller\\Plugin' => __DIR__ . '/..' . '/getkirby/composer-installer/src/ComposerInstaller/Plugin.php',
        'Kirby\\ComposerInstaller\\PluginInstaller' => __DIR__ . '/..' . '/getkirby/composer-installer/src/ComposerInstaller/PluginInstaller.php',
        'mauricerenck\\Traschtante\\HookHelper' => __DIR__ . '/../..' . '/utils/hookHelper.php',
        'mauricerenck\\Traschtante\\WebmentionReceiver' => __DIR__ . '/../..' . '/utils/receiver.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb07387e0b7fb107646032d477053c460::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb07387e0b7fb107646032d477053c460::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb07387e0b7fb107646032d477053c460::$classMap;

        }, null, ClassLoader::class);
    }
}
