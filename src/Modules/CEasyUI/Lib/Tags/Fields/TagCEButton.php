<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Tags\TagSelect;

class TagCEButton extends BaseTag
{
    public static $aDefaultAttrs = [
        "class" => "easyui-linkbutton",
        "href" => "#",
        // "label" => "Button:",
        // "labelPosition" => "top",
        // "data-options" => "iconCls:'icon-add'",
    ];

    public function __invoke($sTitle, $aAttr=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttr, static::$aDefaultAttrs);

        static::fnPrint(static::fnRenderTag(static::T_A, false, $aAttrs, $sTitle));
    }
}