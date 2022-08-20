<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagCESearchBox extends BaseTag
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