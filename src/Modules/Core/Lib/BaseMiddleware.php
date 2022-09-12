<?php

namespace Hightemp\WappFramework\Modules\Core\Lib;

class BaseMiddleware
{
    function fnExecuteBefore($oRequest)
    {
        return null;
    }

    function fnExecute($oRequest)
    {
        return null;
    }

    function fnExecuteAfter($oRequest, $oResponse)
    {
        return null;
    }
}