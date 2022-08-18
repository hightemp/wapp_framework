<?php

namespace Hightemp\WappTestSnotes\Modules\GoogleSheetsImporter;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Module as LibModule;

class Module extends LibModule
{
    const NAME = "TestTable";

    public static $aModulesDependencies = [
        \Hightemp\WappTestSnotes\Modules\CBootstrapTable\Module::class
    ];

    public static $aControllers = [
        \Hightemp\WappTestSnotes\Modules\GoogleSheetsImporter\Controllers\Index::class
    ];

    public static $aModules = [
        \Hightemp\WappTestSnotes\Modules\GoogleSheetsImporter\Models\TestTable::class,
    ];

    public static $aPreloadViews = [
        \Hightemp\WappTestSnotes\Modules\Notes\View::class,
        \Hightemp\WappTestSnotes\Modules\CBootstrapTable\View::class,
        \Hightemp\WappTestSnotes\Modules\GoogleSheetsImporter\View::class,
    ];
}