<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Models;

abstract class CRUDModel extends BaseModel
{
    // NOTE: [!] Additional
    function fnGenerateFilterRules($aFilterRules)
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

    function fnGenerateFilterRulesForSearch($sSearch)
    {
        $aSQL = [];

        foreach (static::COLUMNS as $sColumnName => $sColumnClass) {
            $aSQL[] = "{$sColumnName} LIKE '%{$sSearch}%'";
        }

        return join(" OR ", $aSQL);
    }

    function fnGenerateFilterRulesForFilter($sFilter)
    {
        $aSQL = [];

        $aFilter = json_decode($sFilter);

        foreach ($aFilter as $sColumnName => $sFilter) {
            if (isset(static::COLUMNS[$sColumnName])) {
                $aSQL[] = "{$sColumnName} LIKE '%{$sFilter}%'";
            }
        }

        return join(" OR ", $aSQL);
    }
    

    function fnPagination($iPage, $iRows, $bUseOffset=false)
    {
        if ($bUseOffset) return " LIMIT {$iPage}, {$iRows}";
        $iF = ($iPage-1)*$iRows;
        return " LIMIT {$iF}, {$iRows}";
    }

    function fnGetTableInfo($aParams=[])
    {
        $aColumns = array_map(function($sC) { return [
            "title" => $sC::P_TITLE,
            "field" => "",
            "comment" => $sC::P_COMMENT,
            "type" => $sC::TYPE,
            "sortable" => $sC::P_SORTABLE,
            "sort-order" => $sC::P_SORT_ORDER,
            "filter-control" => "input",
        ]; }, static::COLUMNS);

        foreach ($aColumns as $sK => $mV) {
            $aColumns[$sK]["field"] = $sK;
        }

        foreach (static::RELATIONS as $aR) {
            $sK = $aR[1]::TABLE_NAME;
            $aColumns[$sK] = [
                "title" => $sK,
                "field" => "",
                "comment" => '',
                "filter-control" => "input",
            ];
        }

        return [
            "sIndexField" => static::C_INDEX_FIELD,
            "aColumns" => array_values($aColumns),
        ];
    }

    // NOTE: List with pagination and filter
    function fnListWithPagination($aParams=[], $bUseTags=null)
    {
        $sFilterRules = " 1 = 1";
        $sSort = " ORDER BY id DESC";
        $sOffset = "";

        if (isset($aParams['filterRules']) && $aParams['filterRules']) {
            $aParams['filterRules'] = json_decode($aParams['filterRules']);
            $sFilterRules = $this->fnGenerateFilterRules($aParams['filterRules']);
        }

        if (isset($aParams['search']) && $aParams['search']) {
            $sFilterRules = $this->fnGenerateFilterRulesForSearch($aParams['search']);
        }

        if (isset($aParams['filter']) && $aParams['filter']) {
            $sFilterRules = $this->fnGenerateFilterRulesForFilter($aParams['filter']);
        }

        if (isset($aParams['offset'])) {
            if (isset($aParams['limit']) && $aParams['limit'] > 0) {
                $sOffset = $this->fnPagination($aParams['offset'], $aParams['limit'], true);
            }
        } else {
            $sOffset = $this->fnPagination($aParams['page'], $aParams['rows'], false);
        }

        if (isset($aParams['sort'])) {
            $sSort = " ORDER BY ".$aParams['sort'];
            $sOrder = "DESC";

            if (isset($aParams['order'])) {
                $sSort = $sSort." ".(strtolower($aParams['order'][0]) == 'd' ? "DESC" : "ASC");
            }
        }

        $aResult = [];

        $aItems = $this->findAllExt("{$sFilterRules} {$sSort} {$sOffset}", []);
        $aResult['total'] = $this->count("{$sFilterRules}");
        $aResult['totalNotFiltered'] = $this->count("1 = 1");

        // if ((is_null($bUseTags) && $this->$bUseTags) || $bUseTags === true) {
        //     foreach ($aItems as $oItem) {
        //         $oItem->tags = $this->fnGetTagsAsStringList($oItem->id, $this->isset($sTableName)) ?: '';
        //     }
        // }

        $aResult['rows'] = array_values((array) $aItems);

        return $aResult;
    }

    // NOTE: List all
    function fnList($aParams=[])
    {
        $sID = static::C_INDEX_FIELD;
        $aItems = $this->findAllExt("ORDER BY {$sID} DESC", []);
        return $aItems;
    }

    // NOTE: List last
    function fnListLast($aParams=[])
    {
        $sID = static::C_INDEX_FIELD;
        $aItems = $this->findAllExt("ORDER BY {$sID} DESC LIMIT ?", [isset($aParams['limit']) ?: '10']);
        return $aItems;
    }

    // NOTE: Get one
    function fnGetOne($aParams=[])
    {
        $sID = static::C_INDEX_FIELD;
        return $this->findOneByIDExt($aParams[$sID]);
    }

    // NOTE: Delete list
    function fnDelete($aIDs)
    {
        return $this->fnDeleteByIDs($aIDs);
    }

    // NOTE: Create
    function fnCreate($aParams)
    {
        return $this->create($aParams);
    }

    function fnCreateOrUpdate($aParams)
    {
        return $this->createOrUpdate($aParams);
    }

    // NOTE: Update
    function fnUpdate($aParams)
    {
        return $this->update($aParams);
    }
}