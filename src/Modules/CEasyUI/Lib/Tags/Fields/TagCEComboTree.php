<?php

namespace Hightemp\WappFramework\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;
use Hightemp\WappFramework\Modules\Core\Lib\Tags\TagSelect;

class TagCEComboTree extends BaseHTMLHelper
{
    public static $aDefaultAttrs = [
        "class" => "easyui-combotree",
        "label" => "Combo tree:",
        "labelPosition" => "top",
        "style" => "width:100%",
        // "data-options" => "url:'about:blank',method:'get'",
    ];

    public function __invoke($aAttr=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttr, static::$aDefaultAttrs);

        static::fnPrint(static::fnRenderTag(static::T_INPUT, true, $aAttrs));
    }
}