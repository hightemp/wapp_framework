<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Tags;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;

class TagInput extends BaseHTMLHelper
{
    public function __invoke($aAttrs=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttrs);
        static::fnPrint(static::fnRenderTag(static::T_INPUT, true, $aAttrs));
    }
}