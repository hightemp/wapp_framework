<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Models;

use \Hightemp\WappTestSnotes\Modules\Core\Lib\ModelExtensions\TraitExportToCSV;
use \Hightemp\WappTestSnotes\Modules\Core\Lib\Database;
use \Hightemp\WappTestSnotes\Modules\Core\Lib\DatabaseConnection;
use \Hightemp\WappTestSnotes\Modules\Core\Lib\Columns\PrimaryIndexIntColumn;

abstract class BaseModel
{
    // use TraitExportToCSV;

    /** @var string TABLE_NAME таблица бд класса */
    public const TABLE_NAME = "";
    /** @var bool $bUseTags соединение к бд */
    public static $bUseTags = false;

    public const C_INDEX_ID = "id";

    public const COLUMNS = [
        self::C_INDEX_ID => PrimaryIndexIntColumn::class,
    ];

    public const PRIMARY_INDEXES = [
        self::C_INDEX_ID
    ];

    public const UNIQUE_INDEXES = [

    ];

    public const INDEXES = [

    ];

    /** @var DatabaseConnection $oDBCon соединение к бд */
    public $oDBCon = null;

    public static function fnBuild($sConKey=null)
    {
        $oDBCon = Database::fnGetConnection($sConKey);
        return new static($oDBCon);
    }

    public function fnFilterDataByColumns($aData)
    {
        $aResult = [];

        foreach ($aData as $sKey => $mValue) {
            if (isset(static::COLUMNS[$sKey])) {
                $aResult[$sKey] = $mValue;
            }
        }

        return $aResult;
    }

    public function fnPrepareRowData($aData)
    {
        $aResult = [];

        foreach ($aData as $sKey => $mValue) {
            if (isset(static::COLUMNS[$sKey])) {
                $aResult[$sKey] = static::COLUMNS[$sKey]::fnPrepareValue($mValue);
            }
        }

        $aDiff = array_diff(array_keys(static::COLUMNS), array_keys($aResult));
        foreach ($aDiff as $sKey) {
            $aResult[$sKey] = static::COLUMNS[$sKey]::fnDefaultValue();
        }

        return $aResult;
    }

    public function fnExtractData($aData)
    {
        if (!$aData) return $aData;

        $aResult = [];

        foreach ($aData as $aRow) {
            $aResult[] = $this->fnExtractRowData($aRow);
        }

        return $aResult;
    }

    public function fnExtractRowData($aData)
    {
        if (!$aData) return $aData;

        $aResult = [];

        foreach ($aData as $sKey => $mValue) {
            if (isset(static::COLUMNS[$sKey])) {
                $aResult[$sKey] = static::COLUMNS[$sKey]::fnExtractValue($mValue);
            }
        }

        $aDiff = array_diff(array_keys(static::COLUMNS), array_keys($aResult));
        foreach ($aDiff as $sKey) {
            $aResult[$sKey] = static::COLUMNS[$sKey]::fnDefaultValue();
        }

        return $aResult;
    }   

    function __construct(DatabaseConnection $oDBCon)
    {
        $this->oDBCon = $oDBCon;
    }

    public function fnGetColumns()
    {
        return static::COLUMNS;
    }

    function fnGetTableName()
    {
        return static::TABLE_NAME;
    }

    // NOTE: Базовые методы
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
        return $this->fnExtractRowData($this->oDBCon->findOne($this->fnGetTableName(), $sql, $bindings));
    }

    function findOneByID($iID, $sql = "1=1", $bindings = array())
    {
        $sID = static::C_INDEX_ID;
        return $this->fnExtractRowData($this->oDBCon->findOne($this->fnGetTableName(), "{$sID} = ? AND ".$sql, [$iID, ...$bindings]));
    }

    function findAll($sql = NULL, $bindings = array())
    {
        return $this->fnExtractData($this->oDBCon->findAll($this->fnGetTableName(), $sql, $bindings));
    }

    function findAllByID($aIDs, $sql = "1=1", $bindings = array())
    {
        $sID = static::C_INDEX_ID;
        $sS = str_repeat('?,', count($aIDs) - 1) . '?';
        return $this->findAll("{$sID} IN ($sS) AND ".$sql, [...$aIDs, ...$bindings]);
    }

    function findOrCreate($like = array(), $sql = '', &$hasBeenCreated = false)
    {
        return $this->fnExtractRowData($this->oDBCon->findOrCreate($this->fnGetTableName(), $like, $sql, $hasBeenCreated));
    }

    function findForUpdate($sql = NULL, $bindings = array())
    {
        return $this->fnExtractRowData($this->oDBCon->findForUpdate($this->fnGetTableName(), $sql, $bindings));
    }

    function store($bean, $unfreezeIfNeeded = FALSE)
    {
        return $this->oDBCon->store($bean, $unfreezeIfNeeded);
    }

    function getAll($sql, $bindings = array())
    {
        return $this->fnExtractData($this->oDBCon->getAll($sql, $bindings));
    }

    function wipe()
    {
        return $this->oDBCon->wipe($this->fnGetTableName());
    }

    function trashBatch($aIDs)
    {
        return $this->oDBCon->trashBatch($this->fnGetTableName(), $aIDs);
    }

    function trashAll($aIDs)
    {
        return $this->oDBCon->trashAll($aIDs);
    }

    // NOTE: Дополнительные методы - CRUD
    function create($aData=[])
    {
        $oItem = $this->dispense();

        $aData = $this->fnPrepareRowData((array) $aData);
        $this->update($aData, $oItem);

        return $oItem;
    }

    function update($aData=[], $oItem=null)
    {
        $sID = static::C_INDEX_ID;

        if (!$oItem) {
            $oItem = $this->findForUpdate("{$sID} = ?", [$aData[$sID]]);
        }

        $aData = $this->fnPrepareRowData((array) $aData);
        $oItem->import($aData);
        $this->store($oItem);
    }

    function fnDeleteByIDs($aIDs)
    {
        $this->trashBatch($aIDs);
    }

    // NOTE: Дополнительные методы
    function fnGetCurrentDateTime()
    {
        return date("Y-m-d H:i:s");
    }

    function fnGetCurrentTimestamp()
    {
        return time();
    }
}