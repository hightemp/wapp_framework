<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagDiv extends BaseTag
{
    public function __invoke($sContent, $aAttrs=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttrs);
        static::fnPrint(static::fnRenderTag(static::T_DIV, false, $aAttrs, $sContent));
    }
}