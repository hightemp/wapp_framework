<?php

namespace Hightemp\WappFramework\Modules\CBootstrapTable\Helpers;

use Hightemp\WappFramework\Project;
use Hightemp\WappFramework\Modules\Core\Lib\Models\BaseModel;
use Hightemp\WappFramework\Modules\Core\Lib\View;
use Hightemp\WappFramework\Modules\Core\Lib\Request;
use Hightemp\WappFramework\Modules\Core\Lib\Controllers\CRUDController;

class Utils 
{
    /**
     * Этот метод нужен для подготовки данных для передачи в хелпер в шаблоне для построения таблицы
     * Для фильра и колонок нужно передача парметров запроса
     * 
     * @param BaseModel $oModel
     * @param Request $oRequest
     * 
     * @return array
     */
    public static function fnPrepareModelDataForTable($oModel, $oRequest=null, $aAttrs=[])
    {
        $aTableData = [];

        $aItems = $oModel->findAll();

        $aTableData["aData"] = $aItems;
        $aTableData["aHeaders"] = array_keys($oModel->fnGetColumns());
        $aTableData["aAttrs"] = [
            ...$aAttrs
        ];

        return $aTableData;
    }

    public static function fnPrepareHeadersByColumns($aColumns)
    {
        $aResult = [];

        foreach ($aColumns as $sK => $sClass) {
            $aResult[] = [
                $sClass::P_TITLE ?: $sK,
                [ 
                    "data-field" => $sK,
                    "data-sortable" => "true",
                    "data-filter-control" => "input",
                ],
            ];
        }

        return $aResult;
    }

    public static function fnPrepareHeadersByRelations($aRelations)
    {
        $aResult = [];

        foreach ($aRelations as $iI => $aInfo) {
            $aResult[] = [
                $aInfo[1]::TABLE_NAME,
                [ 
                    "data-field" => $aInfo[1]::fnGetTableID(),
                    "data-sortable" => "true",
                    "data-filter-control" => "input",
                ],
            ];
        }

        return $aResult;
    }

    public static function fnPrepareHeadersByColumnsShort($aColumns)
    {
        $aResult = [];

        foreach ($aColumns as $sK => $sClass) {
            $aResult[] = $sK;
        }

        return $aResult;
    }

    public static function fnPrepareHeadersByRelationsShort($aRelations)
    {
        $aResult = [];

        foreach ($aRelations as $iI => $aInfo) {
            $aResult[] = $aInfo[1]::TABLE_NAME;
        }

        return $aResult;
    }
}