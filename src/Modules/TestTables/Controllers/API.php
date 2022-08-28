<?php

namespace Hightemp\WappTestSnotes\Modules\TestTables\Controllers;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\CRUDController;
use Hightemp\WappTestSnotes\Modules\TestTables\Models\TestTable;
use Hightemp\WappTestSnotes\Modules\TestTables\View;

class API extends CRUDController
{
    public static $sDefaultViewClass = View::class;
    public static $sModelClass = TestTable::class;
}