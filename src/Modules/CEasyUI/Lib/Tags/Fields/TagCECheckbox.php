<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Tags\TagSelect;

class TagCECheckbox extends BaseTag
{
    public static $aDefaultAttrs = [
        "class" => "easyui-checkbox",
        "label" => "Checkbox:",
        "labelPosition" => "top",
        "style" => "",
        "value" => "1"
    ];

    function fnSetValue($mValue)
    {
        if ($mValue) $this->aAttrs["checked"] = "true";
    }

    function fnGetValue($mValue)
    {
        return isset($this->aAttrs["checked"]);
    }

    public function __invoke($aAttr=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttr, static::$aDefaultAttrs);

        static::fnPrint(static::fnRenderTag(static::T_INPUT, true, $aAttrs));
    }
}