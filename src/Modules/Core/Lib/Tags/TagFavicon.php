<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;
use Hightemp\WappTestSnotes\Modules\Core\Lib\View;

class TagFavicon extends BaseTag
{
    public function __invoke($sRelPath, $sType="png")
    {
        echo (View::$sCurrentViewClass)::fnRenderLinkFavicon($sRelPath, $sType);
    }
}