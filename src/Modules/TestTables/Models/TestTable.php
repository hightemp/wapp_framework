<?php

namespace Hightemp\WappFramework\Modules\TestTables\Models;

use Hightemp\WappFramework\Modules\Core\Lib\Models\CRUDModel;
use Hightemp\WappFramework\Modules\Core\Lib\Relations\OneToOne;
use Hightemp\WappFramework\Modules\TestTables\Models\TestTable\IndexID;
use Hightemp\WappFramework\Modules\TestTables\Models\TestTable\TestInt;
use Hightemp\WappFramework\Modules\TestTables\Models\TestTable\TestJson;
use Hightemp\WappFramework\Modules\TestTables\Models\TestTable\TestVarChar;

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

    public const RELATIONS = [
        [OneToOne::class, TestTable2::class]
    ];
}