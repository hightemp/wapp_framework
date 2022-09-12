<?php

namespace Hightemp\WappFramework\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;

class TagCETimespinner extends BaseHTMLHelper
{
    public static $aDefaultAttrs = [
        "class" => "easyui-timespinner",
        "label" => "Time spinner:",
        "labelPosition" => "top",
        "value" => "01:20",
        "style" => "width:100%"
    ];

    public function __invoke($aAttr=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttr, static::$aDefaultAttrs);
        
        static::fnPrint(static::fnRenderTag(static::T_INPUT, true, $aAttrs));
    }
}