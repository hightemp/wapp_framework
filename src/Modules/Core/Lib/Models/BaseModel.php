<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Models;

use Hightemp\WappTestSnotes\Modules\Core\Lib\ModelExtensions\TraitExportToCSV;

use \RedBeanPHP\Facade as R;

abstract class BaseModel
{
    use TraitExportToCSV;

    public static $sTableName = "";

    public static $bUseTags = false;

    static function count($sql = NULL, $bindings = array())
    {
        return R::count(static::$sTableName, $sql, $bindings);
    }

    static function dispense($num = 1, $alwaysReturnArray = FALSE)
    {
        return R::dispense(static::$sTableName, $num, $alwaysReturnArray);
    }

    static function findOne($sql = NULL, $bindings = array())
    {
        return R::findOne(static::$sTableName, $sql, $bindings);
    }

    static function findOneByID($iID, $sql = "1=1", $bindings = array())
    {
        return R::findOne(static::$sTableName, "id = ? AND ".$sql, [$iID, ...$bindings]);
    }

    static function findAll($sql = NULL, $bindings = array())
    {
        return R::findAll(static::$sTableName, $sql, $bindings);
    }

    static function findAllByID($aIDs, $sql = "1=1", $bindings = array())
    {
        $sS = str_repeat('?,', count($aIDs) - 1) . '?';
        return R::findAll(static::$sTableName, "id IN ($sS) AND ".$sql, [...$aIDs, ...$bindings]);
    }

    static function findOrCreate($like = array(), $sql = '', &$hasBeenCreated = false)
    {
        return R::findOrCreate(static::$sTableName, $like, $sql, $hasBeenCreated);
    }

    static function fnDeleteByIDs($aIDs)
    {
        R::trashBatch(static::$sTableName, $aIDs);
    }

    static function fnGetCurrentDateTime()
    {
        return date("Y-m-d H:i:s");
    }

    static function fnGetCurrentTimestamp()
    {
        return time();
    }

    static function create($aData=[])
    {
        $oItem = R::dispense(static::$sTableName);

        if ($aData) {
            static::update($aData, $oItem);
        }

        return $oItem;
    }

    static function update($aData=[], $oItem=null)
    {
        if (!$oItem) {
            $oItem = R::findForUpdate(static::$sTableName, "id = ?", [$aData["id"]]);
        }

        $oItem->import($aData);
        R::store($oItem);
    }

    // abstract static function fnCreate($aParams=[]);
    // abstract static function fnUpdate($aParams=[]);
    // abstract static function fnDelete(array $aIDs);
    // abstract static function fnDeleteRecursive($aIDs);
    // abstract static function fnList($aParams=[]);
    // abstract static function fnListForCategory($aParams=[]);
    // abstract static function fnGetOne($aParams=[], $bAddAdditionalFields=true);
}