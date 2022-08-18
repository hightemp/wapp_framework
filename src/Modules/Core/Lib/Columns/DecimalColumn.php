<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Columns;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseColumn;

class DecimalColumn extends BaseColumn
{
    const DB_TYPE = "DECIMAL";
    const TYPE = "decimal";

    const P_AUTOICREMENT = false;
    const P_NULLABLE = false;
    const P_CHARSET = "";
    const P_SIZE = "10,2";

    const B_IS_PRIMARY_INDEX = false;

    public static function fnDefaultValue()
    {
        return "0.00";
    }
}