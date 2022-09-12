<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Tags;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;
use Hightemp\WappFramework\Modules\Core\Lib\Request;
use Hightemp\WappFramework\Modules\Core\Helpers\Utils;

class TagInclude extends BaseHTMLHelper
{
    function __construct()
    {
        
    }

    public function __invoke($sTemplatePath, $aVars=[])
    {
        $sModuleClass = Request::$sCurrentModuleClass;
        $sPath = $sTemplatePath;
        if (preg_match("/^(.*)@(.*)/", $sTemplatePath, $aM)) {
            $sModuleClass = Utils::fnGetModulesClassNamespace($aM[0]);
            $sPath = $aM[1];
        }

        $sViewClass = Utils::fnGetModulesClassNamespace(Utils::fnExtractModuleName($sModuleClass), "View");

        /** @var View */
        static::fnPrint($sViewClass::fnRenderTemplate($sPath, $aVars));
    }
}