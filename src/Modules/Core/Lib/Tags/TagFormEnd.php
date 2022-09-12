<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Tags;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;

class TagFormEnd extends BaseHTMLHelper
{
    public static $aDefaultAttrs = [
        "class" => "",
        "style" => "",
        "action" => "",
        "method" => "post"
    ];

    public function __invoke($aAttrs=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttrs, static::$aDefaultAttrs);
        $sHTML = ob_get_clean();
        static::fnPrint(static::fnRenderTag(static::T_FORM, false, $aAttrs, $sHTML));
    }
}