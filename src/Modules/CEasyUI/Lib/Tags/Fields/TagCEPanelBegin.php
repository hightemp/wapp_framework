<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagCEPanelBegin extends BaseTag
{
    public function __invoke()
    {
        ob_start();
    }
}