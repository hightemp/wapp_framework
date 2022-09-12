<?php

namespace Hightemp\WappFramework\Modules\Bootstrap\Lib\View\Helpers\HTML;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;
use Hightemp\WappFramework\Modules\Core\Helpers\Utils;

class LinksListGroups extends BaseHTMLHelper
{
    public static $aDefaultAttrs = [
        "class" => "list-group",
    ];

    public static $aDefaultATagAttrs = [
        "class" => "list-group-item list-group-item-action",
    ];

    public static $sActiveClass = "active";

    public function __invoke($aList, $aAttrs=[], $aTagAAttrs=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttrs, static::$aDefaultAttrs);
        $aTagAAttrs = static::fnPrepareAttrs($aTagAAttrs, static::$aDefaultATagAttrs);
        
        $sHTML = "";

        foreach ($aList as $aItem) {
            $sURL = $aItem[0];
            $sTitle = $aItem[1];
            $sActiveClass = Utils::fnIsURLCurrent($sURL) ? static::$sActiveClass : "";

            $aTagAAttrs["class"] = $aTagAAttrs["class"]." ".$sActiveClass;
            $aTagAAttrs["href"] = $sURL;

            $sHTML .= static::fnRenderTag(static::T_A, false, $aTagAAttrs, $sTitle);
        }

        $sHTML = static::fnRenderTag(static::T_DIV, false, $aAttrs, $sHTML);

        static::fnPrint($sHTML);
    }
}