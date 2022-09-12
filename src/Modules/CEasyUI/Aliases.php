<?php

namespace Hightemp\WappFramework\Modules\CEasyUI;

use Hightemp\WappFramework\Modules\Core\Lib\BaseAliases;
use \Hightemp\WappFramework\Modules\CEasyUI\Controllers\{
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