<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagCESlider extends BaseTag
{
    public static $aDefaultAttrs = [
        "class" => "easyui-slider",
        "label" => "Slider:",
        "labelPosition" => "top",
        "style" => "width:100%;showTip:true"
    ];

    public function __invoke($aAttr=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttr, static::$aDefaultAttrs);
        
        static::fnPrint(static::fnRenderTag(static::T_INPUT, true, $aAttrs));
    }
}