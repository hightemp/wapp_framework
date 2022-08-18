<?php

namespace Hightemp\WappTestSnotes\Modules\GoogleSheetsImporter;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseAliases;
use \Hightemp\WappTestSnotes\Modules\GoogleSheetsImporter\Controllers\Index;
use \Hightemp\WappTestSnotes\Modules\GoogleSheetsImporter\Controllers\API;

class Aliases extends BaseAliases
{
    public static $aMethods = [
        "googlesheetsimporter/index" => [Index::class, 'fnIndexHTML'],
    ];

    public static $aAutoloadMethods = [
        API::class,
    ];
}