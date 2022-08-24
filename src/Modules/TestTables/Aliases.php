<?php

namespace Hightemp\WappTestSnotes\Modules\TestTables;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseAliases;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\BaseController;
use \Hightemp\WappTestSnotes\Modules\TestTables\Controllers\Index;
use \Hightemp\WappTestSnotes\Modules\TestTables\Controllers\API;

class Aliases extends BaseAliases
{
    public static $aMethods = [
        "testtables" => [BaseController::CC_FORWARD_302, "testtables/index"],
        "testtables/" => [BaseController::CC_FORWARD_302, "testtables/index"],
        "testtables/index" => [Index::class, 'fnIndexHTML'],
        
        "testtables/tables/ajax_table" => [Index::class, 'fnAjaxTableHTML', 'tables/ajax_table.php'],
        "testtables/tables/crud_table" => [Index::class, 'fnCrudTableHTML', 'tables/crud_table.php'],

        "testtables/add_random_record1" => [Index::class, 'fnGenerateRandomRecord1JSON'],
        "testtables/add_random_record2" => [Index::class, 'fnGenerateRandomRecord2JSON'],
        "testtables/add_random_record3" => [Index::class, 'fnGenerateRandomRecord3JSON'],

        "testtables/nuke" => [Index::class, 'fnNukeJSON'],
        "testtables/truncate" => [Index::class, 'fnTruncateTableJSON'],
    ];

    public static $aAutoloadMethods = [
        API::class,
    ];
}