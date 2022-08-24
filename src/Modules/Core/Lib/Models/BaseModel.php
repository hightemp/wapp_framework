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

    public const C_INDEX_FIELD = "id";

    public const COLUMNS = [
        self::C_INDEX_FIELD => PrimaryIndexIntColumn::class,
    ];

    public const RELATIONS = [
        // ['Название столбца', RelationTypeClass::class, Table::class]
    ];

    public const PRIMARY_INDEXES = [
        self::C_INDEX_FIELD
    ];

    public const UNIQUE_INDEXES = [

    ];

    public const INDEXES = [

    ];

    /** @var DatabaseConnection $oDBCon соединение к бд */
    public $oDBCon = null;
    /** @var BaseAdapter $oAdapter */
    public $oAdapter = null;

    public static function fnBuild($sConKey=null)
    {
        $oDBCon = Database::fnGetConnection($sConKey);
        return new static($oDBCon);
    }

    public static function fnGetTableID()
    {
        return static::TABLE_NAME."_id";
    }

    public function fnGetColumnInfo($sField, &$mOutputValue)
    {
        if (isset(static::COLUMNS[$sField])) {
            $mOutputValue = static::COLUMNS[$sField];
            return true;
        }
        return false;
    }

    public function fnPrepareColumnDefaultValue($sField, &$mOutputValue)
    {
        if (isset(static::COLUMNS[$sField]) && !static::COLUMNS[$sField]::P_AUTOICREMENT) {
            $mOutputValue = static::COLUMNS[$sField];
            return true;
        }
        return false;
    }

    public function fnPrepareColumnValue($sField, $mInputValue, &$mOutputValue)
    {
        if (isset(static::COLUMNS[$sField])) {
            $mOutputValue = static::COLUMNS[$sField]::fnPrepareValue($mInputValue);
            return true;
        }
        return false;
    }

    public function fnExtractColumnValue($sField, $mInputValue, &$mOutputValue)
    {
        if (isset(static::COLUMNS[$sField])) {
            $mOutputValue = static::COLUMNS[$sField]::fnExtractValue($mInputValue);
            return true;
        }
        return false;
    }

    public function fnHasRelation($sClass)
    {
        
    }

    public function fnGetRelation($sClass)
    {
        
    }

    public function fnGetRelations()
    {
        
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
            if (!$this->fnPrepareColumnValue($sKey, $mValue, $aResult[$sKey])) {
                if (is_object($mValue)) {
                    $aResult[$sKey] = $mValue;
                }
            }
        }

        $aDiff = array_diff(array_keys(static::COLUMNS), array_keys($aResult));
        foreach ($aDiff as $sKey) {
            $this->fnPrepareColumnDefaultValue($sKey, $aResult[$sKey]);
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
            if (!$this->fnExtractColumnValue($sKey, $mValue, $aResult[$sKey])) {
                //
            }
        }

        $aDiff = array_diff(array_keys(static::COLUMNS), array_keys($aResult));
        foreach ($aDiff as $sKey) {
            $this->fnPrepareColumnDefaultValue($sKey, $aResult[$sKey]);
            if (!$this->fnExtractColumnValue($sKey, $mValue, $aResult[$sKey])) {
                //
            }
        }

        return $aResult;
    }

    // NOTE: конструктор
    function __construct(DatabaseConnection $oDBCon)
    {
        $this->oDBCon = $oDBCon;
        $this->oAdapter = $this->oDBCon->oAdapter;
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
        return $this->oAdapter->count($this->fnGetTableName(), $sql, $bindings);
    }

    function dispense($num = 1, $alwaysReturnArray = FALSE)
    {
        return $this->oAdapter->dispense($this->fnGetTableName(), $num, $alwaysReturnArray);
    }

    function findOneExt($sql = NULL, $bindings = array())
    {
        return $this->fnExtractRowData($this->findOne($sql, $bindings));
    }

    function findOne($sql = NULL, $bindings = array())
    {
        return $this->oAdapter->findOne($this->fnGetTableName(), $sql, $bindings);
    }

    function findOneByIDExt($iID, $sql = "1=1", $bindings = array())
    {
        return $this->fnExtractRowData($this->findOne($sql, [...$bindings]));
    }

    function findOneByID($iID, $sql = "1=1", $bindings = array())
    {
        $sID = static::C_INDEX_FIELD;
        return $this->oAdapter->findOne($this->fnGetTableName(), "{$sID} = ? AND ".$sql, [$iID, ...$bindings]);
    }

    function findLikeExt($like=[], $sql='', $bindings=[])
    {
        return  $this->fnExtractData($this->findLike($like, $sql, $bindings));
    }

    function findLike($like=[], $sql='', $bindings=[])
    {
        return $this->oAdapter->findLike($this->fnGetTableName(), $like, $sql, $bindings);
    }

    function findAllExt($sql = NULL, $bindings = array())
    {
        return $this->fnExtractData($this->findAll($sql, $bindings));
    }

    function findAll($sql = NULL, $bindings = array())
    {
        return $this->oAdapter->findAll($this->fnGetTableName(), $sql, $bindings);
    }

    function findAllByID($aIDs, $sql = "1=1", $bindings = array())
    {
        $sID = static::C_INDEX_FIELD;
        $sS = str_repeat('?,', count($aIDs) - 1) . '?';
        return $this->findAll("{$sID} IN ($sS) AND ".$sql, [...$aIDs, ...$bindings]);
    }

    function findOrCreateExt($like = array(), $sql = '', &$hasBeenCreated = false)
    {
        return $this->fnExtractRowData($this->oAdapter->findOrCreate($this->fnGetTableName(), $like, $sql, $hasBeenCreated));
    }

    function findOrCreate($like = array(), $sql = '', &$hasBeenCreated = false)
    {
        return $this->findOrCreate($like, $sql, $hasBeenCreated);
    }

    function findForUpdateExt($sql = NULL, $bindings = array())
    {
        return $this->fnExtractRowData($this->oAdapter->findForUpdate($this->fnGetTableName(), $sql, $bindings));
    }

    function findForUpdate($sql = NULL, $bindings = array())
    {
        return $this->oAdapter->findForUpdate($sql, $bindings);
    }

    function store($bean, $unfreezeIfNeeded = FALSE)
    {
        return $this->oAdapter->store($bean, $unfreezeIfNeeded);
    }

    function getAll($sql, $bindings = array())
    {
        return $this->fnExtractData($this->oAdapter->getAll($sql, $bindings));
    }

    function wipe()
    {
        return $this->oAdapter->wipe($this->fnGetTableName());
    }

    function trashBatch($aIDs)
    {
        return $this->oAdapter->trashBatch($this->fnGetTableName(), $aIDs);
    }

    function trashAll($aIDs)
    {
        return $this->oAdapter->trashAll($aIDs);
    }

    // NOTE: Дополнительные методы - CRUD
    function create($aData=[])
    {
        $oItem = $this->dispense();

        $this->update($aData, $oItem);

        return $oItem;
    }

    function createOrUpdate($aData=[])
    {
        $aData = $this->fnPrepareRowData((array) $aData);
        
        $aList = $this->findLikeExt($aData);
        $oItem = null;

        if ($aList) {
            $oItem = $aList[0];
        } else {
            $oItem = $this->dispense();
        }

        $oItem->import($aData);
        $this->store($oItem);

        return $oItem;
    }

    function update($aData=[], $oItem=null)
    {
        $sID = static::C_INDEX_FIELD;

        if (!$oItem) {
            $oItem = $this->findForUpdate("{$sID} = ?", [$aData[$sID]]);
        }

        $aData = $this->fnPrepareRowData((array) $aData);
        $oItem->import($aData);
        $this->store($oItem);

        return $oItem;
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