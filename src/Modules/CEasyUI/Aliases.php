<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseAliases;

class Aliases extends BaseAliases
{
    public static $aMethods = [
        "ceasyui/index" => [\Hightemp\WappTestSnotes\Modules\CEasyUI\Controllers\Index::class, 'fnIndexHTML'],
        "ceasyui/demo01" => [\Hightemp\WappTestSnotes\Modules\CEasyUI\Controllers\Demo01::class, 'fnIndexHTML', 'pages/demo1.php'],
    ];
}