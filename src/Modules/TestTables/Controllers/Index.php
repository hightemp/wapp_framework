<?php

namespace Hightemp\WappTestSnotes\Modules\TestTables\Controllers;

use Hightemp\WappTestSnotes\Modules\CBootstrapTable\Helpers\Utils;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappTestSnotes\Modules\TestTables\View;
use Hightemp\WappTestSnotes\Modules\TestTables\Controllers\API;
use Hightemp\WappTestSnotes\Modules\TestTables\Models\TestTable;
use Hightemp\WappTestSnotes\Modules\TestTables\Models\TestTable2;

class Index extends BaseController
{
    public static $sDefaultViewClass = View::class;

    public function fnIndexHTML()
    {
        $aAliases = BaseController::fnGetAllAliasesLinks(static::class);

        View::fnAddVars([
            "aAliases" => $aAliases
        ]);
    }

    public function fnAjaxTableHTML()
    {
        $aEntity = Utils::fnPrepareVarsForAjaxTable(
            API::class,
            TestTable::class,
            $this->oRequest,
            [],
            [
                "id" => "table-ajax-test"
            ]
        );

        View::fnAddVars([
            "aTestTableEntity" => $aEntity,
        ]);
    }

    public function fnCrudTableHTML()
    {
        $aEntity = Utils::fnPrepareVarsForAjaxTable(
            API::class,
            TestTable::class,
            $this->oRequest,
            [],
            [
                "id" => "table-crud-test"
            ]
        );

        View::fnAddVars([
            "aTestTableEntity" => $aEntity,
        ]);
    }

    public function fnGenerateRandomRecord1JSON()
    {
        $oTestTable = TestTable::fnBuild();
        $oTestTable2 = TestTable2::fnBuild();

        $oRecord = $oTestTable->create([
            TestTable::C_TEST_INT => random_int(10, 100000),
            TestTable::C_TEST_JSON => [ "a" => random_int(10, 100000) ],
            TestTable::C_TEST_VARCHAR => str_repeat("random string ", random_int(10, 100)),
            TestTable2::TABLE_NAME => $oTestTable2->fnCreateOrUpdate([
                TestTable2::C_TEST_TEXT => [ "test" => random_int(10, 100000) ],
            ])
        ]);

        return $oRecord;
    }

    public function fnGenerateRandomRecord2JSON()
    {
        $oTestTable = TestTable::fnBuild();
        $oTestTable2 = TestTable2::fnBuild();

        $oRecord = $oTestTable->create([
            TestTable::C_TEST_INT => random_int(10, 100000),
            TestTable::C_TEST_JSON => [ "a" => random_int(10, 100000) ],
            TestTable::C_TEST_VARCHAR => str_repeat("random string ", random_int(10, 100)),
            TestTable2::TABLE_NAME => $oTestTable2->fnCreateOrUpdate([
                TestTable2::C_INDEX_FIELD => 10,
            ])
        ]);

        return $oRecord;
    }

    public function fnGenerateRandomRecord3JSON()
    {
        $oTestTable = TestTable::fnBuild();

        $oRecord = $oTestTable->create([
            TestTable::C_TEST_INT => random_int(10, 100000),
            TestTable::C_TEST_JSON => [ "a" => random_int(10, 100000) ],
            TestTable::C_TEST_VARCHAR => str_repeat("random string ", random_int(10, 100)),
            TestTable2::fnGetTableID() => 1
        ]);

        return $oRecord;
    }

    public function fnTruncateTableJSON()
    {
        $oTestTable = TestTable::fnBuild();

        $oTestTable->wipe();
    }

    public function fnNukeJSON()
    {
        $oTestTable = TestTable::fnBuild();

        $oTestTable->nuke();
    }
}