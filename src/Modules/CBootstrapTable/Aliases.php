<?php

namespace Hightemp\WappTestSnotes\Modules\CBootstrapTable;

use \Hightemp\WappTestSnotes\Modules\CBootstrapTable\Controllers\Demo;
use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseAliases;

class Aliases extends BaseAliases
{
    public static $aMethods = [
        "cbootstraptable/01" => [Demo::class, 'fnDemoTable01HTML', 'demo_table_01.php'],
        "cbootstraptable/02" => [Demo::class, 'fnDemoTable02HTML', 'demo_table_02.php'],
        "cbootstraptable/03" => [Demo::class, 'fnDemoTable03HTML', 'demo_table_03.php'],
        "cbootstraptable/04" => [Demo::class, 'fnDemoTable04HTML', 'demo_table_04.php'],
    ];
}