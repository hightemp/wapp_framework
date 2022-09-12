<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Responses;

class NotFound extends HTML
{
    public $iCode = 404;

    public function fnGetContent()
    {
        return "<h1>Page not found</h1>";
    }
}