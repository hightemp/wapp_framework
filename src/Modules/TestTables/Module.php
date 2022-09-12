<?php

namespace Hightemp\WappFramework\Modules\TestTables;

use Hightemp\WappFramework\Modules\Core\Lib\BaseModule;

class Module extends BaseModule
{
    const NAME = "TestTable";

    public static $aModulesDependencies = [
        \Hightemp\WappFramework\Modules\CBootstrapTable\Module::class
    ];

    public static $aControllers = [
        \Hightemp\WappFramework\Modules\TestTables\Controllers\Index::class,
        \Hightemp\WappFramework\Modules\TestTables\Controllers\StaticController::class,
        \Hightemp\WappFramework\Modules\TestTables\Controllers\AjaxController::class,
    ];

    public static $aModules = [
        \Hightemp\WappFramework\Modules\TestTables\Models\TestTable::class,
    ];

    public static $aPreloadViews = [
        \Hightemp\WappFramework\Modules\Core\View::class,
        \Hightemp\WappFramework\Modules\Bootstrap\View::class,
        \Hightemp\WappFramework\Modules\CBootstrapTable\View::class,
        \Hightemp\WappFramework\Modules\TestTables\View::class,
    ];
}