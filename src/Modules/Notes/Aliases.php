<?php

namespace Hightemp\WappTestSnotes\Modules\Notes;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseAliases;
use \Hightemp\WappTestSnotes\Modules\Notes\Controllers\Index;
use \Hightemp\WappTestSnotes\Modules\Notes\Controllers\API;

class Aliases extends BaseAliases
{
    public static $aMethods = [
        "notes/index" => [Index::class, 'fnIndexHTML'],
    ];

    public static $aAutoloadMethods = [
        API::class,
    ];
}