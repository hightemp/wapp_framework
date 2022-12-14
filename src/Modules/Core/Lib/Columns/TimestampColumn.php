<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Columns;

use Hightemp\WappFramework\Modules\Core\Lib\BaseColumn;
use \DateTime;

class TimestampColumn extends BaseColumn
{
    const DB_TYPE = "TIMESTAMP";
    const TYPE = "timestamp";

    const P_DATETIME_FORMAT_PHP = "Y-m-d H:i:s";
    const P_DATETIME_FORMAT_SQL = "%Y-%m-%d %H:%i:%s";

    const B_HAS_DEFAULT_VALUE = true;

    public static function fnDefaultValue()
    {
        return new DateTime('1970-01-01');
    }

    public static function fnPrepareValue($mValue)
    {
        $oD = new DateTime();
        $oD->setTimestamp(strtotime($mValue));
        return $oD->format(static::P_DATETIME_FORMAT_PHP);
    }

    public static function fnExtractValue($mValue)
    {
        $oD = new DateTime();
        $oD->setTimestamp($mValue);
        return $oD;
    }
}