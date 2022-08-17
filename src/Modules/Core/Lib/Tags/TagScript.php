<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;
use Hightemp\WappTestSnotes\Modules\Core\Lib\View;

class TagScript extends BaseTag
{
    public function __invoke($sRelPath)
    {
        echo (View::$sCurrentViewClass)::fnRenderScript($sRelPath);
    }
}