<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Tags;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;

class TagDivGrid extends BaseHTMLHelper
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
                    if (is_string($mCell[0])) {
                        $aHTML[] = static::fnRenderTag(static::T_DIV, false, $aColsAttrs, $mCell[0]);
                    } else if (is_array($mCell[0])) {
                        if (is_string($mCell[0][0])) {
                            $aHTML[] = static::fnRenderTag(static::T_DIV, false, $aColsAttrs, $mCell[0][0]);
                        } else if (is_object($mCell[0][0])) {
                            $sMethod = array_shift($mCell[0]);
                            ob_start();
                            $sMethod(...$mCell[0]);
                            $aHTML[] = static::fnRenderTag(static::T_DIV, false, $aColsAttrs, ob_get_clean());
                        } else if (is_array($mCell[0][0])) {
                            foreach ($mCell[0] as $mInnerCell) {
                                if (is_string($mInnerCell)) {
                                    $aHTML[] = static::fnRenderTag(static::T_DIV, false, $aColsAttrs, $mInnerCell);
                                } else if (is_array($mInnerCell)) {
                                    $sMethod = array_shift($mInnerCell);
                                    ob_start();
                                    $sMethod(...$mInnerCell);
                                    $aHTML[] = static::fnRenderTag(static::T_DIV, false, $aColsAttrs, ob_get_clean());
                                }
                            }
                        }
                    } else if (is_object($mCell[0])) {
                        $sMethod = array_shift($mCell);
                        ob_start();
                        $sMethod(...$mCell);
                        $aHTML[] = static::fnRenderTag(static::T_DIV, false, $aColsAttrs, ob_get_clean());
                    }
                }
            }
            $sHTML .= static::fnRenderTag(static::T_DIV, false, $aRowsAttrs, join("", $aHTML));
        }

        static::fnPrint($sHTML);
    }
}