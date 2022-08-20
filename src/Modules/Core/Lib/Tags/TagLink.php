<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;
use Hightemp\WappTestSnotes\Modules\Core\Lib\View;

class TagLink extends BaseTag
{
    public function __invoke($sRelPath)
    {
        static::fnPrint((View::$sCurrentViewClass)::fnRenderLinkStylesheet($sRelPath));
    }
}