<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Responses;

use Hightemp\WappFramework\Modules\Core\Lib\Response;

class JSON extends Response
{
    public $sContentType = "application/json";

    public function fnSetContent($mContent)
    {
        $this->sContent = json_encode($mContent, JSON_UNESCAPED_UNICODE);
    }
}