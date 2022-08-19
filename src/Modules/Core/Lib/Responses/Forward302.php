<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Responses;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Response;

class Forward302 extends Response
{
    public $iCode = 302;

    public function __construct($sURL)
    {
        $this->aHeaders[] = "Location: {$sURL}";
    }
}