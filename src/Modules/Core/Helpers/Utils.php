<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Helpers;

class Utils {
    public static function fnIsCli()
    {
        return php_sapi_name() == "cli";
    }
}