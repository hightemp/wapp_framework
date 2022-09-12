<?php

namespace Hightemp\WappFramework\Modules\CEasyUI;

use Hightemp\WappFramework\Modules\Core\Lib\BaseModule;

class Module extends BaseModule
{
    const NAME = "CEasyUI";

    public static $sDefaultController = \Hightemp\WappFramework\Modules\CEasyUI\Controllers\Index::class;
    public static $sDefaultMethod = "fnIndexHTML";

    public static $aControllers = [
        \Hightemp\WappFramework\Modules\CEasyUI\Controllers\Index::class
    ];

    public static $aModels = [
        
    ];

    public static $aPreloadViews = [
        \Hightemp\WappFramework\Modules\CEasyUI\View::class,
    ];
}