<?php

namespace Hightemp\WappTestSnotes\Modules\GoogleSheetsImporter\Controllers;

use Hightemp\WappTestSnotes\Modules\CBootstrapTable\Helpers\Utils;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappTestSnotes\Modules\GoogleSheetsImporter\View;
use Hightemp\WappTestSnotes\Modules\GoogleSheetsImporter\Controllers\API;
use Hightemp\WappTestSnotes\Modules\GoogleSheetsImporter\Models\TestTable;

class Index extends BaseController
{
    public static $sDefaultViewClass = View::class;

    public function fnIndexHTML()
    {
        // $oTestTable = TestTable::fnBuild();

        $aEntity = Utils::fnPrepareVarsForAjaxTable(
            API::class,
            TestTable::class,
            $this->oRequest
        );

        View::fnAddVars([
            "aTestTableEntity" => $aEntity,
        ]);
    }

    public function fnGenerateRandomRecordJSON()
    {
        $oTestTable = TestTable::fnBuild();

        $oRecord = $oTestTable->create([
            TestTable::C_TEST_INT => random_int(10, 100000),
            TestTable::C_TEST_JSON => [ "a" => random_int(10, 100000) ],
            TestTable::C_TEST_VARCHAR => str_repeat("random string ", random_int(10, 100)),
        ]);

        return $oRecord;
    }

    public function fnTruncateTableJSON()
    {
        $oTestTable = TestTable::fnBuild();

        $oTestTable->wipe();
    }
}