<?php

namespace Hightemp\WappTestSnotes\Modules\Notes;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Module as LibModule;

class Module extends LibModule
{
    const NAME = "Notes";

    public static $aControllers = [
        \Hightemp\WappTestSnotes\Modules\Notes\Controllers\Index::class
    ];
}