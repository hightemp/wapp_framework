<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Commands;

use Hightemp\WappTestSnotes\Modules\Core\Generators;
use Hightemp\WappTestSnotes\Modules\Core\Helpers\Utils;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Command;
use Hightemp\WappTestSnotes\Project;
use Hightemp\WappTestSnotes\Modules\Core\Helpers\ClassFinder;

class ListModels extends Command
{
    const FULL_COMMAND = "list_models";

    public function fnExecute($aArgs)
    {
        $aModules = Project::$aModules;

        $aData = [];
        foreach ($aModules as $sModuleClass) {
            $aClasses = Utils::fnGetModuleModels($sModuleClass);

            foreach ($aClasses as $sClass) {
                $aData[] = [$sClass];
            }
        }

        Utils::fnPrintTable($aData);
    }
}