<?php

namespace Hightemp\WappFramework\Modules\TestTables\Controllers\CRUD;

use Hightemp\WappFramework\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappFramework\Modules\Core\Lib\Controllers\CRUD\BaseAjaxController;
use Hightemp\WappFramework\Modules\TestTables\Models\TestTable;
use Hightemp\WappFramework\Modules\TestTables\View;

class AjaxController extends BaseAjaxController
{
    public static $sDefaultViewClass = View::class;
    public static $sModelClass = TestTable::class;
}