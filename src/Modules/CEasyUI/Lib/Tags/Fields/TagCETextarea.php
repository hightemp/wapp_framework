<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagCETextarea extends BaseTag
{
    public static $aDefaultAttrs = [
        "class" => "easyui-textbox",
        "label" => "Text multiline:",
        "labelPosition" => "top",
        "style" => "width:100%; height: 300px",
        "data-options" => "multiline:true"
    ];

    public function __invoke($aAttr=[])
    {
        (new TagCETextBox())($aAttr, static::$aDefaultAttrs);
    }
}
