<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Responses;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Response;

class Forward301 extends Response
{
    public $iCode = 301;

    public function __construct($sURL)
    {
        $this->aHeaders[] = "Location: {$sURL}";
    }
}