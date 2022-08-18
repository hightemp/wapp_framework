<?php

namespace Hightemp\WappTestSnotes\Modules\GoogleSheetsImporter\Controllers;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\CRUDController;
use Hightemp\WappTestSnotes\Modules\GoogleSheetsImporter\Models\TestTable;

class API extends CRUDController
{
    public static $sModelClass = TestTable::class;
}