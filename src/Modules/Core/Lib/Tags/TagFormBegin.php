<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Tags;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;
use Hightemp\WappFramework\Modules\Core\Lib\View;

class TagFormBegin extends BaseHTMLHelper
{
    public function __invoke()
    {
        ob_start();
    }
}