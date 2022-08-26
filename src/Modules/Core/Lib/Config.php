<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

use Hightemp\WappTestSnotes\Modules\Core\Helpers\Utils;
use Hightemp\WappTestSnotes\Project;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Database;
use Hightemp\WappTestSnotes\Modules\Core\Lib\DatabaseConnectionOptions;
class Config 
{
    const CONFIG_DIR_PATH = ROOT_PATH."/config/";
    const CONFIG_FILE_PATH = ROOT_PATH."/config.json";

    public static $aLoadedConfigFiles = [];
    public static $aConfig = [];

    public static function fnInit()
    {
        static::fnLoad();
    }

    public static function fnGetENVMode()
    {
        return getenv('ENV') ?: 'dev';
    }

    public static function fnGetConfigFileName($sENV=null)
    {
        return "config.".(is_null($sENV) ? static::fnGetENVMode() : $sENV).".php";
    }

    public static function fnGetConfigFilePath($sENV=null)
    {
        return static::CONFIG_DIR_PATH.static::fnGetConfigFileName($sENV);
    }

    public static function fnRequireConfig($sPath)
    {
        $aResult = require_once($sPath);
        static::$aLoadedConfigFiles[] = $sPath;
        return $aResult;
    }

    public static function fnLoadBaseConfig()
    {
        $aDefaultData = static::fnRequireConfig(static::fnGetConfigFilePath("default"));
        $aData = static::fnRequireConfig(static::fnGetConfigFilePath());

        $aData = array_replace_recursive($aDefaultData, $aData);
        static::$aConfig = array_replace_recursive(static::$aConfig, $aData);
    }

    public static function fnLoadModuleConfig($sModuleClass, $sENV=null)
    {
        $sPath = Utils::fnGetGlobalPathForClassModule($sModuleClass)."/config/";
        
        $sDefaultConfigFilePath = $sPath.static::fnGetConfigFileName("default");
        $sEnvConfigFilePath = $sPath.static::fnGetConfigFileName($sENV);

        if (!is_file($sDefaultConfigFilePath)) {
            return;
        }

        if (!is_file($sEnvConfigFilePath)) {
            return;
        }

        $aDefaultData = (array) static::fnRequireConfig($sDefaultConfigFilePath);
        $aData = (array) static::fnRequireConfig($sEnvConfigFilePath);

        $aData = array_replace_recursive($aDefaultData, $aData);
        static::$aConfig = array_replace_recursive(static::$aConfig, $aData);
    }

    public static function fnLoadModulesConfig($sENV=null)
    {
        foreach (Project::$aModules as $sModuleClass) {
            static::fnLoadModuleConfig($sModuleClass);
        }
    }

    public static function fnLoad()
    {
        static::fnLoadBaseConfig();
        static::fnLoadModulesConfig();
    }

    public static function fnLoadJSON()
    {
        if (is_file(static::CONFIG_FILE_PATH)) {
            static::$aConfig = json_decode(file_get_contents(static::CONFIG_FILE_PATH), true) ?: [];
        }
    }

    public static function fnSaveJSON()
    {
        file_put_contents(static::CONFIG_FILE_PATH, json_encode(static::$aConfig));
    }
}