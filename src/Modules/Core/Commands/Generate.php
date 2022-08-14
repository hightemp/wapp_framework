<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Commands;

use Hightemp\WappTestSnotes\Project;
use Hightemp\WappTestSnotes\Modules\Core\Helpers\Utils;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Command;

class Generate extends Command
{
    const FULL_COMMAND = "generate";

    public function fnExecute($aArgs)
    {
        $sType = array_shift($aArgs);
        foreach (Project::$aGenerators as $sGenerator) {
            if ($sType == $sGenerator::GENERATOR_TYPE) {
                $sGenerator::
                break;
            }
        }
    }
}