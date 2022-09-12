<?php

namespace Hightemp\WappFramework\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;
use Hightemp\WappFramework\Modules\Core\Lib\Tags\TagSelect;

class TagCECheckbox extends BaseHTMLHelper
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