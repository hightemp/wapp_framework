<?php

namespace Hightemp\WappFramework\Modules\Core\Commands;

use Hightemp\WappFramework\Modules\Core\Helpers\Utils;
use Hightemp\WappFramework\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappFramework\Modules\Core\Lib\Command;
use Hightemp\WappFramework\Project;
use Hightemp\WappFramework\Modules\Core\Lib\View;

class ListTemplateVars extends Command
{
    const FULL_COMMAND = "list_template_vars";

    public function fnExecute($aArgs)
    {
        $aVars = [];

        $aData = [];
        foreach (Project::$aPreloadViews as $sViewClass) {
            $sViewClass::fnPrepareVars();
            $aVars[] = array_keys(View::$aVars);
            $iC = count($aVars);
            $aDiff = array_diff($aVars[$iC-1], isset($aVars[$iC-2]) ? $aVars[$iC-2] : []);

            foreach ($aDiff as $sVarName) {
                $aData[] = [$sVarName, $sViewClass];
            }
        }

        Utils::fnPrintTable($aData);
    }
}