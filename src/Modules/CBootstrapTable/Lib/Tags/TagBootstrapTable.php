<?php

namespace Hightemp\WappTestSnotes\Modules\CBootstrapTable\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Tags\TagTable;

class TagBootstrapTable extends BaseTag
{
    public function __invoke($aData, $aHeaders, $aAttr=[])
    {
        $oTag = new TagTable();
        $aAttr['class'] ?: $aAttr['class'] = '';
        $aAttr['class'] .= ' ';

        $aAttr['data-toggle'] = "table";
        $aAttr['data-height'] ?: $aAttr['data-height'] = "100%";

        $aAttr['data-show-refresh'] ="true";
        $aAttr['data-show-toggle'] ="true";
        $aAttr['data-show-columns'] ="true";
        $aAttr['data-show-fullscreen'] ="true";

        $aAttr['data-search'] = "true";
        $aAttr['data-show-search-button'] = "true";
        $aAttr['data-url'] ="https://examples.wenzhixin.net.cn/examples/bootstrap_table/data";
        $aAttr['data-pagination'] = "true";
        $aAttr['data-side-pagination'] = "server";

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