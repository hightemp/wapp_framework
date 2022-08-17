<?php

namespace Hightemp\WappTestSnotes\Modules\Core;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Module as LibModule;

class Module extends LibModule
{
    const NAME = "Core";

    public static $sDefaultController = \Hightemp\WappTestSnotes\Modules\Core\Controllers\Index::class;
    public static $sDefaultMethod = "fnIndexHTML";

    public static $aControllers = [
        \Hightemp\WappTestSnotes\Modules\Core\Controllers\Index::class
    ];

    public static $aModels = [
        
    ];
}