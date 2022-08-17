<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Columns;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseColumn;

class IntColumn extends BaseColumn
{
    const DB_TYPE = "INT";
    const TYPE = "int";

    const P_AUTOICREMENT = false;
    const P_NULLABLE = false;
    const P_CHARSET = "";
    const P_SIZE = 11;

    const P_COMMENT = "";

    const B_IS_PRIMARY_INDEX = false;
}