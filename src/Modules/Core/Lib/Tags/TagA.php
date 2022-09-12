<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Tags;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;

class TagA extends BaseHTMLHelper
{
    public function __invoke($sContent, $sHref, $aAttrs=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttrs);
        $aAttrs['href'] = $sHref;
        static::fnPrint(static::fnRenderTag(static::T_A, false, $aAttrs, $sContent));
    }
}