<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Columns;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseColumn;

class VarcharColumn extends BaseColumn
{
    const DB_TYPE = "VARCHAR";
    const TYPE = "varchar";

    const P_AUTOICREMENT = false;
    const P_NULLABLE = false;
    const P_CHARSET = "utf8mb4";
    const P_SIZE = 255;

    public static function fnDefaultValue()
    {
        return '';
    }
}