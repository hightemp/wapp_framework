<?php

namespace Hightemp\WappTestSnotes\Modules\GoogleSheetsImporter;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseAliases;
use \Hightemp\WappTestSnotes\Modules\GoogleSheetsImporter\Controllers\Index;
use \Hightemp\WappTestSnotes\Modules\GoogleSheetsImporter\Controllers\API;

class Aliases extends BaseAliases
{
    public static $aMethods = [
        "testtables/index" => [Index::class, 'fnIndexHTML'],
        "testtables/add_random_record" => [Index::class, 'fnGenerateRandomRecordJSON'],
        "testtables/truncate" => [Index::class, 'fnTruncateTableJSON'],
    ];

    public static $aAutoloadMethods = [
        API::class,
    ];
}