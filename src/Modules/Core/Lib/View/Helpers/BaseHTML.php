<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\View\Helpers;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;

/**
 */
class BaseHTML
{
    public static $aVars = [];
    public static $sCalledClass = "";
    public static $sNamespace = '';

    public static $bReturnBuffered = false;

    public static function __callStatic($sName, $aArgs)
    {
        static::$sCalledClass = get_called_class();
        if (!isset(static::$aVars[$sName])) {
            static::$aVars[$sName] = new (static::$sNamespace.$sName)();
        }

        $sResult = "";

        if (static::$bReturnBuffered) {
            static::fnBeginBuffer();
        }
        static::$aVars[$sName](...$aArgs);
        if (static::$bReturnBuffered) {
            $sResult = static::fnEndBuffer(true);
        }
        return $sResult;
    }

    public static function fnBeginBuffer()
    {
        BaseHTMLHelper::fnBeginBuffer();
    }

    public static function fnEndBuffer($bJoin=false)
    {
        return BaseHTMLHelper::fnEndBuffer($bJoin);
    }
}