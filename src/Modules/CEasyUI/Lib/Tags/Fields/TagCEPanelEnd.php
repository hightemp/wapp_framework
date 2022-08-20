<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagCEPanelEnd extends BaseTag
{
    public static $aDefaultAttrs = [
        "class" => "easyui-panel",
        "title" => "Panel",
        "style" => "width:100%; padding: 10px;"
    ];

    public function __invoke($aAttr=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttr, static::$aDefaultAttrs);
        $sHTML = ob_get_clean();
        static::fnPrint(static::fnRenderTag(static::T_DIV, false, $aAttrs, $sHTML));
    }
}