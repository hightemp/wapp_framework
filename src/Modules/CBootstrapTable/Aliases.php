<?php

namespace Hightemp\WappTestSnotes\Modules\CBootstrapTable;

use \Hightemp\WappTestSnotes\Modules\CBootstrapTable\Controllers\Demo;
use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseAliases;

class Aliases extends BaseAliases
{
    public static $aMethods = [
        "demo_table_01" => [Demo::class, 'fnDemoTable01HTML', 'demo_table_01.php'],
        "demo_table_02" => [Demo::class, 'fnDemoTable02HTML', 'demo_table_02.php'],
        "demo_table_03" => [Demo::class, 'fnDemoTable03HTML', 'demo_table_03.php'],
        "demo_table_04" => [Demo::class, 'fnDemoTable04HTML', 'demo_table_04.php'],
    ];
}