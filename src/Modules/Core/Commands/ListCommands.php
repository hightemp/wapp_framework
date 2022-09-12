<?php

namespace Hightemp\WappFramework\Modules\Core\Commands;

use Hightemp\WappFramework\Project;
use Hightemp\WappFramework\Modules\Core\Helpers\Utils;
use Hightemp\WappFramework\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappFramework\Modules\Core\Lib\Command;

class ListCommands extends Command
{
    const FULL_COMMAND = "list_commands";

    public function fnExecute($aArgs)
    {
        $aData = [];

        foreach (Project::$aCommands as $sCommandClass) {
            $aCommands = $sCommandClass::$aCommands;
            foreach ($aCommands as $sCommand) {
                $aData[] = [$sCommand::FULL_COMMAND, $sCommand];
            }
        }

        Utils::fnPrintTable($aData);
    }
}