<?php

namespace Hightemp\WappFramework\Modules\Core;

use Hightemp\WappFramework\Modules\Core\Lib\BaseModule;

class Module extends BaseModule
{
    const NAME = "Core";

    public static $sDefaultController = \Hightemp\WappFramework\Modules\Core\Controllers\Index::class;
    public static $sDefaultMethod = "fnIndexHTML";

    public static $aControllers = [
        \Hightemp\WappFramework\Modules\Core\Controllers\Index::class
    ];

    public static $aModels = [
        
    ];
}