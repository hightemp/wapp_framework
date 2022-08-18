<?php

namespace Hightemp\WappTestSnotes\Modules\Core;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseAliases;

class Aliases extends BaseAliases
{
    public static $aMethods = [
        "core/index" => [\Hightemp\WappTestSnotes\Modules\Core\Controllers\Index::class, 'fnIndexHTML'],
    ];
}