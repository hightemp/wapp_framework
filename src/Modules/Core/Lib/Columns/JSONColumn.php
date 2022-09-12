<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Columns;

use Hightemp\WappFramework\Modules\Core\Lib\BaseColumn;

class JSONColumn extends BaseColumn
{
    const DB_TYPE = "VARCHAR";
    const TYPE = "varchar";

    const P_AUTOICREMENT = false;
    const P_NULLABLE = false;
    const P_CHARSET = "utf8mb4";
    const P_SIZE = 4000;

    const B_HAS_DEFAULT_VALUE = true;

    public static function fnDefaultValue()
    {
        return '{}';
    }

    public static function fnPrepareValue($mValue)
    {
        return json_encode($mValue);
    }

    public static function fnExtractValue($mValue)
    {
        return json_decode($mValue, true);
    }
}