<?php

namespace Hightemp\WappFramework\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;
use Hightemp\WappFramework\Modules\Core\Lib\Tags\TagSelect;

class TagCEButton extends BaseHTMLHelper
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