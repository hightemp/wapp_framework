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
                ],
            ];
        }

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
        // $aAliases = $sControllerClass::fnGenerateAliases();

        $sAliasWithPaginationMethod = $sControllerClass::fnPrepareMethodNameForAlias("fnListWithPaginationJSON");

        $aAttrs = [
            "data-height" => "950",
            // "data-toolbar" => "#toolbar",
            "data-search" => "true",
            "data-show-refresh" => "true",
            "data-show-toggle" => "true",
            "data-show-fullscreen" => "true",
            "data-show-columns" => "true",
            "data-show-columns-toggle-all" => "true",
            "data-detail-view" => "true",
            "data-show-export" => "true",
            "data-click-to-select" => "true",
            "data-minimum-count-columns" => "2",
            "data-show-pagination-switch" => "true",

            "data-id-field" => "id",

            "data-pagination" => "true",
            "data-page-list" => "[10, 25, 50, 100, all]",
            "data-side-pagination" => "server",

            "data-show-footer" => "true",

            "data-url" => "/".$sAliasWithPaginationMethod,

            // "data-detail-formatter" => "detailFormatter",
            // "data-response-handler" => "responseHandler",

            ...$aAttrs
        ];

        View::fnAddVars([ "bUseDefaultTableResponseHandler" => true ]);

        $aTableData["aAttrs"] = $aAttrs;
        if ($aHeaders) {
            $aTableData["aHeaders"] = $aHeaders;
        } else {
            $aTableData["aHeaders"] = static::fnPrepareHeadersByColumns($sModelClass::COLUMNS);
        }

        return $aTableData;
    }
}