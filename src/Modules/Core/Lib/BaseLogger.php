<?php

namespace Hightemp\WappFramework\Modules\Core\Lib;

use Hightemp\WappFramework\Modules\Core\Lib\Config;
use Hightemp\WappFramework\Modules\Core\Lib\Controllers\BaseController;

class BaseLogger
{
    public static $oInstance = null;

    public static function fnBuild()
    {
        return (static::$oInstance = new static());
    }

    public function fnUpdateHeader($aData)
    {
    }

    public function fnWrite($sMessage, $aData=[])
    {
    }

    public function fnRemoveOld()
    {
    }

    public function fnClean()
    {
    }
}