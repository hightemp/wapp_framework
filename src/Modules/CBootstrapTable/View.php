<?php

namespace Hightemp\WappTestSnotes\Modules\CBootstrapTable;

use Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags\TagBootstrapTable;
use Hightemp\WappTestSnotes\Modules\Core\Lib\View as LibView;
use Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags\TagBootstrapTableFromEntity;
use Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags\TagBootstrapTableAJAX;
use Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags\TagBootstrapTableCRUD;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\CRUDController;

class View extends LibView
{    
    public static function fnPrepareVars()
    {
        parent::fnPrepareVars();
        self::$aVars['oTagBootstrapTable'] = new TagBootstrapTable();
        self::$aVars['oTagBootstrapTableFromEntity'] = new TagBootstrapTableFromEntity();
        self::$aVars['oTagBootstrapTableAJAX'] = new TagBootstrapTableAJAX();
        self::$aVars['oTagBootstrapTableCRUD'] = new TagBootstrapTableCRUD();
    }
}