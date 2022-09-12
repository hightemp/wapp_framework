<?php

namespace Hightemp\WappFramework\Modules\Core\Commands;

use Hightemp\WappFramework\Project;
use Hightemp\WappFramework\Modules\Core\Helpers\Utils;
use Hightemp\WappFramework\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappFramework\Modules\Core\Lib\Command;

class ListControllers extends Command
{
    const FULL_COMMAND = "list_controllers";

    public function fnExecute($aArgs)
    {
        $aControllersByModules = BaseController::fnGetControllersByModules();
        $aData = [];

        foreach ($aControllersByModules as $sModulesClass => $aControllers) {
            foreach ($aControllers as $sControllerClass) {
                $aData[] = [$sModulesClass, $sControllerClass];
            }
        }

        Utils::fnPrintTable($aData);
    }
}