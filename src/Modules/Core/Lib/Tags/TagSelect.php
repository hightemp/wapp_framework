<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Tags;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;

class TagSelect extends BaseHTMLHelper
{
    public static $aDefaultAttrs = [

    ];

    public function __invoke($aList, $aAttr=[])
    {
        $aHTML = [];
        $aAttrs = static::fnPrepareAttrs($aAttr, static::$aDefaultAttrs);

        foreach ($aList as $sK => $mV) {
            if (is_array($mV)) {
                // NOTE: $mV = [ '1001', 'Подпись для значения' ]
                $aHTML[] = static::fnRenderTag('option', false, [ "value" => $mV[0] ], $mV[1]);
            } else {
                // NOTE: $mV = 'Подпись для значения'
                $aHTML[] = static::fnRenderTag('option', false, [ "value" => $sK ], $mV);
            }
        }

        static::fnPrint(static::fnRenderTag(static::T_SELECT, false, $aAttrs, join("", $aHTML)));
    }
}