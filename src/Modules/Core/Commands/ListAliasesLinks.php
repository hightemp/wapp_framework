<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Commands;

use Hightemp\WappTestSnotes\Modules\Core\Helpers\Utils;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Command;

class ListAliasesLinks extends Command
{
    const FULL_COMMAND = "list_aliases_links";

    public function fnExecute($aArgs)
    {
        $aAliases = BaseController::fnGetAllAliases();

        $sHost = SERVER_HOST;
        $iPort = SERVER_PORT;

        $aData = [];
        foreach ($aAliases as $sAlias => $aMethod) {
            $aData[] = ["http://$sHost:$iPort/".$sAlias];
        }

        Utils::fnPrintTable($aData);
    }
}