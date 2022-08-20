<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagCEMaskedBox extends BaseTag
{
    public static $aDefaultAttrs = [
        "class" => "easyui-maskedbox",
        "label" => "Masked box:",
        "labelPosition" => "top",
        "mask" => "999",
        "style" => "width:100%"
    ];

    public function __invoke($aAttr=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttr, static::$aDefaultAttrs);
        $aAttrs = static::fnPrepareAttrs($aAttr, self::$aDefaultAttrs);
        
        static::fnPrint(static::fnRenderTag(static::T_INPUT, true, $aAttrs));
    }
}