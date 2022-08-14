<?php

namespace Hightemp\WappTestSnotes\Modules\Notes\Controllers;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\CRUDController;
use Hightemp\WappTestSnotes\Modules\Notes\Models\Notes;

class API extends CRUDController
{
    public static $sModelClass = Notes::class;
}