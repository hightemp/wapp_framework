<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;
use \Hightemp\WappTestSnotes\Modules\Core\Lib\Link;

class TagAliasA extends BaseTag
{
    public function __invoke($sContent, $sAlias, $aArgs=[], $aAttr=[])
    {
        $sURL = Link::fnGetAliasLink($sAlias, $aArgs);
        (new TagA)($sContent, $sURL, $aAttr);
    }
}