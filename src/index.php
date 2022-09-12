<?php

use Hightemp\WappFramework\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappFramework\Modules\Core\Lib\Command;
use Hightemp\WappFramework\Modules\Core\Lib\Config;
use Hightemp\WappFramework\Modules\Core\Lib\Request;
use Hightemp\WappFramework\Modules\Core\Lib\Logger;
use Hightemp\WappFramework\Project;

use Hightemp\WappFramework\Modules\Core\Helpers\Utils;

Project::fnInit();

if (Utils::fnIsCli()) {
    $iExitCode = (int) Command::fnParseCliArgs($argv);
    exit($iExitCode);
} else {
    try {
        $oRequest = Request::fnBuild();
        $oResponse = BaseController::fnFindAndExecuteMethod($oRequest);
        $oResponse->fnPrintOutputAndExit();
    } catch (\Exception $oException) {
        http_response_code(500);
        die($oException->getMessage());
    }
}