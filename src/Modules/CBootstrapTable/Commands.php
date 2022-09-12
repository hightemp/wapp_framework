<?php

namespace Hightemp\WappFramework\Modules\CBootstrapTable;

use Hightemp\WappFramework\Modules\Core\Lib\BaseCommands;

class Commands extends BaseCommands 
{
    public static $aCommands = [
        \Hightemp\WappFramework\Modules\CBootstrapTable\Commands\GenerateTableTemplate::class,
    ];
}