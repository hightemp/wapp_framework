<?php

namespace Hightemp\WappFramework\Modules\Core\Commands;

use Hightemp\WappFramework\Modules\Core\Generators;
use Hightemp\WappFramework\Modules\Core\Helpers\Utils;
use Hightemp\WappFramework\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappFramework\Modules\Core\Lib\Command;
use Hightemp\WappFramework\Project;
use Hightemp\WappFramework\Modules\Core\Helpers\ClassFinder;

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