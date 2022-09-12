<?php

use Hightemp\WappFramework\Modules\Core\Lib\Logger;

function fnWriteMessage($sMessage, $aData=[])
{
    Logger::fnWriteMessage($sMessage, $aData);
}

function fnWriteError($sMessage, $aData=[])
{
    Logger::fnWriteError($sMessage, $aData);
}

function fnWriteWarning($sMessage, $aData=[])
{
    Logger::fnWriteWarning($sMessage, $aData);
}

function fnWriteInfo($sMessage, $aData=[])
{
    Logger::fnWriteInfo($sMessage, $aData);
} 