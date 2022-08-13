<?php

namespace Hightemp\WappTestSnotes\Modules\CBootstrapTable;

use Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags\TagBootstrapTable;
use Hightemp\WappTestSnotes\Modules\Core\Lib\View as LibView;

class View extends LibView
{
    const TEMPLATES_PATH = __DIR__."/views";
    public static $sDefaultLayoutTemplate = "layout.php";
    public static $sDefaultContentTemplate = "table.php";

    public static function fnPrepareVars()
    {
        parent::fnPrepareVars();
        self::$aVars['oTagBootstrapTable'] = new TagBootstrapTable();
    }
}