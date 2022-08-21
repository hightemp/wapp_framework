<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagCEProgressBar extends BaseTag
{
    public static $aDefaultAttrs = [
        "class" => "easyui-progressbar",
        "label" => "Progress bar:",
        "labelPosition" => "top",
        "style" => "width:100%"
    ];

    public function __invoke($aAttr=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttr, static::$aDefaultAttrs);
        
        static::fnPrint(static::fnRenderTag(static::T_DIV, false, $aAttrs));
    }
}