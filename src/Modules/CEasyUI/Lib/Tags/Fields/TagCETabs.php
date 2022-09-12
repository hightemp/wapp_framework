<?php

namespace Hightemp\WappFramework\Modules\CEasyUI\Lib\Tags\Fields;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;

class TagCETabs extends BaseHTMLHelper
{
    public static $aDefaultAttrs = [
        "class" => "easyui-tabs",
        "style" => "",
    ];

    public static $aDefaultItemWrapperAttrs = [
        "class" => "",
        "style" => "padding:10px;",
    ];
    
    /**
     * TagCETabs
     *
     * @param  string[] $aAttrs
     * @param  string[] $aItemAttrs
     * @param  mixed[][] $aItems - объект тэга с параматрами в том же массиве
     * @return void
     */
    public function __invoke($aAttrs=[], $aItemAttrs=[], $aItems=[])
    {
        $aAttrs = static::fnPrepareAttrs($aAttrs, static::$aDefaultAttrs);
        $aItemAttrs = static::fnPrepareAttrs($aItemAttrs, static::$aDefaultItemWrapperAttrs);

        $aResult = [];
        $aTitles = [];

        BaseHTMLHelper::fnBeginBuffer();
        foreach ($aItems as $iI => $mItem) {
            if (is_string($mItem)) {
                BaseHTMLHelper::fnAddToBuffer($mItem);
            } else {
                if (is_array($mItem)) {
                    $aTitles[$iI] = $mItem[0];
                    if (is_string($mItem[1])) { 
                        BaseHTMLHelper::fnAddToBuffer($mItem[1]);
                    } else {
                        $oTag = array_shift($mItem[1]);
                        $oTag(...$mItem[1]);
                    }
                }
            }
        }
        $aResult = BaseHTMLHelper::fnEndBuffer();

        $iI = 0;
        $aResult = array_map(function($sI) use ($aItemAttrs, $aTitles, &$iI) {
            return static::fnRenderTag(static::T_DIV, false, [...$aItemAttrs,...["title" => $aTitles[$iI++]]] , $sI);
        }, $aResult);

        $sHTML = static::fnRenderTag(static::T_DIV, false, $aAttrs, join("", $aResult));

        static::fnPrint($sHTML);
    }
}