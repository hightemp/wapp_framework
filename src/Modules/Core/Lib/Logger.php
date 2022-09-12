<?php

namespace Hightemp\WappFramework\Modules\Core\Lib;

use Hightemp\WappFramework\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappFramework\Modules\Core\Lib\BaseLogger;
use Hightemp\WappFramework\Project;

class Logger 
{
    public static $oLoggerInstance = null;

    public static function fnGetInstance()
    {
        if (is_null(static::$oLoggerInstance)) {
            if (!Project::$sLoggerClass) {
                return;
            }
            static::$oLoggerInstance = Project::$sLoggerClass::fnBuild();
        }

        return static::$oLoggerInstance;
    }
    
    /**
     * fnGetInstanceIfExists
     *
     * @uses BaseLogger
     * 
     * @param  Callable $fnCallback - параметр BaseLogger
     * 
     * @return void
     */
    public static function fnGetInstanceIfExists($fnCallback)
    {
        $oInstance = static::fnGetInstance();
        if ($oInstance) {
            $fnCallback($oInstance);
        }
    }

    public static function fnWrite($sMessage, $aData=[])
    {
        static::fnGetInstanceIfExists(function($oLogger) use ($sMessage, $aData) {
            $oLogger->fnWrite($sMessage, $aData);
        });
    }
}