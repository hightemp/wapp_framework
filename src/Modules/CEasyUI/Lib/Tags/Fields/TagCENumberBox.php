<?php

namespace Hightemp\WappFramework\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;

class TagCENumberBox extends BaseHTMLHelper
{
    public static $aDefaultAttrs = [
        "class" => "easyui-numberbox",
        "label" => "Number box:",
        "labelPosition" => "top",
        "precision" => "2",
        "style" => "width:100%"
    ];

    public function __invoke($aAttr=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttr, static::$aDefaultAttrs);
        
        static::fnPrint(static::fnRenderTag(static::T_INPUT, true, $aAttrs));
    }
}