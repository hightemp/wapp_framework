<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Module as LibModule;

class Module extends LibModule
{
    const NAME = "CEasyUI";

    public static $sDefaultController = \Hightemp\WappTestSnotes\Modules\CEasyUI\Controllers\Index::class;
    public static $sDefaultMethod = "fnIndexHTML";

    public static $aControllers = [
        \Hightemp\WappTestSnotes\Modules\CEasyUI\Controllers\Index::class
    ];

    public static $aModels = [
        
    ];

    public static $aPreloadViews = [
        \Hightemp\WappTestSnotes\Modules\CEasyUI\View::class,
    ];
}