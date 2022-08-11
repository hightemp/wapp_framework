<?php

abstract class BaseModel
{
    static $sTableName = "";
    static $sCategoriesTableName = "";
    static $sParentKey = "";
    static $sChildKey = "";

    static $bUseTags = false;

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

    /**
     * findChildrenFor
     *
     * @param  OODBBean $oNode
     * @param  string $sql
     * @param  array $bindings
     * @return OODBBean[]
     */
    static function findChildrenFor($oNode, $sql = NULL, $bindings = array())
    {
        return static::findChildren($oNode->id, $sql, $bindings);
    }

    static function findChildren($iParentID, $sql = NULL, $bindings = array())
    {
        $sParentKey = static::$sParentKey;

        $aResult =R::findAll(
            static::$sTableName, 
            "{$sParentKey} = ?".$sql,
            [$iParentID, ...$bindings]
        );

        return $aResult;
    }

    static function findOrCreate($like = array(), $sql = '', &$hasBeenCreated = false)
    {
        return R::findOrCreate(static::$sTableName, $like, $sql, $hasBeenCreated);
    }

    static function findOneCategory($sql = NULL, $bindings = array())
    {
        return R::findOne(static::$sCategoriesTableName, $sql, $bindings);
    }

    static function fnDeleteByIDs($aIDs)
    {
        R::trashBatch(static::$sTableName, $aIDs);
    }

    static function fnDeleteRecursiveByIDs($aIDs)
    {
        foreach ($aIDs as $iID) {
            $oNode = static::findOneByID($iID);
            $aChildren = static::findChildrenFor($oNode);
            if ($aChildren) {
                static::fnDeleteRecursiveByObjects($aChildren);
            }
        }

        R::trashBatch(static::$sTableName, $aIDs);
    }

    static function fnDeleteRecursiveByObjects($aNodes)
    {
        foreach ($aNodes as $oNode) {
            $aChildren = static::findChildrenFor($oNode);
            if ($aChildren) {
                static::fnDeleteRecursiveByObjects($aChildren);
            }
        }

        R::trashAll($aNodes);
    }

    static function fnSetTagsTo($oBean, $aTags)
    {
        Tags::fnSetTagsFor($oBean->id, static::$sTableName, $aTags);
    }

    static function fnSetTags($iContentID, $aTags)
    {
        Tags::fnSetTagsFor($iContentID, static::$sTableName, $aTags);
    }

    static function fnGetTagsAsStringList($iContentID)
    {
        return Tags::fnGetTagsAsStringListFor($iContentID, static::$sTableName)  ?: '';
    }

    static function fnGetCurrentDateTime()
    {
        return date("Y-m-d H:i:s");
    }

    static function fnGetCurrentTimestamp()
    {
        return time();
    }

    static function fnExportToCSV()
    {
        $sT = static::$sTableName;
        R::csv("SELECT * FROM {$sT} ORDER BY id DESC");
    }

    static function fnGenerateFilterRules($aFilterRules)
    {
        $sSQL = "";

        foreach ($aFilterRules as $aRule) {
            $aRule = (array) $aRule;
            if ($aRule["op"] == "contains") {
                $sSQL .= " {$aRule["field"]} LIKE '%{$aRule["value"]}%' ";
            }
        }

        return $sSQL;
    }

    static function fnPagination($iPage, $iRows)
    {
        $iF = ($iPage-1)*$iRows;
        return " LIMIT {$iF}, {$iRows}";
    }

    static function fnListWithPagination($aParams=[], $bUseTags=null)
    {
        $sFilterRules = " 1 = 1";
        if (isset($aParams['filterRules'])) {
            $aParams['filterRules'] = json_decode($aParams['filterRules']);
            $sFilterRules = static::fnGenerateFilterRules($aParams['filterRules']);
        }

        $sOffset = static::fnPagination($aParams['page'], $aParams['rows']);
        $aResult = [];

        $aItems = static::findAll("{$sFilterRules} ORDER BY id DESC {$sOffset}", []);
        $aResult['total'] = static::count("{$sFilterRules}");

        if ((is_null($bUseTags) && static::$bUseTags) || $bUseTags === true) {
            foreach ($aItems as $oItem) {
                $oItem->tags = static::fnGetTagsAsStringList($oItem->id, static::$sTableName) ?: '';
            }
        }

        $aResult['rows'] = array_values((array) $aItems);

        return $aResult;
    }

    static function fnList($aParams=[])
    {
        $aItems = static::findAll("ORDER BY id DESC", []);
        return $aItems;
    }

    // abstract static function fnCreate($aParams=[]);
    // abstract static function fnUpdate($aParams=[]);
    // abstract static function fnDelete(array $aIDs);
    // abstract static function fnDeleteRecursive($aIDs);
    // abstract static function fnList($aParams=[]);
    // abstract static function fnListForCategory($aParams=[]);
    // abstract static function fnGetOne($aParams=[], $bAddAdditionalFields=true);
}