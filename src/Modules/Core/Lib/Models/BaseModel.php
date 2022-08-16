<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Models;

use \Hightemp\WappTestSnotes\Modules\Core\Lib\ModelExtensions\TraitExportToCSV;
use \Hightemp\WappTestSnotes\Modules\Core\Lib\Database;
use Hightemp\WappTestSnotes\Modules\Core\Lib\DatabaseConnection;

abstract class BaseModel
{
    // use TraitExportToCSV;

    /** @var string TABLE_NAME таблица бд класса */
    public const TABLE_NAME = "";
    /** @var bool $bUseTags соединение к бд */
    public static $bUseTags = false;

    /** @var DatabaseConnection $oDBCon соединение к бд */
    public $oDBCon = null;

    public static function fnBuild($sConKey=null)
    {
        $oDBCon = Database::fnGetConnection($sConKey);
        return new static($oDBCon);
    }

    function __construct(DatabaseConnection $oDBCon)
    {
        $this->oDBCon = $oDBCon;
    }

    function fnGetTableName()
    {
        return static::TABLE_NAME;
    }

    function count($sql = NULL, $bindings = array())
    {
        return $this->oDBCon->count($this->fnGetTableName(), $sql, $bindings);
    }

    function dispense($num = 1, $alwaysReturnArray = FALSE)
    {
        return $this->oDBCon->dispense($this->fnGetTableName(), $num, $alwaysReturnArray);
    }

    function findOne($sql = NULL, $bindings = array())
    {
        return $this->oDBCon->findOne($this->fnGetTableName(), $sql, $bindings);
    }

    function findOneByID($iID, $sql = "1=1", $bindings = array())
    {
        return $this->oDBCon->findOne($this->fnGetTableName(), "id = ? AND ".$sql, [$iID, ...$bindings]);
    }

    function findAll($sql = NULL, $bindings = array())
    {
        return $this->oDBCon->findAll($this->fnGetTableName(), $sql, $bindings);
    }

    function findAllByID($aIDs, $sql = "1=1", $bindings = array())
    {
        $sS = str_repeat('?,', count($aIDs) - 1) . '?';
        return $this->oDBCon->findAll($this->fnGetTableName(), "id IN ($sS) AND ".$sql, [...$aIDs, ...$bindings]);
    }

    function findOrCreate($like = array(), $sql = '', &$hasBeenCreated = false)
    {
        return $this->oDBCon->findOrCreate($this->fnGetTableName(), $like, $sql, $hasBeenCreated);
    }

    function trashBatch($aIDs)
    {
        return $this->oDBCon->trashBatch($this->fnGetTableName(), $aIDs);
    }

    function trashAll($aIDs)
    {
        return $this->oDBCon->trashAll($aIDs);
    }

    function create($aData=[])
    {
        $oItem = $this->oDBCon->dispense($this->fnGetTableName());

        if ($aData) {
            $this->update($aData, $oItem);
        }

        return $oItem;
    }

    function update($aData=[], $oItem=null)
    {
        if (!$oItem) {
            $oItem = $this->oDBCon->findForUpdate($this->fnGetTableName(), "id = ?", [$aData["id"]]);
        }

        $oItem->import($aData);
        $this->oDBCon->store($oItem);
    }

    function fnDeleteByIDs($aIDs)
    {
        $this->oDBCon->trashBatch($this->fnGetTableName(), $aIDs);
    }

    function fnGetCurrentDateTime()
    {
        return date("Y-m-d H:i:s");
    }

    function fnGetCurrentTimestamp()
    {
        return time();
    }
}