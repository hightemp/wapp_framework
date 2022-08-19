<?php

namespace Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Tags\TagTable;

class TagBootstrapTable extends BaseTag
{
    public function __invoke($aData, $aHeaders=[], $aAttr=[])
    {
        $oTag = new TagTable();
        isset($aAttr['class']) ?: $aAttr['class'] = '';
        $aAttr['class'] .= ' ';

        $aAttr['data-toggle'] = "table";
        isset($aAttr['data-height']) ?: $aAttr['data-height'] = "800px"; // "100%";

        if (isset($aAttr['data-click-to-select'])) {
            array_unshift($aHeaders, [
                '',
                [
                    "data-field" => "state",
                    "data-checkbox" => "true",
                ]
            ]);
        }

        $oTag($aData, $aHeaders, $aAttr);
    }
}