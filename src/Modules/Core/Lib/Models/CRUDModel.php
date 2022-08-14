<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Models;

use \RedBeanPHP\Facade as R;

abstract class CRUDModel extends BaseModel
{
    // NOTE: [!] Additional
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

    // NOTE: List with pagination and filter
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

        // if ((is_null($bUseTags) && static::$bUseTags) || $bUseTags === true) {
        //     foreach ($aItems as $oItem) {
        //         $oItem->tags = static::fnGetTagsAsStringList($oItem->id, static::$sTableName) ?: '';
        //     }
        // }

        $aResult['rows'] = array_values((array) $aItems);

        return $aResult;
    }

    // NOTE: List all
    static function fnList($aParams=[])
    {
        $aItems = static::findAll("ORDER BY id DESC", []);
        return $aItems;
    }

    // NOTE: List last
    static function fnListLast($aParams=[])
    {
        $aItems = static::findAll("ORDER BY id DESC LIMIT ?", [$aParams['limit'] ?? '10']);
        return $aItems;
    }

    // NOTE: Get one
    static function fnGetOne($aParams=[])
    {
        return static::findOneByID($aParams['id']);
    }

    // NOTE: Delete list
    static function fnDelete($aIDs)
    {
        return static::fnDeleteByIDs($aIDs);
    }

    // NOTE: Create
    static function fnCreate($aParams)
    {
        return R::create($aParams);
    }

    // NOTE: Update
    static function fnUpdate($aParams)
    {
        return R::update($aParams);
    }
}