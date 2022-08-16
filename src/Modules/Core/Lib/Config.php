<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

use Hightemp\WappTestSnotes\Modules\Core\Lib\Database;
use Hightemp\WappTestSnotes\Modules\Core\Lib\DatabaseConnectionOptions;
class Config 
{
    const CONFIG_FILE_PATH = ROOT_PATH."/config.json";

    public static $aSettings = [];

    public static function fnInit()
    {
        static::fnLoad();
    }

    public static function fnLoad()
    {
        if (is_file(static::CONFIG_FILE_PATH)) {
            static::$aSettings = json_decode(file_get_contents(static::CONFIG_FILE_PATH), true) ?: [];
        }
    }

    public static function fnSave()
    {
        file_put_contents(static::CONFIG_FILE_PATH, json_encode(static::$aSettings));
    }
}