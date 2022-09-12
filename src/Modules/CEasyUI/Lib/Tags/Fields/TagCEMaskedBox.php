<?php

namespace Hightemp\WappFramework\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;

class TagCEMaskedBox extends BaseHTMLHelper
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