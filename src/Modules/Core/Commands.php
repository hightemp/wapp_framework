<?php

namespace Hightemp\WappFramework\Modules\Core;

use Hightemp\WappFramework\Modules\Core\Lib\BaseCommands;

// NOTE: Core - Список комманд
class Commands extends BaseCommands
{
    public static $aCommands = [
        \Hightemp\WappFramework\Modules\Core\Commands\Generate::class,
        \Hightemp\WappFramework\Modules\Core\Commands\ListAliases::class,
        \Hightemp\WappFramework\Modules\Core\Commands\ListAliasesLinks::class,
        \Hightemp\WappFramework\Modules\Core\Commands\ListCommands::class,
        \Hightemp\WappFramework\Modules\Core\Commands\ListControllers::class,
        \Hightemp\WappFramework\Modules\Core\Commands\ListControllersMethods::class,
        \Hightemp\WappFramework\Modules\Core\Commands\ListGenerators::class,
        \Hightemp\WappFramework\Modules\Core\Commands\ListTemplateVars::class,
        \Hightemp\WappFramework\Modules\Core\Commands\ListModels::class,
        \Hightemp\WappFramework\Modules\Core\Commands\ListModules::class,
        \Hightemp\WappFramework\Modules\Core\Commands\GetModuleInfo::class,
    ];
}