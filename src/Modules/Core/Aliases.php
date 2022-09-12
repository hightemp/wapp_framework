<?php

namespace Hightemp\WappFramework\Modules\Core;

use Hightemp\WappFramework\Modules\Core\Lib\BaseAliases;

class Aliases extends BaseAliases
{
    public static $aMethods = [
        "core/index" => [\Hightemp\WappFramework\Modules\Core\Controllers\Index::class, 'fnIndexHTML'],
    ];
}