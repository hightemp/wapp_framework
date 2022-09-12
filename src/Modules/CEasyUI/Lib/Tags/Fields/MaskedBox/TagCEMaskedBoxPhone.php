<?php

namespace Hightemp\WappFramework\Modules\CEasyUI\Lib\Tags\Fields\MaskedBox;

use Hightemp\WappFramework\Modules\CEasyUI\Lib\Tags\Fields\TagCEMaskedBox;

class TagCEMaskedBoxPhone extends TagCEMaskedBox
{
    public static $aDefaultAttrs = [
        "label" => "Phone box:",
        "mask" => "(999) 999-9999",
    ];
}