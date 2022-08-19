<?php

namespace Hightemp\WappTestSnotes\Modules\CBootstrapTable\Helpers;

use Hightemp\WappTestSnotes\Project;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Models\BaseModel;
use Hightemp\WappTestSnotes\Modules\Core\Lib\View;
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

        $Result[] = [
            "formatter" => "operateFormatter",
        ];

        return $aResult;
    }
    
    /**
     * Подготовка опций для AJAX таблицы
     *
     * @param  string|BaseController $sControllerClass
     * @param  Request $oRequest
     * @param  array $aAttrs
     * 
     * @return array
     */
    public static function fnPrepareVarsForAjaxTable($sControllerClass, $sModelClass, $oRequest=null, $aHeaders=[], $aAttrs=[])
    {
        $aTableData = [];

        // View::fnAddVars([ "bUseDefaultTableResponseHandler" => true ]);

        $aTableData["sID"] = $aAttrs['id'];
        $aTableData["aURLs"] = $sControllerClass::fnGetAliasesList();
        $aTableData["aAttrs"] = $aAttrs;
        if ($aHeaders) {
            $aTableData["aHeaders"] = $aHeaders;
        } else {
            $aTableData["aHeaders"] = static::fnPrepareHeadersByColumns($sModelClass::COLUMNS);
        }

        return $aTableData;
    }
}