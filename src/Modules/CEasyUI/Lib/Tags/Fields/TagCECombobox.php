<?php

namespace Hightemp\WappFramework\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;
use Hightemp\WappFramework\Modules\Core\Lib\Tags\TagSelect;

class TagCECombobox extends BaseHTMLHelper
{
    public static $aDefaultAttrs = [
        "class" => "easyui-combobox",
        "label" => "Select:",
        "labelPosition" => "top",
        "style" => "width:100%"
    ];

    public function __invoke($aList, $aAttr=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttr, static::$aDefaultAttrs);

        (new TagSelect())($aList, $aAttrs);
    }
}