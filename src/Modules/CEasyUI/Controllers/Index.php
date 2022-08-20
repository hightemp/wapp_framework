<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI\Controllers;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappTestSnotes\Modules\Core\View;

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