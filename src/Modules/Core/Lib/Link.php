<?php

namespace Hightemp\WappFramework\Modules\Core\Lib;

use Hightemp\WappFramework\Modules\Core\Lib\Controllers\BaseController;

class Link 
{
    public static function fnGetAliasLink($sAlias, $aParams=[])
    {
        $aAlias = BaseController::fnFindMethodByPathAlias($sAlias);

        if (!$aAlias) {
            throw new \Exception("alias link not found '{$sAlias}'");
        }

        return "/".trim($sAlias, "/")."/?".http_build_query($aParams);
    }
}