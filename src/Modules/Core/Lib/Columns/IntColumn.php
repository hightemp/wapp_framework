<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Columns;

use Hightemp\WappFramework\Modules\Core\Lib\BaseColumn;

class IntColumn extends BaseColumn
{
    const DB_TYPE = "INT";
    const TYPE = "int";

    const P_AUTOICREMENT = false;
    const P_NULLABLE = false;
    const P_CHARSET = "";
    const P_SIZE = 11;

    const B_IS_PRIMARY_INDEX = false;

    public static function fnDefaultValue()
    {
        return 0;
    }

    public static function fnPrepareValue($mValue)
    {
        return (int) $mValue;
    }

    public static function fnExtractValue($mValue)
    {
        return (int) $mValue;
    }
}