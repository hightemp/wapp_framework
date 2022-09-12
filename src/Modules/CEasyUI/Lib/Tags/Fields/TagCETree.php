<?php

namespace Hightemp\WappFramework\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;

class TagCETree extends BaseHTMLHelper
{
    public static $aDefaultAttrs = [
        "class" => "easyui-tree",
        "label" => "Tree:",
        "labelPosition" => "top",
        "style" => "width:100%;height:100%;",
        "data-options" => "fit:true",
    ];

    public static function fnRenderItem($sTitle, $aList=[])
    {
        $sHTML = "";
        if ($aList) {
            $aHTML = static::fnPrepareArray($aList);
            $sHTML = "<ul>".join("", $aHTML)."</ul>";
        }
        $sHTML = "<li><span>{$sTitle}</span>{$sHTML}</li>";

        return $sHTML;
    }

    public static function fnPrepareArray($aList)
    {
        $aHTML = [];

        foreach ($aList as $sK => $mV) {
            if (is_array($mV)) {
                if (is_array($mV[1])) {
                    // NOTE: $mV = [ '1001', 'Подпись для значения' ]
                    $aHTML[] = static::fnRenderItem($mV[0], $mV[1]);
                } else {
                    // NOTE: $mV = [ '1001', 'Подпись для значения' ]
                    $aHTML[] = static::fnRenderTag(static::T_LI, false, [ "value" => $mV[0] ], $mV[1]);
                }
            } else {
                // NOTE: $mV = 'Подпись для значения'
                $aHTML[] = static::fnRenderTag(static::T_LI, false, [ "value" => $sK ], $mV);
            }
        }

        return $aHTML;
    }

    public function __invoke($aList, $aAttr=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttr, static::$aDefaultAttrs);

        $aHTML = static::fnPrepareArray($aList);

        $sHTML = static::fnRenderTag(static::T_UL, false, $aAttrs, join("", $aHTML));

        static::fnPrint($sHTML);
    }
}