<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Tags;

use \Hightemp\WappTestSnotes\Modules\Core\Lib\Link;

class TagAliasA
{
    public function __invoke($sContent, $sAlias, $aParams=[], $sTitle="", $sClass="", $sName="", $sID="")
    {
        $sURL = Link::fnGetAliasLink($sAlias, $aParams);
        (new TagA)($sContent, $sURL);
    }
}