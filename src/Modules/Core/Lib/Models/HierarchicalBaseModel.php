<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Models;

/**
 * Модеь для работы с иерархическими данными
 */
abstract class HierarchicalBaseModel extends BaseModel
{
    // FIXME: Нужно переработать в Nested sets
    
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
    function findChildrenFor($oNode, $sql = NULL, $bindings = array())
    {
        return $this->findChildren($oNode->id, $sql, $bindings);
    }

    function findChildren($iParentID, $sql = NULL, $bindings = array())
    {
        $sParentKey = $this->sParentKey;

        $aResult = $this->oAdapter->findAll(
            static::TABLE_NAME,
            "{$sParentKey} = ?" . $sql,
            [$iParentID, ...$bindings]
        );

        return $aResult;
    }

    function findOneByRelation($sql = NULL, $bindings = array())
    {
        return $this->oAdapter->findOne($this->sParentTableName, $sql, $bindings);
    }

    function fnDeleteRecursiveByIDs($aIDs)
    {
        foreach ($aIDs as $iID) {
            $oNode = $this->findOneByID($iID);
            $aChildren = $this->findChildrenFor($oNode);
            if ($aChildren) {
                $this->fnDeleteRecursiveByObjects($aChildren);
            }
        }

        $this->trashBatch($aIDs);
    }

    function fnDeleteRecursiveByObjects($aNodes)
    {
        foreach ($aNodes as $oNode) {
            $aChildren = $this->findChildrenFor($oNode);
            if ($aChildren) {
                $this->fnDeleteRecursiveByObjects($aChildren);
            }
        }

        $this->trashAll($aNodes);
    }
}
