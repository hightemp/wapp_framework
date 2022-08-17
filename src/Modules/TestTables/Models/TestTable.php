<?php

namespace Hightemp\WappTestSnotes\Modules\TestTables\Models;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Columns\IntColumn;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Columns\JSONColumn;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Columns\PrimaryIndexIntColumn;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Columns\VarcharColumn;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Models\CRUDModel;

class TestTable extends CRUDModel
{
    public const TABLE_NAME="ttesttable";

    public const C_TEST_JSON = "test_json";
    public const C_TEST_INT = "test_int";
    public const C_TEST_VARCHAR = "test_varchar";

    public const COLUMNS = [
        self::C_INDEX_ID => PrimaryIndexIntColumn::class,
        self::C_TEST_JSON => JSONColumn::class,
        self::C_TEST_INT => IntColumn::class,
        self::C_TEST_VARCHAR => VarcharColumn::class,
    ];
}