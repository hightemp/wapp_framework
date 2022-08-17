<?php

namespace Hightemp\WappTestSnotes\Modules\CBootstrapTable;

use Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags\TagBootstrapTable;
use Hightemp\WappTestSnotes\Modules\Core\Lib\View as LibView;
use Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags\TagBootstrapTableFromEntity;
use Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags\TagBootstrapTableAJAX;

class View extends LibView
{
    const TEMPLATES_PATH = __DIR__."/views";
    
    public static $sDefaultLayoutTemplate = "layout.php";

    public static function fnPrepareVars()
    {
        parent::fnPrepareVars();
        self::$aVars['oTagBootstrapTable'] = new TagBootstrapTable();
        self::$aVars['oTagBootstrapTableFromEntity'] = new TagBootstrapTableFromEntity();
        self::$aVars['oTagBootstrapTableAJAX'] = new TagBootstrapTableAJAX();
    }
}