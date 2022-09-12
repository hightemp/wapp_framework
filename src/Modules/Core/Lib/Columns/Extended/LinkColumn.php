<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Columns\Extended;

use Hightemp\WappFramework\Modules\Core\Lib\Columns\VarcharColumn;

class LinkColumn extends VarcharColumn
{
    const TYPE = "link";

    const P_SIZE = 4000;

    public static function fnDefaultValue()
    {
        return '#';
    }

    public static function fnValidate($mValue)
    {
        return $mValue == "#" || !!filter_var($mValue, FILTER_VALIDATE_URL);
    }

    public static function fnPrepareValue($mValue)
    {
        return $mValue;
    }

    public static function fnExtractValue($mValue)
    {
        return $mValue;
    }
}