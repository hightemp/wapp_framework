<?php

namespace Hightemp\WappFramework\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;

class TagCEPanelBegin extends BaseHTMLHelper
{
    public function __invoke()
    {
        ob_start();
    }
}