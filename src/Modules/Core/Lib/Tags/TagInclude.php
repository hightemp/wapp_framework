<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Request;
use Hightemp\WappTestSnotes\Modules\Core\Helpers\Utils;

class TagInclude extends BaseTag
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
        echo $sViewClass::fnRenderTemplate($sPath, $aVars);
    }
}