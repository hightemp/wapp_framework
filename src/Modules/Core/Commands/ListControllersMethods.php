<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Commands;

use Hightemp\WappTestSnotes\Project;
use Hightemp\WappTestSnotes\Modules\Core\Helpers\Utils;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Command;

class ListControllersMethods extends Command
{
    const FULL_COMMAND = "list_controllers_methods";

    public function fnExecute($aArgs)
    {
        $aControllersByModules = BaseController::fnGetControllersByModules();
        $aData = [];

        foreach ($aControllersByModules as $sModulesClass => $aControllers) {
            foreach ($aControllers as $sControllerClass) {
                /** @var BaseController $sControllerClass */
                $aMethods = $sControllerClass::fnGetValidMethods();
                foreach ($aMethods as $sMethod) {
                    $aData[] = [$sModulesClass, $sControllerClass, $sMethod];
                }
            }
        }

        Utils::fnPrintTable($aData);
    }
}