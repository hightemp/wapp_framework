<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagCETextBox extends BaseTag
{
    public static $aDefaultAttrs = [
        "class" => "easyui-textbox",
        "label" => "TextBox:",
        "labelPosition" => "top",
        "style" => "width:100%"
    ];

    public function __invoke($aAttr=[])
    {
        $aAttr = array_merge_recursive(static::$aDefaultAttrs, $aAttr);
        $sAttr = static::fnPrepareAttr($aAttr);
        
        echo <<<HTML
<input
    {$sAttr}
/>
HTML;
    }
}