<?php

namespace Hightemp\WappTestSnotes;

class Modules 
{
    public static $aModules = [
        \Hightemp\WappTestSnotes\Modules\Core\Module::class,
        \Hightemp\WappTestSnotes\Modules\Categories\Module::class,
    ];

    public static $aAliases = [
        \Hightemp\WappTestSnotes\Modules\Core\Aliases::class,
        \Hightemp\WappTestSnotes\Modules\Categories\Aliases::class,
    ];

    public static $aCommands = [
        \Hightemp\WappTestSnotes\Modules\Core\Commands::class,
        \Hightemp\WappTestSnotes\Modules\Categories\Commands::class,
    ];
}