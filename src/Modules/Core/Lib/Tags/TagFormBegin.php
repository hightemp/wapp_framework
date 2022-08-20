<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;
use Hightemp\WappTestSnotes\Modules\Core\Lib\View;

class TagFormBegin extends BaseTag
{
    public function __invoke()
    {
        ob_start();
    }
}