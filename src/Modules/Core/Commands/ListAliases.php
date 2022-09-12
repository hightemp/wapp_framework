<?php

namespace Hightemp\WappFramework\Modules\Core\Commands;

use Hightemp\WappFramework\Modules\Core\Helpers\Utils;
use Hightemp\WappFramework\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappFramework\Modules\Core\Lib\Command;

class ListAliases extends Command
{
    const FULL_COMMAND = "list_aliases";

    public function fnExecute($aArgs)
    {
        $aAliases = BaseController::fnGetAllAliases();

        $aData = [];
        foreach ($aAliases as $sAlias => $aMethod) {
            $aMethod = array_replace_recursive(['', '', ''], $aMethod);
            $aData[] = [$sAlias, ...$aMethod];
        }

        Utils::fnPrintTable($aData);
    }
}