<?php

namespace Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Tags\TagTable;

class TagBootstrapTable extends BaseTag
{
    public function __invoke($aData, $aHeaders, $aAttr=[])
    {
        $oTag = new TagTable();
        $aAttr['class'] ?? $aAttr['class'] = '';
        $aAttr['class'] .= ' ';

        $aAttr['data-toggle'] = "table";
        $aAttr['data-height'] ?? $aAttr['data-height'] = "460";
        $aAttr['data-show-columns'] = "true";

        $oTag($aData, $aHeaders, $aAttr);
    }
}