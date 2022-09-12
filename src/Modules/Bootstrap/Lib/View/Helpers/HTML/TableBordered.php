<?php

namespace Hightemp\WappFramework\Modules\Bootstrap\Lib\View\Helpers\HTML;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;
use Hightemp\WappFramework\Modules\Core\Lib\View\Helpers\HTML;
use Hightemp\WappFramework\Modules\Core\Helpers\Utils;

class TableBordered extends BaseHTMLHelper
{
    public static $aDefaultAttrs = [
        "class" => "table table-bordered table-striped table-hover",
    ];

    public function __invoke($aData, $aHeaders=[], $aAttrs=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttrs, static::$aDefaultAttrs);
        
        HTML::TagTable($aData, $aHeaders, $aAttrs);
    }
}