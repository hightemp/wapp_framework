<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

class BaseTag
{
    public static function fnPrepareAttr($aAttr)
    {
        $sResult = "";

        foreach ($aAttr as $sK => $sV) {
            $sV = addslashes($sV);
            $sResult .= "$sK=\"$sV\" ";
        }

        return $sResult;
    }
}