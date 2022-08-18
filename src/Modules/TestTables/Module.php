<?php

namespace Hightemp\WappTestSnotes\Modules\TestTables;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Module as LibModule;

class Module extends LibModule
{
    const NAME = "TestTable";

    public static $aModulesDependencies = [
        \Hightemp\WappTestSnotes\Modules\CBootstrapTable\Module::class
    ];

    public static $aControllers = [
        \Hightemp\WappTestSnotes\Modules\TestTables\Controllers\Index::class
    ];

    public static $aModules = [
        \Hightemp\WappTestSnotes\Modules\TestTables\Models\TestTable::class,
    ];
}