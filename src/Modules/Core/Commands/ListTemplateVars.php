<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Commands;

use Hightemp\WappTestSnotes\Modules\Core\Helpers\Utils;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Command;
use Hightemp\WappTestSnotes\Project;
use Hightemp\WappTestSnotes\Modules\Core\Lib\View;

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
            $aDiff = array_diff($aVars[$iC-1], isset($aVars[$iC-2]) ?: []);

            foreach ($aDiff as $sVarName) {
                $aData[] = [$sVarName, $sViewClass];
            }
        }

        Utils::fnPrintTable($aData);
    }
}