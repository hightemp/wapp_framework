<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;


use Hightemp\WappTestSnotes\Modules\Core\Lib\Database\Adapters\RedBeans;

class DatabaseConnection
{
    public $sDeafultAdapterClass = RedBeans::class;
    public $sAdapterClass = null;
    public $oAdapter = null;

    public function __construct(DatabaseConnectionOptions $oDBOptions, $sAdapterClass=null)
    {
        $this->sAdapterClass = $sAdapterClass ?: $this->sDeafultAdapterClass;
        $this->oAdapter = new $this->sAdapterClass($oDBOptions);
    }

    public function close()
    {
        $this->oAdapter->close();
    }

    // NOTE: Базовые для RedBeanPHP методы
    public function count($type, $addSQL = '', $bindings = array())
    {
        return $this->oAdapter->count($type, $addSQL, $bindings);
    }

    public function dispense($typeOrBeanArray, $num = 1, $alwaysReturnArray = FALSE)
    {
        return $this->oAdapter->dispense($typeOrBeanArray, $num, $alwaysReturnArray);
    }

    public function findOne($type, $sql = NULL, $bindings = array())
    {
        return $this->oAdapter->findOne($type, $sql, $bindings);
    }

    public function findAll($type, $sql = NULL, $bindings = array())
    {
        return $this->oAdapter->findAll($type, $sql, $bindings);
    }

    public function findOrCreate($type, $like = array(), $sql = '', &$hasBeenCreated = false)
    {
        return $this->oAdapter->findOrCreate($type, $like, $sql, $hasBeenCreated);
    }

    public function getAll($sql, $bindings = array())
    {
        return $this->oAdapter->getAll($sql, $bindings);
    }

    public function wipe($beanType)
    {
        return $this->oAdapter->wipe($beanType);
    }

    public function trashBatch($type, $ids)
    {
        return $this->oAdapter->trashBatch($type, $ids);
    }

    public function trashAll($beans)
    {
        return $this->oAdapter->trashAll($beans);
    }

    public function findForUpdate($type, $sql = NULL, $bindings = array())
    {
        return $this->oAdapter->findForUpdate($type, $sql, $bindings);
    }

    public function store($bean, $unfreezeIfNeeded = FALSE)
    {
        return $this->oAdapter->store($bean, $unfreezeIfNeeded);
    }

    public function csv($sql = '', $bindings = array(), $columns = NULL, $path = '/tmp/redexport_%s.csv', $output = TRUE)
    {
        return $this->oAdapter->csv($sql, $bindings, $columns, $path, $output);
    }
}
