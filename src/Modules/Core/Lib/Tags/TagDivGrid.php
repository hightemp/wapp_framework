<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagDivGrid extends BaseTag
{
    public static $aDefaultRowAttrs = [
        "class" => "row"
    ];

    public static $aDefaultColsAttrs = [
        "class" => "col"
    ];

    public function __invoke($aGrid, $aAttrs=[], $aRowsAttrs=[], $aColsAttrs=[])
    {
        static::fnPrepareAttrs($aAttrs, static::$aDefaultAttrs);
        static::fnPrepareAttrs($aRowsAttrs, static::$aDefaultRowAttrs);
        static::fnPrepareAttrs($aColsAttrs, static::$aDefaultColsAttrs);

        $sHTML = "";
        $aHTML = [];

        $aGrid = (array) $aGrid;

        foreach ($aGrid as $aRow) {
            $aRow = (array) $aRow;
            $aHTML = [];
            foreach ($aRow as $mCell) {
                if (is_string($mCell)) {
                    $aHTML[] = static::fnRenderTag(static::T_DIV, false, $aColsAttrs, $mCell);
                }
                if (is_array($mCell)) {
                    $sMethod = array_shift($mCell);
                    ob_start();
                    $sMethod(...$mCell);
                    $aHTML[] = static::fnRenderTag(static::T_DIV, false, $aColsAttrs, ob_get_clean());
                }
            }
            $sHTML .= static::fnRenderTag(static::T_DIV, false, $aRowsAttrs, join("", $aHTML));
        }

        static::fnPrint($sHTML);
    }
}