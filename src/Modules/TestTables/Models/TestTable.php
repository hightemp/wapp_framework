<?php

namespace Hightemp\WappTestSnotes\Modules\TestTables\Models;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Models\CRUDModel;
use Hightemp\WappTestSnotes\Modules\TestTables\Models\TestTable\IndexID;
use Hightemp\WappTestSnotes\Modules\TestTables\Models\TestTable\TestInt;
use Hightemp\WappTestSnotes\Modules\TestTables\Models\TestTable\TestJson;
use Hightemp\WappTestSnotes\Modules\TestTables\Models\TestTable\TestVarChar;

class TestTable extends CRUDModel
{
    public const TABLE_NAME="ttesttable";

    public const C_TEST_JSON = "test_json";
    public const C_TEST_INT = "test_int";
    public const C_TEST_VARCHAR = "test_varchar";

    public const COLUMNS = [
        self::C_INDEX_FIELD => IndexID::class,
        self::C_TEST_JSON => TestJson::class,
        self::C_TEST_INT => TestInt::class,
        self::C_TEST_VARCHAR => TestVarChar::class,
    ];
}