<?php

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseController;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Command;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Config;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Request;

use Hightemp\WappTestSnotes\Modules\Core\Helpers\Utils;

if (defined('DEBUG')) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

Config::fnLoad();

if (Utils::fnIsCli()) {
    $iExitCode = (int) Command::fnParseCliArgs($argv);
    exit($iExitCode);
} else {
    try {
        $oRequest = Request::fnCreateRequest();
        $oResponse = BaseController::fnFindAndExecuteMethod($oRequest);
        $oResponse->fnPrintOutputAndExit();
    } catch (\Exception $oException) {
        http_response_code(500);
        die($oException->getMessage());
    }
}