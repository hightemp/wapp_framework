<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

use Hightemp\WappTestSnotes\Modules\Core\Lib\MigrationLogger;
use Hightemp\WappTestSnotes\Modules\Core\Lib\DatabaseConnection;
use Hightemp\WappTestSnotes\Modules\Core\Lib\DatabaseConnectionOptions;

class Database
{
    /** @var DatabaseConnection[] $aDBConnections NOTE: Коллекция соединений к БД */
    public static $aDBConnections = [];

    public static $sDefaultConnectionKey = "default";
    public static $bInitialized = false;

    public static function fnInit()
    {
        // NOTE: Создаем БД соделинение из env
        $oO = new DatabaseConnectionOptions();

        $oO->sProtocol = getenv("DATABASE_PROTOCOL") ?? "";
        $oO->sDB = getenv("DATABASE_DB") ?? "";
        $oO->sHost = getenv("DATABASE_HOST") ?? "";
        $oO->sPort = getenv("DATABASE_PORT") ?? "";
        $oO->sSocket = getenv("DATABASE_SOCKET") ?? "";
        $oO->sCharset = getenv("DATABASE_CHARSET") ?? "";
        $oO->sUser = getenv("DATABASE_USER") ?? "";
        $oO->sPassword = getenv("DATABASE_PASSWORD") ?? "";

        Database::fnCreateDefaultConnection($oO);    
        
        static::$bInitialized = true;
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
