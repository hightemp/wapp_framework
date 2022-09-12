<?php

namespace Hightemp\WappFramework\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;
use Hightemp\WappFramework\Modules\Core\Lib\Tags\TagTable;

class TagCEPropertygrid extends BaseHTMLHelper
{
    public static $aDefaultAttrs = [
        "class" => "easyui-propertygrid",
        "label" => "Propertygrid",
        "labelPosition" => "top",
        "style" => "width:100%;height:100%",
        "data-options" => "showGroup:true,scrollbarSize:0"
    ];

    public function __invoke($aData=[], $aHeaders=[], $aAttr=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttr, static::$aDefaultAttrs);

        (new TagTable())($aData, $aHeaders, $aAttrs);
    }
}