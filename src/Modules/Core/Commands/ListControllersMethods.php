<?php

namespace Hightemp\WappFramework\Modules\Core\Commands;

use Hightemp\WappFramework\Project;
use Hightemp\WappFramework\Modules\Core\Helpers\Utils;
use Hightemp\WappFramework\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappFramework\Modules\Core\Lib\Command;

class ListControllersMethods extends Command
{
    const FULL_COMMAND = "list_controllers_methods";

    public function fnExecute($aArgs)
    {
        $bUseFull = in_array("--use-full", $aArgs);
        $aControllersByModules = BaseController::fnGetControllersByModules();
        $aData = [];

        foreach ($aControllersByModules as $sModulesClass => $aControllers) {
            $sModuleName = Utils::fnExtractModuleName($sModulesClass);
            $sModuleViewClass = Utils::fnGetModulesClassNamespace($sModuleName, "View");
            if (!class_exists($sModuleViewClass)) {
                $sModuleViewClass = null;
            }

            foreach ($aControllers as $sControllerClass) {
                /** @var BaseController $sControllerClass */
                $aMethods = $sControllerClass::fnGetValidMethods();
                foreach ($aMethods as $sMethod) {
                    
                    $aTemplates = (array) $sControllerClass::fnGetTemplate($sModuleViewClass, $sControllerClass, $sMethod, $bUseFull);
                    $aTemplates = array_replace_recursive(['', '', ''], $aTemplates);

                    $aData[] = [$sModulesClass, $sControllerClass, $sMethod, ...$aTemplates];
                }
            }
        }

        Utils::fnPrintTable($aData);
    }
}