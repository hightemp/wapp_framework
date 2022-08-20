<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagA extends BaseTag
{
    public function __invoke($sContent, $sHref, $aAttrs=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttrs);
        $aAttrs['href'] = $sHref;
        static::fnPrint(fnRenderTag('a', false, $aAttrs, $sContent));
    }
}