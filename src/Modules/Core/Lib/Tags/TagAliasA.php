<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Tags;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;
use \Hightemp\WappFramework\Modules\Core\Lib\Link;

class TagAliasA extends BaseHTMLHelper
{
    public function __invoke($sContent, $sAlias, $aArgs=[], $aAttr=[])
    {
        $sURL = Link::fnGetAliasLink($sAlias, $aArgs);
        (new TagA)($sContent, $sURL, $aAttr);
    }
}