<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagA extends BaseTag
{
    public function __invoke($sContent, $sHref, $aAttrs=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttrs);
        $aAttrs['href'] = $sHref;
        static::fnPrint(static::fnRenderTag(static::T_A, false, $aAttrs, $sContent));
    }
}