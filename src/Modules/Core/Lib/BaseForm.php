<?php

namespace Hightemp\WappFramework\Modules\Core\Lib;

class BaseForm
{
    public const P_MODEL = null;

    /** @var string[] список полей */
    public static $aFields = [
        // "fields_name" => FieldClass::class
    ];

    function fnRender()
    {
        foreach (static::$aFields as $sField => $sClass) {

        }
    }

}