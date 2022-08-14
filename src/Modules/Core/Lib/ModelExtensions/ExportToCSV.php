<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\ModelExtensions;

use \RedBeanPHP\Facade as R;

trait TraitExportToCSV 
{
    static function fnExportToCSV()
    {
        $sT = static::$sTableName;
        ob_start();
        R::csv("SELECT * FROM {$sT} ORDER BY id DESC");
        return ob_get_clean();
    }
}