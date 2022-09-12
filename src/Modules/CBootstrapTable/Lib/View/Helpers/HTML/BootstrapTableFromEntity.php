<?php

namespace Hightemp\WappFramework\Modules\CBootstrapTable\Lib\Tags\HTML;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;
use Hightemp\WappFramework\Modules\CBootstrapTable\Lib\Tags\HTML\BootstrapTable;

class BootstrapTableFromEntity extends BaseHTMLHelper
{
    public function __invoke($aEntity)
    {
        return (new BootstrapTable())(
            $aEntity["aData"],
            $aEntity["aHeaders"],
            $aEntity["aAttrs"]
        );
    }
}