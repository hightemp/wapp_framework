<?php

namespace Hightemp\WappFramework\Modules\Core\Lib;

use Hightemp\WappFramework\Modules\Core\Lib\MigrationLogger;
use Hightemp\WappFramework\Modules\Core\Lib\DatabaseConnection;
use Hightemp\WappFramework\Modules\Core\Lib\DatabaseConnectionOptions;
use Hightemp\WappFramework\Modules\Core\Lib\Config;

class Database
{
    /** @var DatabaseConnection[] $aDBConnections NOTE: Коллекция соединений к БД */
    public static $aDBConnections = [];

    public static $sDefaultConnectionKey = "default";
    public static $bInitialized = false;

    public static function fnInit()
    {
        // NOTE: Создаем БД соделинение из env
        
        static::fnCreateConnectionFromConfig();
        static::$bInitialized = true;
    }

    public static function fnCreateConnectionFromConfig($sKey=null)
    {
        $sKey = is_null($sKey) ? static::$sDefaultConnectionKey : $sKey;
        $oDBOptions = DatabaseConnectionOptions::fnBuildFromConfig($sKey);
        return static::fnCreateConnection($sKey, $oDBOptions);
    }

    public static function fnCreateConnection($sKey, DatabaseConnectionOptions $oDBOptions)
    {
        $oDBCon = new DatabaseConnection($oDBOptions);

        static::$aDBConnections[$sKey] = $oDBCon;

        return $oDBCon;
    }

    public static function fnCreateDefaultConnection(DatabaseConnectionOptions $oDBOptions)
    {
        return static::fnCreateConnection(static::$sDefaultConnectionKey, $oDBOptions);
    }

    public static function fnSetDefaultConnection($sKey)
    {
        static::$sDefaultConnectionKey = $sKey;
    }

    public static function fnGetDefaultConnection()
    {
        return static::$aDBConnections[static::$sDefaultConnectionKey];
    }

    public static function fnGetConnection($sKey=null)
    {
        if (!static::$bInitialized) {
            static::fnInit();
        }

        return $sKey ? static::$aDBConnections[$sKey] : static::$aDBConnections[static::$sDefaultConnectionKey];
    }

    public static function fnAddConnection($sKey, DatabaseConnection $oCon)
    {
        static::$aDBConnections[$sKey] = $oCon;
    }

    public static function fnCloseConnection($sKey)
    {
        static::$aDBConnections[$sKey]->close();
    }

    public static function fnRemoveConnection($sKey)
    {
        static::fnCloseConnection($sKey);
        unset(static::$aDBConnections[$sKey]);
    }
}
