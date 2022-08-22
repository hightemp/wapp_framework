<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseAliases;
use \Hightemp\WappTestSnotes\Modules\CEasyUI\Controllers\{
    Index,
    Demo,
};

class Aliases extends BaseAliases
{
    public static $aMethods = [
        "ceasyui/index" => [Index::class, 'fnIndexHTML'],
        "ceasyui/demo01" => [Demo::class, 'fnDemo1HTML'],
        "ceasyui/demo02" => [Demo::class, 'fnDemo2HTML'],
    ];
}