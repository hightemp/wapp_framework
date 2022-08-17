<?php

namespace Hightemp\WappTestSnotes\Modules\TestTables;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseAliases;
use \Hightemp\WappTestSnotes\Modules\TestTables\Controllers\Index;
use \Hightemp\WappTestSnotes\Modules\TestTables\Controllers\API;

class Aliases extends BaseAliases
{
    public static $aMethods = [
        "test_table_index" => [Index::class, 'fnIndexHTML'],
    ];

    public static $aAutoloadMethods = [
        API::class,
    ];
}