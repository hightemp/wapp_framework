<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Commands;

use Hightemp\WappTestSnotes\Modules\Core\Generators;
use Hightemp\WappTestSnotes\Modules\Core\Helpers\Utils;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Command;
use Hightemp\WappTestSnotes\Project;

class ListGenerators extends Command
{
    const FULL_COMMAND = "list_generators";

    public function fnExecute($aArgs)
    {
        $aModels = [];

        $aData = [];
        foreach ($aModels as $sClass) {
            $aData[] = [];
        }

        Utils::fnPrintTable($aData);
    }
}