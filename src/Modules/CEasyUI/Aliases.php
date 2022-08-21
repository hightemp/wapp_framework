<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseAliases;
use \Hightemp\WappTestSnotes\Modules\CEasyUI\Controllers\{
    Index,
    Demo01,
};

class Aliases extends BaseAliases
{
    public static $aMethods = [
        "ceasyui/index" => [Index::class, 'fnIndexHTML'],
        "ceasyui/demo01" => [Demo01::class, 'fnIndexHTML'],
    ];
}