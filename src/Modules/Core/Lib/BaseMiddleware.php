<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

class BaseMiddleware
{
    function fnExecuteBefore($oRequest)
    {
        return null;
    }

    function fnExecuteAfter($oRequest, $oResponse)
    {
        return null;
    }
}