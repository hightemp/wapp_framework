<?php

namespace Hightemp\WappTestSnotes\Modules\Core;

class Commands 
{
    public static $aCommands = [
        \Hightemp\WappTestSnotes\Modules\Core\Commands\ListAliases::class,
        \Hightemp\WappTestSnotes\Modules\Core\Commands\ListAliasesLinks::class,
        \Hightemp\WappTestSnotes\Modules\Core\Commands\ListCommands::class,
    ];
}