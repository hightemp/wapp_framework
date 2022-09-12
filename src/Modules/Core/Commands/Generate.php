<?php

namespace Hightemp\WappFramework\Modules\Core\Commands;

use Hightemp\WappFramework\Project;
use Hightemp\WappFramework\Modules\Core\Helpers\Utils;
use Hightemp\WappFramework\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappFramework\Modules\Core\Lib\Command;

class Generate extends Command
{
    const FULL_COMMAND = "generate";

    public function fnExecute($aArgs)
    {
        $sType = array_shift($aArgs);
        foreach (Project::$aGenerators as $sGenerator) {
            if ($sType == $sGenerator::GENERATOR_TYPE) {
                /** @var BaseGenerator */
                $sGenerator::fnGenerate($aArgs);
                die("\n[+] Сгенерировано\n");
            }
        }

        die("\n[-] Генератор не найден\n");
    }
}