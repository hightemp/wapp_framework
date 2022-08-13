<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagA extends BaseTag
{
    public function __invoke($sContent, $sHref, $aAttr=[])
    {
        $sAttr = static::fnPrepareAttr($aAttr);
        echo "<a href=\"{$sHref}\" {$sAttr}>{$sContent}</a>";
    }
}