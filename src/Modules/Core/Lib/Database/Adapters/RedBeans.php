<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Database\Adapters;

use Hightemp\WappFramework\Modules\Core\Lib\DatabaseConnectionOptions;
use Hightemp\WappFramework\Modules\Core\Lib\MigrationLogger;
use RedBeanPHP\Facade as R;

class RedBeans extends BaseAdapter
{
    const SQL_MIGRATIONS_PATH = ROOT_PATH."/sql/";
    const SQL_MIGRATIONS_DATE_FORMAT = 'Y_m_d__H_i_s';

    const DATABASE_ORM_CLASS = R::class;
    const DATABASE_ORM_NAMESPACE = "\\RedBeanPHP\\";

    /** string[] $aErrorsList список полученных ошибок */
    public $aErrorsList = [];

    public $oDBOptions = null;
    public $oDBAdapter = null;

    public function fnPrepareMigration()
    {
        $sF = sprintf(static::SQL_MIGRATIONS_PATH.'migration_%s.sql', date(static::SQL_MIGRATIONS_DATE_FORMAT));
        $oMigrationLogger = new MigrationLogger($sF);

        R::getDatabaseAdapter()
            ->getDatabase()
            ->setLogger($oMigrationLogger)
            ->setEnableLogging(TRUE);
    }

    public function __construct(DatabaseConnectionOptions $oDBOptions)
    {
        $this->oDBOptions = $oDBOptions;

        $sDSN = $oDBOptions->fnPrepareDSN();

        if (!is_file($oDBOptions->sDB)) {
            file_put_contents($oDBOptions->sDB, '');
        }

        R::setup($sDSN, $oDBOptions->sUser, $oDBOptions->sPassword, false);

        if(!R::testConnection()) throw new \Exception("<h1>No db connection</h1>");
    }

    public function close()
    {
        R::close();
    }

    // NOTE: Базовые для RedBeanPHP методы
    public function count($type, $addSQL = '', $bindings = array())
    {
        return R::count($type, $addSQL, $bindings);
    }

    public function dispense($typeOrBeanArray, $num = 1, $alwaysReturnArray = FALSE)
    {
        return R::dispense($typeOrBeanArray, $num, $alwaysReturnArray);
    }

    public function findOne($type, $sql = NULL, $bindings = array())
    {
        return R::findOne($type, $sql, $bindings);
    }

    public function findLike($type, $like=[], $sql='', $bindings=[])
    {
        return R::findLike($type, $like, $sql, $bindings);
    }

    public function findAll($type, $sql = NULL, $bindings = array())
    {
        return R::findAll($type, $sql, $bindings);
    }

    public function findOrCreate($type, $like = array(), $sql = '', &$hasBeenCreated = false)
    {
        return R::findOrCreate($type, $like, $sql, $hasBeenCreated);
    }

    public function getAll($sql, $bindings = array())
    {
        return R::getAll($sql, $bindings);
    }

    public function nuke()
    {
        return R::nuke();
    }

    public function wipe($beanType)
    {
        return R::wipe($beanType);
    }

    public function trashBatch($type, $ids)
    {
        return R::trashBatch($type, $ids);
    }

    public function trashAll($beans)
    {
        return R::trashAll($beans);
    }

    public function findForUpdate($type, $sql = NULL, $bindings = array())
    {
        return R::findForUpdate($type, $sql, $bindings);
    }

    public function store($bean, $unfreezeIfNeeded = FALSE)
    {
        return R::store($bean, $unfreezeIfNeeded);
    }

    public function csv($sql = '', $bindings = array(), $columns = NULL, $path = '/tmp/redexport_%s.csv', $output = TRUE)
    {
        return R::csv($sql, $bindings, $columns, $path, $output);
    }
}