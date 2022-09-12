<?php

namespace Hightemp\WappFramework\Modules\Core\Lib;

use Hightemp\WappFramework\Project;
use Hightemp\WappFramework\Modules\Core\Helpers\Utils;

class Command
{
    const FULL_COMMAND = "";
    const SHORT_COMMAND = "";

    public function fnExecute($aArgs)
    {
        throw new \Exception("command not defined");
    }

    public static function fnFindCommand($sSearchCommand)
    {
        foreach (Project::$aCommands as $sCommandClass) {
            foreach ($sCommandClass::$aCommands as $sCommand) {
                if ($sCommand::FULL_COMMAND == $sSearchCommand) {
                    return new $sCommand();
                }
            }
        }
    }

    public static function fnParseCliArgs($aArgs)
    {
        $sScriptPath = array_shift($aArgs);
        $sCommand = array_shift($aArgs);

        if (!$sCommand && Project::$sDefaultCommand) {
            $sClass = "\\".Project::$sDefaultCommand;
            $sCommand = $sClass::FULL_COMMAND;
        }

        $oCommand = static::fnFindCommand($sCommand);

        echo "\n";
        if (!$oCommand) {
            // throw new \Exception("command not found '$sCommand'");
            echo "[E] command not found '$sCommand'\n";
            return 100;
        }

        try {
            $oCommand->fnExecute($aArgs);
            Utils::fnFlush();
        } catch (\Exception $oException) {
            $iExitCode = $oException->getCode() ?: 200;
            echo $oException->getTraceAsString();
            echo "\n";
            echo "\n";
            echo "[E] Exception from command: '$sCommand'\n";
            echo "[E] Exception from class: '".$oException->getFile().":".$oException->getLine()."'\n";
            echo "[E] Message: ".$oException->getMessage()."\n";
            return $iExitCode;
        }
        echo "\n";
    }
}