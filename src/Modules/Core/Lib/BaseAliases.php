<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

class BaseAliases
{
    /** 
     * @var string[] $aMethods методы для которые соотнесены с альясами 
     *
     * ```php
     * [
     *      "module/index" => [\Hightemp\WappTestSnotes\Modules\Module\Controllers\Index::class, 'fnIndexHTML'],
     * ]
     * ```
     **/
    public static $aMethods = [];

    /** 
     * @var string[] $aAutoloadMethods массив для автоматической загрузки методов (используется для API) 
     *
     * ```php
     * [
     *      "module/index" => [\Hightemp\WappTestSnotes\Modules\Module\Controllers\Index::class, 'fnIndexHTML'],
     * ]
     * ``` 
     **/
    public static $aAutoloadMethods = [];

    public static function fnPrepareAliases()
    {
        $aResult = static::$aMethods;

        foreach (static::$aAutoloadMethods as $sClass) {
            $aAliases = $sClass::fnGenerateAliases();
            $aResult = array_merge($aResult, $aAliases);
        }

        return $aResult;
    }
}