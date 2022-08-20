<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagFormEnd extends BaseTag
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
        static::fnPrint(static::fnRenderTag('form', false, $aAttrs, $sHTML));
    }
}