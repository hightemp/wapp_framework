<?php

namespace Hightemp\WappFramework\Modules\CBootstrapTable\Lib\Tags\HTML;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;
use Hightemp\WappFramework\Modules\Core\Lib\Tags\TagTable;

class BootstrapTable extends BaseHTMLHelper
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