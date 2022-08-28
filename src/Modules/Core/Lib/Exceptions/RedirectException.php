<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Exceptions;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Response;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Responses\Forward301;

class RedirectException extends \Exception {
    public $sURL = "";

    function fnGetResponse()
    {
        return (new Forward301($this->getMessage()));
    }
}