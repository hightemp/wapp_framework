<?php

namespace Hightemp\WappFramework\Modules\Core\Commands;

use Hightemp\WappFramework\Modules\Core\Generators;
use Hightemp\WappFramework\Modules\Core\Helpers\Utils;
use Hightemp\WappFramework\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappFramework\Modules\Core\Lib\Command;
use Hightemp\WappFramework\Project;

class ListGenerators extends Command
{
    const FULL_COMMAND = "list_generators";

    public function fnExecute($aArgs)
    {
        $aData = [];
        foreach (Project::$aGenerators as $sGenerator) {
            $aData[] = [$sGenerator::GENERATOR_TYPE, $sGenerator];
        }

        Utils::fnPrintTable($aData);
    }
}