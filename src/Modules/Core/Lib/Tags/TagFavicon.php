<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Tags;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;
use Hightemp\WappFramework\Modules\Core\Lib\View;

class TagFavicon extends BaseHTMLHelper
{
    public function __invoke($sRelPath, $sType="png")
    {
        static::fnPrint((View::$sCurrentViewClass)::fnRenderLinkFavicon($sRelPath, $sType));
    }
}