<?php

namespace Hightemp\WappTestSnotes;

class Project 
{
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
        \Hightemp\WappTestSnotes\Modules\Core\Generators::class,
    ];

    public static $aControllers = [
        Hightemp\WappTestSnotes\Modules\Core\Controllers\Index::class,
        Hightemp\WappTestSnotes\Modules\Notes\Controllers\Index::class,
    ];
}