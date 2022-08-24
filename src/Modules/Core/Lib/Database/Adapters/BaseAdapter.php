<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Database\Adapters;

use Hightemp\WappTestSnotes\Modules\Core\Lib\DatabaseConnectionOptions;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Exceptions\MethodNotDefinedException;

class BaseAdapter 
{
    const SQL_MIGRATIONS_PATH = ROOT_PATH."/sql/";
    const SQL_MIGRATIONS_DATE_FORMAT = 'Y_m_d__H_i_s';

    const DATABASE_ORM_CLASS = '';
    const DATABASE_ORM_NAMESPACE = "";

    /** string[] $aErrorsList список полученных ошибок */
    public $aErrorsList = [];

    public $oDBOptions = null;
    public $oDBAdapter = null;

    public function fnPrepareMigration()
    {
        throw new MethodNotDefinedException();
    }

    public function __construct(DatabaseConnectionOptions $oDBOptions)
    {
        throw new MethodNotDefinedException();
    }

    public function close()
    {
        throw new MethodNotDefinedException();
    }

    // NOTE: Базовые для RedBeanPHP методы
    public function count($type, $addSQL = '', $bindings = array())
    {
        throw new MethodNotDefinedException();
    }

    public function dispense($typeOrBeanArray, $num = 1, $alwaysReturnArray = FALSE)
    {
        throw new MethodNotDefinedException();
    }

    public function findOne($type, $sql = NULL, $bindings = array())
    {
        throw new MethodNotDefinedException();
    }

    public function findLike($type, $like=[], $sql='', $bindings=[])
    {
        throw new MethodNotDefinedException();
    }

    public function findAll($type, $sql = NULL, $bindings = array())
    {
        throw new MethodNotDefinedException();
    }

    public function findOrCreate($type, $like = array(), $sql = '', &$hasBeenCreated = false)
    {
        throw new MethodNotDefinedException();
    }

    public function getAll($sql, $bindings = array())
    {
        throw new MethodNotDefinedException();
    }

    public function nuke()
    {
        throw new MethodNotDefinedException();
    }

    public function wipe($beanType)
    {
        throw new MethodNotDefinedException();
    }

    public function trashBatch($type, $ids)
    {
        throw new MethodNotDefinedException();
    }

    public function trashAll($beans)
    {
        throw new MethodNotDefinedException();
    }

    public function findForUpdate($type, $sql = NULL, $bindings = array())
    {
        throw new MethodNotDefinedException();
    }

    public function store($bean, $unfreezeIfNeeded = FALSE)
    {
        throw new MethodNotDefinedException();
    }

    public function csv($sql = '', $bindings = array(), $columns = NULL, $path = '/tmp/redexport_%s.csv', $output = TRUE)
    {
        throw new MethodNotDefinedException();
    }
}