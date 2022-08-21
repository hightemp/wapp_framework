<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagCEDatalist extends BaseTag
{
    public static $aDefaultAttrs = [
        "class" => "easyui-datalist",
        "label" => "Datalist:",
        "labelPosition" => "top",
        "style" => "width:100%;height:250px"
    ];

    public function __invoke($aList, $aAttr=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttr, static::$aDefaultAttrs);

        $aHTML = [];

        foreach ($aList as $sK => $mV) {
            if (is_array($mV)) {
                // NOTE: $mV = [ '1001', 'Подпись для значения' ]
                $aHTML[] = static::fnRenderTag(static::T_LI, false, [ "value" => $mV[0] ], $mV[1]);
            } else {
                // NOTE: $mV = 'Подпись для значения'
                $aHTML[] = static::fnRenderTag(static::T_LI, false, [ "value" => $sK ], $mV);
            }
        }

        $sHTML = static::fnRenderTag(static::T_UL, false, $aAttrs, join("", $aHTML));

        static::fnPrint($sHTML);
    }
}