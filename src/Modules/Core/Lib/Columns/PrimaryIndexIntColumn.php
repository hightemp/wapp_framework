<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Columns;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseColumn;

class PrimaryIndexIntColumn extends IntColumn
{
    const P_AUTOICREMENT = true;
    const P_COMMENT = "primary index";
    const B_IS_PRIMARY_INDEX = true;
}