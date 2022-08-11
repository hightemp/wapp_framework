<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Responses;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Response;

class NotFound extends HTML
{
    public $iCode = 404;

    public function fnGetContent()
    {
        return "<h1>Page not found</h1>";
    }
}