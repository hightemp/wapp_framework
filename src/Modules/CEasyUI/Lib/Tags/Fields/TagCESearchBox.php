<?php

namespace Hightemp\WappFramework\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;

class TagCESearchBox extends BaseHTMLHelper
{
    public static $aDefaultAttrs = [
        "class" => "easyui-searchbox",
        "label" => "Search box:",
        "labelPosition" => "top",
        "style" => "width:100%",
        // "data-options" => "prompt:'Please Input Value',searcher:fnSearch"
    ];

    public function __invoke($aAttr=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttr, static::$aDefaultAttrs);

        static::fnPrint(static::fnRenderTag(static::T_INPUT, true, $aAttrs));
    }
}