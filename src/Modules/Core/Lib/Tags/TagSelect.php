<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagSelect extends BaseTag
{
    public function __invoke($aList, $aAttr=[])
    {
        $sHTML = "";
        $sAttr = static::fnPrepareAttr($aAttr);
        foreach ($aList as $sK => $mV) {
            if (is_array($mV)) {
                $sHTML = "<option value=\"{$mV[0]}\">{$mV[1]}</option>";
            } else {
                $sHTML = "<option value=\"{$sK}\">{$mV}</option>";
            }
        }

        $sHTML = "<select {$sAttr}>{$sHTML}</select>";
        echo $sHTML;
    }
}