<?php

use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Command;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Config;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Request;

use Hightemp\WappTestSnotes\Modules\Core\Helpers\Utils;

Config::fnInit();

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