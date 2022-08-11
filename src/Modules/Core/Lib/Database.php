<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

use Hightemp\WappTestSnotes\Modules\Core\Lib\MigrationLogger;
use RedBeanPHP\Facade as R;

class Database
{
    const SQL_MIGRATIONS_PATH = ROOT_PATH."/sql/";
    const SQL_MIGRATIONS_DATE_FORMAT = 'Y_m_d__H_i_s';

    public static function fnPrepareMigration()
    {
        $sF = sprintf(static::SQL_MIGRATIONS_PATH.'migration_%s.sql', date(static::SQL_MIGRATIONS_DATE_FORMAT));
        $oMigrationLogger = new MigrationLogger($sF);

        R::getDatabaseAdapter()
            ->getDatabase()
            ->setLogger($oMigrationLogger)
            ->setEnableLogging(TRUE);
    }
}
