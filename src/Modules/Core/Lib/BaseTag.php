<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

class BaseTag
{
    public static function &fnPrepareAttrs(&$aAttr, $aDefault=[])
    {
        foreach ($aDefault as $sK => $sV) {
            isset($aAttr[$sK]) ?: $aAttr[$sK] = $sV;
        }

        return $aAttr;
    }

    public static function fnPrepareAttrString($aAttr, $aDefault=[])
    {
        $sResult = "";
        $aAttr = (array) $aAttr;

        if ($aDefault) {
            static::fnPrepareAttrs($aAttr, $aDefault);
        }

        foreach ($aAttr as $sK => $sV) {
            $sV = addslashes($sV);
            $sResult .= "$sK=\"$sV\" \n";
        }

        return "\n".$sResult;
    }

    public static function fnRenderTag($sTagName, $bSingle=false, $aAttrs=[], $sContent="")
    {
        $sAttr = static::fnPrepareAttrString($aAttrs);
        $sHTML = "<".$sTagName." ".$sAttr;
        if ($bSingle) {
            $sHTML .= "/>";
        } else {
            $sHTML .= ">".$sContent."</".$sTagName.">";
        }
        return $sHTML;
    }

    public static function fnPrint($sHTML)
    {
        echo $sHTML;
    }
}