<?php

namespace Hightemp\WappTestSnotes\Modules\Core;

use Hightemp\WappTestSnotes\Modules\Core\Lib\View as LibView;

class View extends LibView
{
    const TEMPLATES_PATH = __DIR__."/views";
    
    public static $sDefaultLayoutTemplate = "layout.php";
    public static $sDefaultContentTemplate = "index.php";
}