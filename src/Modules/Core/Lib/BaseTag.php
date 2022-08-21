<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

class BaseTag
{
    const T_A = 'a';
    const T_DIV = 'div';
    const T_UL = 'ul';
    const T_LI = 'li';
    const T_INPUT = 'input';
    const T_SELECT = 'select';
    const T_FORM = 'from';
    const T_SCRIPT = 'script';
    const T_LINK = 'link';

    public static $aDefaultAttrs = [];
    public static $aAttrs = [];

    /** @var bool $bBufferOutput влиет на работу метода fnPrint */
    public static $bBufferOutput = false;
    public static $aBuffer = [];
    public static $sCurrentName = "";

    function fnSetValue($mValue)
    {
        $this->aAttrs["value"] = $mValue;
    }

    function fnGetValue($mValue)
    {
        return $this->aAttrs["value"];
    }

    public static function fnCleanBuffer()
    {
        static::$aBuffer = [];
    }

    public static function fnBeginBuffer($sName)
    {
        static::$bBufferOutput = true;
        static::$aBuffer[$sName] = [];
        static::$sCurrentName = $sName;
    }

    public static function fnEndBuffer($sName)
    {
        $aOutput = static::$aBuffer[$sName];
        unset(static::$aBuffer[$sName]);
        static::$sCurrentName = "";
        if (!count(static::$aBuffer)) {
            static::$bBufferOutput = false;
        }
        return $aOutput;
    }

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
        if (static::$bBufferOutput) {
            static::$aBuffer[static::$sCurrentName][] = $sHTML;
        } else {
            echo $sHTML;
        }
    }
}