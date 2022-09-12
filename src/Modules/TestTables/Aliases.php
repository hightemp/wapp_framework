<?php

namespace Hightemp\WappFramework\Modules\TestTables;

use Hightemp\WappFramework\Modules\Core\Lib\BaseAliases;
use Hightemp\WappFramework\Modules\Core\Lib\Controllers\BaseController;
use \Hightemp\WappFramework\Modules\TestTables\Controllers\Index;
use \Hightemp\WappFramework\Modules\TestTables\Controllers\CRUD\StaticController;
use \Hightemp\WappFramework\Modules\TestTables\Controllers\CRUD\AjaxController;

class Aliases extends BaseAliases
{
    public static $aMethods = [
        "testtables" => [BaseController::CC_FORWARD_302, "testtables/index"],
        "testtables/" => [BaseController::CC_FORWARD_302, "testtables/index"],
        "testtables/index" => [Index::class, 'fnIndexHTML'],
        
        "testtables/add_random_record1" => [Index::class, 'fnGenerateRandomRecord1JSON'],
        "testtables/add_random_record2" => [Index::class, 'fnGenerateRandomRecord2JSON'],
        "testtables/add_random_record3" => [Index::class, 'fnGenerateRandomRecord3JSON'],

        "testtables/nuke" => [Index::class, 'fnNukeJSON'],
        "testtables/truncate" => [Index::class, 'fnTruncateTableJSON'],
    ];

    public static $aAutoloadMethods = [
        StaticController::class,
        AjaxController::class,
    ];
}