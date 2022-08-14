<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Commands;

use Hightemp\WappTestSnotes\Modules\Core\Helpers\Utils;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Command;

class ListAliases extends Command
{
    const FULL_COMMAND = "list_aliases";

    public function fnExecute($aArgs)
    {
        $aAliases = BaseController::fnGetAllAliases();

        $aData = [];
        foreach ($aAliases as $sAlias => $aMethod) {
            $aData[] = [$sAlias, ...$aMethod];
        }

        Utils::fnPrintTable($aData);
    }
}