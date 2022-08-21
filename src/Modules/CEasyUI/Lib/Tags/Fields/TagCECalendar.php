<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagCECalendar extends BaseTag
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