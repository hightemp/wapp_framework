<?php

namespace Hightemp\WappFramework\Modules\CBootstrapTable\Lib\Tags\HTML;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;
use Hightemp\WappFramework\Modules\Core\Lib\Tags\TagTable;

class Pagination extends BaseHTMLHelper
{
    public static $aDefaultAttrs = [
        "class" => "",
        "aria-label" => "",
    ];

    public static $aDefaultULAttrs = [
        "class" => "pagination",
    ];

    public static $aDefaultLIAttrs = [
        "class" => "page-item",
    ];

    public static $aDefaultAAttrs = [
        "class" => "page-link",
    ];

    public static $aDefaultDivAttrs = [
        "class" => "input-group",
        "style" => "width:80px"
    ];

    public static $aDefaultSpanAttrs = [
        "class" => "input-group-text"
    ];

    public static $aDefaultInputAttrs = [
        "class" => "form-control",
        "aria-label" => "",
        "type" => "text",
        "style" => "text-align:right"
    ];

    public static $aLinksTitles = [
        "page_first" => '<i class="bi bi-chevron-bar-left"></i>',
        "page_prev" => '<i class="bi bi-chevron-left"></i>',
        "input" => "Страница",
        "current_page" => "0",
        "total_pages" => "0",
        "page_next" => '<i class="bi bi-chevron-right"></i>',
        "page_last" => '<i class="bi bi-chevron-bar-right"></i>',
    ];

    public function __invoke($aList, $aAttrs=[], $aULAttrs=[], $aLIAttrs=[], $aAAttrs=[])
    {
        static::fnPrepareAttrs($aAttrs, static::$aDefaultAttrs);
        static::fnPrepareAttrs($aULAttrs, static::$aDefaultULAttrs);
        static::fnPrepareAttrs($aLIAttrs, static::$aDefaultLIAttrs);
        static::fnPrepareAttrs($aAAttrs, static::$aDefaultAAttrs);
        $sHTML = "";

        $aKeys = array_keys(static::$aLinksTitles);

        foreach ($aKeys as $sKey) {
            if ($sKey == "input") {
                $sTitle = static::$aLinksTitles[$sKey];

                $aInputAttrs = ["value" => $aList["current_page"]];
                static::fnPrepareAttrs($aInputAttrs, static::$aDefaultInputAttrs);

                $sInput = static::fnRenderTag(static::T_INPUT, true, $aInputAttrs);
                $sSpan = static::fnRenderTag(static::T_SPAN, false, static::$aDefaultSpanAttrs, "/".$aList["total_pages"]);

                $sHTML .= static::fnRenderTag(static::T_DIV, false, static::$aDefaultDivAttrs, $sInput.$sSpan);
            } else if (in_array($sKey, ["current_page", "total_pages"])) {

            } else {
                $sTitle = static::$aLinksTitles[$sKey];

                $aAAttrs["href"] = $aList[$sKey];
                $sA = static::fnRenderTag(static::T_A, false, $aAAttrs, $sTitle);
                $sHTML .= static::fnRenderTag(static::T_LI, false, $aLIAttrs, $sA);
            }
        }

        $sHTML = static::fnRenderTag(static::T_UL, false, $aULAttrs, $sHTML);
        $sHTML = static::fnRenderTag(static::T_NAV, false, $aAttrs, $sHTML);

        static::fnPrint($sHTML);
    }
}