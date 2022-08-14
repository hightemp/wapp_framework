<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

class BaseAliases
{
    public static $aMethods = [
    ];

    public static $aAutoloadMethods = [
    ];

    public static function fnPrepareAliases()
    {
        $aResult = static::$aMethods;

        foreach (static::$aAutoloadMethods as $sClass) {
            $aAliases = $sClass::fnGenerateAliases();
            $aResult = array_merge($aResult, $aAliases);
        }

        return $aResult;
    }
}