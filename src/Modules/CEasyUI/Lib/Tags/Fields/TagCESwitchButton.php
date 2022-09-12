<?php

namespace Hightemp\WappFramework\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;

class TagCESwitchButton extends BaseHTMLHelper
{
    public static $aDefaultAttrs = [
        "class" => "easyui-switchbutton",
    ];

    public function __invoke($aAttr=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttr, static::$aDefaultAttrs);
        
        static::fnPrint(static::fnRenderTag(static::T_INPUT, true, $aAttrs));
    }
}