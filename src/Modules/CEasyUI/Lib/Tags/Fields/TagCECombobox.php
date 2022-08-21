<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Tags\TagSelect;

class TagCECombobox extends BaseTag
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