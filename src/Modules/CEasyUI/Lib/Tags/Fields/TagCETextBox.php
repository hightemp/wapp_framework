<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagCETextBox extends BaseTag
{
    public static $aDefaultAttrs = [
        "class" => "easyui-textbox",
        "label" => "TextBox:",
        "labelPosition" => "top",
        "style" => "width:100%"
    ];

    public function __invoke($aAttr=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttr, static::$aDefaultAttrs);
        
        static::fnPrint(static::fnRenderTag(static::T_INPUT, true, $aAttrs));
    }
}