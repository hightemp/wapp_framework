<?php

namespace Hightemp\WappFramework\Modules\CEasyUI\Controllers;

use Hightemp\WappFramework\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappFramework\Modules\CEasyUI\View;

class Index extends BaseController
{
    public static $sDefaultViewClass = View::class;

    public function fnIndexHTML()
    {
        $aAliases = BaseController::fnGetAllAliasesLinks(static::class);

        View::fnAddVars([
            "aAliases" => $aAliases
        ]);
    }
}