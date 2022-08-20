<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Tags;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;

class TagForm extends BaseTag
{
    public static $aDefaultAttrs = [
        "class" => "",
        "style" => "",
        "action" => "",
        "method" => "post"
    ];

    public static $aDefaultItemWrapperAttrs = [
        "class" => "",
        "style" => "",
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

        $sID = time();
        BaseTag::fnBeginBuffer($sID);
        foreach ($aItems as $aItem) {
            $oTag = array_shift($aItem);
            $oTag(...$aItem);
        }
        $aResult = BaseTag::fnEndBuffer($sID);

        $aResult = array_map(function($sI) use ($aItemAttrs) {
            return static::fnRenderTag(static::T_DIV, false, $aItemAttrs, $sI);
        }, $aResult);

        $sHTML = static::fnRenderTag(static::T_FORM, false, $aAttrs, join("", $aResult));

        static::fnPrint($sHTML);
    }
}