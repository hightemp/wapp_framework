<?php

namespace Hightemp\WappFramework\Modules\Debug;

use Hightemp\WappFramework\Modules\Core\Lib\BaseAliases;
use \Hightemp\WappFramework\Modules\Debug\Controllers\Index;

class Aliases extends BaseAliases
{
    public static $aMethods = [
        "debugpanel" => [Index::class, 'fnIndexHTML'],
        "debugpanel/index" => [Index::class, 'fnIndexHTML'],
        "debugpanel/modules/index" => [Index::class, 'fnModulesIndexHTML'],
        "debugpanel/controllers/index" => [Index::class, 'fnControllersIndexHTML'],
        "debugpanel/aliases/index" => [Index::class, 'fnAliasesIndexHTML'],
        "debugpanel/commands/index" => [Index::class, 'fnCommandsIndexHTML'],
        "debugpanel/generators/index" => [Index::class, 'fnGeneratorsIndexHTML'],
    ];
}