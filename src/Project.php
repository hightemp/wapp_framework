<?php

namespace Hightemp\WappTestSnotes;

class Project 
{
    public static $sProjectClassPath = __NAMESPACE__;

    public static $sDefaultCommand = \Hightemp\WappTestSnotes\Modules\Core\Commands\ListCommands::class;

    public static $aModules = [
        \Hightemp\WappTestSnotes\Modules\Core\Module::class,
        \Hightemp\WappTestSnotes\Modules\Notes\Module::class,
        \Hightemp\WappTestSnotes\Modules\CBootstrapTable\Module::class,
    ];

    public static $aAliases = [
        \Hightemp\WappTestSnotes\Modules\Core\Aliases::class,
        \Hightemp\WappTestSnotes\Modules\Notes\Aliases::class,
    ];

    public static $aCommands = [
        \Hightemp\WappTestSnotes\Modules\Core\Commands::class,
        \Hightemp\WappTestSnotes\Modules\Notes\Commands::class,
    ];

    public static $aGenerators = [
        \Hightemp\WappTestSnotes\Modules\Core\Generators\Compgen::class,
        \Hightemp\WappTestSnotes\Modules\Core\Generators\Command::class,
        \Hightemp\WappTestSnotes\Modules\Core\Generators\OpenAPI::class,
    ];

    public static $aControllers = [
        Hightemp\WappTestSnotes\Modules\Core\Controllers\Index::class,
        Hightemp\WappTestSnotes\Modules\Notes\Controllers\Index::class,
    ];

    public static $aPreloadViews = [
        \Hightemp\WappTestSnotes\Modules\Core\View::class,
        \Hightemp\WappTestSnotes\Modules\Notes\View::class,
        \Hightemp\WappTestSnotes\Modules\CBootstrapTable\View::class,
    ];
}