<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Tags;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;

class TagUl extends BaseHTMLHelper
{
    public static $aDefaultAttrs = [
        "class" => ""
    ];

    public static $aDefaultLiAttrs = [
        "class" => ""
    ];

    public function __invoke($aList, $aAttrs=[], $aLiAttrs=[])
    {
        static::fnPrepareAttrs($aAttrs, static::$aDefaultAttrs);
        static::fnPrepareAttrs($aLiAttrs, static::$aDefaultLiAttrs);

        $sHTML = "";
        $aHTML = [];

        $aList = (array) $aList;

        foreach ($aList as $mRow) {
            if (is_string($mRow)) {
                $aHTML[] = static::fnRenderTag(static::T_LI, false, $aLiAttrs, $mRow);
            }
            if (is_array($mRow)) {
                if (is_string($mRow)) {
                    $aHTML[] = static::fnRenderTag(static::T_LI, false, $aLiAttrs, $mRow);
                } else if (is_array($mRow)) {
                    if (is_object($mRow[0])) {
                        $sMethod = array_shift($mRow);
                        ob_start();
                        $sMethod(...$mRow);
                        $aHTML[] = static::fnRenderTag(static::T_LI, false, $aLiAttrs, ob_get_clean());
                    }
                }
            }
        }

        $sHTML = static::fnRenderTag(static::T_UL, false, $aAttrs, join("", $aHTML));

        static::fnPrint($sHTML);
    }
}