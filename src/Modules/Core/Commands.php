<?php

namespace Hightemp\WappTestSnotes\Modules\Core;

class Commands 
{
    public static $aCommands = [
        \Hightemp\WappTestSnotes\Modules\Core\Commands\Generate::class,
        \Hightemp\WappTestSnotes\Modules\Core\Commands\ListAliases::class,
        \Hightemp\WappTestSnotes\Modules\Core\Commands\ListAliasesLinks::class,
        \Hightemp\WappTestSnotes\Modules\Core\Commands\ListCommands::class,
        \Hightemp\WappTestSnotes\Modules\Core\Commands\ListGenerators::class,
        \Hightemp\WappTestSnotes\Modules\Core\Commands\ListTemplateVars::class,
    ];
}