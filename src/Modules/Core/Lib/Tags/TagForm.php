<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Tags;

use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;

class TagForm extends BaseHTMLHelper
{
    public static $aDefaultAttrs = [
        "class" => "",
        "style" => "",
        "action" => "",
        "method" => "post"
    ];

    public static $aDefaultItemWrapperAttrs = [
        "class" => "",
        "style" => "margin-top: 20px;",
    ];
    
    /**
     * TagForm
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

        BaseHTMLHelper::fnBeginBuffer();
        foreach ($aItems as $aItem) {
            $oTag = array_shift($aItem);
            $oTag(...$aItem);
        }
        $aResult = BaseHTMLHelper::fnEndBuffer();

        $aResult = array_map(function($sI) use ($aItemAttrs) {
            return static::fnRenderTag(static::T_DIV, false, $aItemAttrs, $sI);
        }, $aResult);

        $sHTML = static::fnRenderTag(static::T_FORM, false, $aAttrs, join("", $aResult));

        static::fnPrint($sHTML);
    }
}