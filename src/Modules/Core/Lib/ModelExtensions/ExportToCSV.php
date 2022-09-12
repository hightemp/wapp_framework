<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\ModelExtensions;

trait TraitExportToCSV 
{
    static function fnExportToCSV()
    {
        $sT = static::$sTableName;
        ob_start();
        $this->oDBCon->csv("SELECT * FROM {$sT} ORDER BY id DESC");
        return ob_get_clean();
    }
}