<?php

namespace Hightemp\WappFramework\Modules\Core\Lib;

class BaseColumn
{
    const DB_TYPE = "";
    const TYPE = "";

    const P_AUTOICREMENT = false;
    const P_NULLABLE = false;
    const P_CHARSET = "utf8mb4";
    const P_SIZE = 0;

    const P_SORTABLE = true;
    const P_SORT_ORDER = 'DESC';

    const P_TITLE = "";
    const P_COMMENT = "";

    const B_IS_PRIMARY_INDEX = false;
    const B_HAS_DEFAULT_VALUE = false;

    public static function fnDefaultValue()
    {
        return '';
    }

    public static function fnValidate($mValue)
    {
        return is_string($mValue);
    }

    public static function fnPrepareValue($mValue)
    {
        return $mValue;
    }

    public static function fnExtractValue($mValue)
    {
        return $mValue;
    }
}