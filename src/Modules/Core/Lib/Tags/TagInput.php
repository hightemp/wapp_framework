<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagInput extends BaseTag
{
    public function __invoke($aAttrs=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttrs);
        static::fnPrint(static::fnRenderTag(static::T_INPUT, true, $aAttrs));
    }
}