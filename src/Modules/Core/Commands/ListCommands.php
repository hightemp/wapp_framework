<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Commands;

use Hightemp\WappTestSnotes\Project;
use Hightemp\WappTestSnotes\Modules\Core\Helpers\Utils;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Command;

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