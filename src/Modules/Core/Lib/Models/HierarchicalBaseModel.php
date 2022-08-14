<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Models;

use \RedBeanPHP\Facade as R;

abstract class HierarchicalBaseModel extends BaseModel
{
    public static $sParentTableName = "";
    public static $sParentKey = "";
    public static $sChildKey = "";

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

        $aResult = R::findAll(
            static::$sTableName, 
            "{$sParentKey} = ?".$sql,
            [$iParentID, ...$bindings]
        );

        return $aResult;
    }

    static function findOneByRelation($sql = NULL, $bindings = array())
    {
        return R::findOne(static::$sParentTableName, $sql, $bindings);
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
}