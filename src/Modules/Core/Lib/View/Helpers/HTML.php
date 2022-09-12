<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\View\Helpers;

/**
 * @method static void TagA($sContent, $sHref, $aAttrs=[])
 * @method static void TagAliasA($sContent, $sAlias, $aArgs=[], $aAttr=[])
 * @method static void TagTable($aData, $aHeaders=[], $aAttr=[])
 * @method static void TagInput($aAttrs=[])
 * @method static void TagDiv($sContent, $aAttrs=[])
 * @method static void TagDivGrid($aGrid, $aAttrs=[], $aRowsAttrs=[], $aColsAttrs=[])
 * @method static void TagSelect($aList, $aAttr=[])
 * @method static void TagForm($aAttrs=[], $aItemAttrs=[], $aItems=[])
 * @method static void TagFormBegin(...$aArgs)
 * @method static void TagFormEnd(...$aArgs)
 * @method static void TagUl(...$aArgs)
 * @method static void TagScript(...$aArgs)
 * @method static void TagLink(...$aArgs)
 * @method static void TagInclude(...$aArgs)
 */
class HTML extends BaseHTML
{
    public static $aVars = [];
    public static $sCalledClass = "";
    public static $sNamespace = 'Hightemp\WappFramework\Modules\Core\Lib\Tags\\';
}