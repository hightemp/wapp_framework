<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Tags;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;
use Hightemp\WappFramework\Modules\Core\Lib\View;

class TagScript extends BaseHTMLHelper
{
    public function __invoke($sRelPath)
    {
        static::fnPrint((View::$sCurrentViewClass)::fnRenderScript($sRelPath));
    }
}