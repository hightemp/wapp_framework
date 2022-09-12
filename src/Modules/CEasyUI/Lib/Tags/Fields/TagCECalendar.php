<?php

namespace Hightemp\WappFramework\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;

class TagCECalendar extends BaseHTMLHelper
{
    public static $aDefaultAttrs = [
        "class" => "easyui-calendar",
        "label" => "Calendar:",
        "labelPosition" => "top",
        "style" => "width:250px;height:250px;"
    ];

    public function __invoke($aAttr=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttr, static::$aDefaultAttrs);
        
        static::fnPrint(static::fnRenderTag(static::T_INPUT, true, $aAttrs));
    }
}