<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Exceptions;

use Hightemp\WappFramework\Modules\Core\Lib\Response;
use Hightemp\WappFramework\Modules\Core\Lib\Responses\Forward301;

class RedirectException extends \Exception {
    public $sURL = "";

    function fnGetResponse()
    {
        return (new Forward301($this->getMessage()));
    }
}