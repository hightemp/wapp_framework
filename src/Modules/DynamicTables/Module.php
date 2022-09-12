<?php

namespace Hightemp\WappFramework\Modules\DynamicTables;

use Hightemp\WappFramework\Modules\Core\Lib\BaseModule;

class Module extends BaseModule
{
    const NAME = "DynamicTables";

    public static $aModulesDependencies = [
        \Hightemp\WappFramework\Modules\CBootstrapTable\Module::class
    ];

    public static $aControllers = [
        \Hightemp\WappFramework\Modules\DynamicTables\Controllers\Index::class,
        \Hightemp\WappFramework\Modules\DynamicTables\Controllers\CRUD\StaticController::class,
        \Hightemp\WappFramework\Modules\DynamicTables\Controllers\CRUD\AjaxController::class,
    ];
}