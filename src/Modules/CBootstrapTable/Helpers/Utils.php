<?php

namespace Hightemp\WappTestSnotes\Modules\CBootstrapTable\Helpers;

use Hightemp\WappTestSnotes\Project;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Models\BaseModel;

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
    
    /**
     * Подготовка опций для AJAX таблицы
     *
     * @param  string|BaseController $sControllerClass
     * @param  Request $oRequest
     * @param  array $aAttrs
     * 
     * @return array
     */
    public static function fnPrepareVarsForAjaxTable($sControllerClass, $oRequest=null, $aAttrs=[])
    {
        $aTableData = [];
        $aAliases = $sControllerClass::fnGenerateAliases();

        $sAliasWithPaginationMethod = $sControllerClass::fnPrepareMethodNameForAlias("fnListWithPaginationJSON");
        // $aListMethod = $aAliases[$sListMethod];

        $aAttrs = [
            "data-toolbar" => "#toolbar",
            "data-search" => "true",
            "data-show-refresh" => "true",
            "data-show-toggle" => "true",
            "data-show-fullscreen" => "true",
            "data-show-columns" => "true",
            "data-show-columns-toggle-all" => "true",
            "data-detail-view" => "true",
            "data-show-export" => "true",
            "data-click-to-select" => "true",
            "data-detail-formatter" => "detailFormatter",
            "data-minimum-count-columns" => "2",
            "data-show-pagination-switch" => "true",
            "data-pagination" => "true",
            "data-id-field" => "id",
            "data-page-list" => "[10, 25, 50, 100, all]",
            "data-show-footer" => "true",
            "data-side-pagination" => "server",
            "data-url" => "/".$sAliasWithPaginationMethod,
            "data-response-handler" => "responseHandler",
            ...$aAttrs
        ];

        $aTableData["aAttrs"] = $aAttrs;

        return $aTableData;
    }
}