<?php

namespace Hightemp\WappFramework\Modules\DynamicTables;

use Hightemp\WappFramework\Modules\Core\Lib\BaseAliases;
use \Hightemp\WappFramework\Modules\DynamicTables\Controllers\Index;
use \Hightemp\WappFramework\Modules\DynamicTables\Controllers\API;

class Aliases extends BaseAliases
{
    public static $aMethods = [
        "notes/index" => [Index::class, 'fnIndexHTML'],
    ];

    public static $aAutoloadMethods = [
        API::class,
    ];
}