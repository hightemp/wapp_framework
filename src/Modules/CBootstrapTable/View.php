<?php

namespace Hightemp\WappTestSnotes\Modules\CBootstrapTable;

use Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags\TagBootstrapTable;
use Hightemp\WappTestSnotes\Modules\Core\Lib\View as LibView;
use Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags\TagBootstrapTableFromEntity;
use Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags\TagBootstrapTableAJAX;

class View extends LibView
{
    const STATIC_PATH = "src/Modules/CBootstrapTable/static";
    const STATIC_CSS_PATH = self::STATIC_PATH."/css";
    const STATIC_JS_PATH = self::STATIC_PATH."/js";

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