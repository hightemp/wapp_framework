<?php

namespace Hightemp\WappFramework\Modules\Debug;

use Hightemp\WappFramework\Modules\Core\Lib\BaseAliases;
use \Hightemp\WappFramework\Modules\Debug\Controllers\Index;

class Aliases extends BaseAliases
{
    const BASE_ALIAS = "debugpanel";
    const BASE_ALIAS_MODULES = self::BASE_ALIAS."/modules/index";
    const BASE_ALIAS_CONTROLLERS = self::BASE_ALIAS."/controllers/index";
    const BASE_ALIAS_ALIASES = self::BASE_ALIAS."/aliases/index";
    const BASE_ALIAS_COMMANDS = self::BASE_ALIAS."/commands/index";
    const BASE_ALIAS_GENERATORS = self::BASE_ALIAS."/generators/index";

    public static $aMethods = [
        self::BASE_ALIAS => [Index::class, 'fnIndexHTML'],
        self::BASE_ALIAS_MODULES => [Index::class, 'fnModulesIndexHTML'],
        self::BASE_ALIAS_CONTROLLERS => [Index::class, 'fnControllersIndexHTML'],
        self::BASE_ALIAS_ALIASES => [Index::class, 'fnAliasesIndexHTML'],
        self::BASE_ALIAS_COMMANDS => [Index::class, 'fnCommandsIndexHTML'],
        self::BASE_ALIAS_GENERATORS => [Index::class, 'fnGeneratorsIndexHTML'],
    ];
}