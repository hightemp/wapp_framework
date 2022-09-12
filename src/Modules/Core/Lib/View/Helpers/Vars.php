<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\View\Helpers;

class Vars
{
    public static $aVars = [];

    public static function fnCleanVars()
    {
        self::$aVars = [];
    }

    public static function fnAddVar($sName, $mValue)
    {
        static::$aVars[$sName] = $mValue;
    }

    public static function fnAddVars($aValues)
    {
        static::$aVars = array_replace_recursive(static::$aVars, $aValues);
    }

    public static function __callStatic($sName, $aArgs)
    {
        if ($aArgs) {
            static::$aVars[$sName](...$aArgs);
        } else {
            echo static::$aVars[$sName];
        }
    }
}