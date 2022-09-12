<?php

namespace Hightemp\WappFramework\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;

class TagCETextarea extends BaseHTMLHelper
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
        $aAttrs = static::fnPrepareAttrs($aAttr, static::$aDefaultAttrs);

        (new TagCETextBox())($aAttrs);
    }
}
