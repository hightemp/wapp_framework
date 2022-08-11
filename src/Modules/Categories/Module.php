<?php

namespace Hightemp\WappTestSnotes\Modules\Categories;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Module as LibModule;

class Module extends LibModule
{
    const NAME = "Categories";

    public static $aControllers = [
        \Hightemp\WappTestSnotes\Modules\Categories\Controllers\Index::class
    ];
}