<?php

namespace Hightemp\WappTestSnotes\Modules\GoogleSheetsImporter\Controllers;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\CRUDController;
use Hightemp\WappTestSnotes\Modules\GoogleSheetsImporter\Models\Sheets;

class API extends CRUDController
{
    public static $sModelClass = Sheets::class;
}