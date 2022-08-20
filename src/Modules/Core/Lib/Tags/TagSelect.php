<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagSelect extends BaseTag
{
    public function __invoke($aList, $aAttrs=[])
    {
        $sHTML = "";
        $aAttrs = static::fnPrepareAttrs($aAttrs);

        foreach ($aList as $sK => $mV) {
            if (is_array($mV)) {
                // NOTE: $mV = [ '1001', 'Подпись для значения' ]
                $sHTML .= static::fnRenderTag('option', false, [ "value" => $mV[0] ], $mV[1]);
            } else {
                // NOTE: $mV = 'Подпись для значения'
                $sHTML .= static::fnRenderTag('option', false, [ "value" => $sK ], $mV);
            }
        }

        static::fnPrint(static::fnRenderTag('select', false, $aAttrs, $sHTML));
    }
}