<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Commands;

use Hightemp\WappTestSnotes\Modules\Core\Helpers\Utils;
use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseController;
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
        // printf(str_repeat("-", 127)."\n");
        // foreach ($aAliases as $sAlias => $aMethod) {
        //     printf("| %-20s | %-100s |\n", $sAlias, $aMethod[0].":".$aMethod[1]);
        // }
        // printf(str_repeat("-", 127)."\n");
    }
}