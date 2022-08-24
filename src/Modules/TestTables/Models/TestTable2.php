<?php

namespace Hightemp\WappTestSnotes\Modules\TestTables\Models;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Models\CRUDModel;
use Hightemp\WappTestSnotes\Modules\TestTables\Models\TestTable\IndexID;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Columns\JSONColumn;

class TestTable2 extends CRUDModel
{
    public const TABLE_NAME="ttesttable2";

    public const C_TEST_TEXT = "test_text";

    public const COLUMNS = [
        self::C_INDEX_FIELD => IndexID::class,
        self::C_TEST_TEXT => JSONColumn::class,
    ];

    public const RELATIONS = [

    ];
}