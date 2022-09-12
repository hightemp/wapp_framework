<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Tags;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;

class TagDiv extends BaseHTMLHelper
{
    public function __invoke($sContent, $aAttrs=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttrs);
        static::fnPrint(static::fnRenderTag(static::T_DIV, false, $aAttrs, $sContent));
    }
}