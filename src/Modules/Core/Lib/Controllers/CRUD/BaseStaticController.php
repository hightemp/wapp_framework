<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Controllers\CRUD;

use Exception;
use Hightemp\WappFramework\Modules\CBootstrapTable\Helpers\Utils as HelpersUtils;
use Hightemp\WappFramework\Modules\Core\Lib\View;
use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;
use Hightemp\WappFramework\Modules\Core\Lib\View\Helpers\HTML;

/**
 * Статический контроллер 
 * 
 * Нужен для работы с моделью стандартными действиями CRUD (create, read, update, delete).
 * Все действия выполняются на отдельных страницах.
 * 
 * #### Основные методы
 * 
 * * `list_html` `fnListWithPaginationHTML` - Страница с таблицей с парамтерами и пагинацией
 * * `delete_html` `fnDeleteHTML` - HTML страница - удалить один элемент
 * * `delete_list_html` `fnDeleteListHTML` - HTML страница - удалить список
 * * `create_html` `fnCreateHTML` - HTML страница - создать элемент
 * * `update_html` `fnUpdateHTML` - HTML страница - обновить элемент
 * 
 * #### Дополнительные
 * 
 * * `fnGetAliasesList` - получить список ссылок
 * 
 * 
 */
class BaseStaticController extends BaseController
{
    public static $aLayout = [

    ];

    public static $aDefaultTemplates = [
        "fnListWithPaginationCrudHTML" => ['tables/static/index.php', null, 'Статическая CRUD таблица'],
    ];

    public static $aPanelButtons = [
        ["Добавить", '<i class="bi bi-plus"></i>', "fnCreateHTML"],
        ["Настроить вывод", '<i class="bi bi-tools"></i>', "fnOptionsHTML"],
    ];

    public static $aRowButtons = [
        ["Просмотр", '<i class="bi bi-eye"></i>', "fnViewHTML"],
        ["Редактировать", '<i class="bi bi-pencil-square"></i>', "fnUpdateHTML"],
        ["Удалить", '<i class="bi bi-trash"></i>', "fnDeleteHTML"],
    ];

    // NOTE: Дополнительные методы

    /**
     * fnPrepareVarsForStaticTable
     *
     * @param  string|CRUDController $sControllerClass
     * @param  string|CRUDModel $sModelClass
     * @param  Request $oRequest
     * @param  string[] $aHeaders
     * @param  string[] $aAttrs
     * @return array
     */
    public function fnPrepareVarsForStaticTable()
    {
        $aTableData = [];

        $aTableData["aData"] = $this->oModel->fnListWithPagination($this->oRequest->aRequest);

        // NOTE: Получение списка ссылок-методов для работы с таблицей
        $aTableData["aURLs"] = static::fnGetAliasesList();
        $aTableData["aAttrs"] = static::$aTableAttrs;

        if (static::$aTableHeaders) {
            $aTableData["aHeaders"] = static::$aTableHeaders;
        } else {
            $sModelClass = $this->oModel::class;
            $aTableData["aHeaders"] = HelpersUtils::fnPrepareHeadersByColumnsShort($sModelClass::COLUMNS);
            $aTableData["aHeaders"] = array_merge($aTableData["aHeaders"], HelpersUtils::fnPrepareHeadersByRelationsShort($sModelClass::RELATIONS));
        }

        $this->fnAddToDataCRUDActionsColumn($aTableData["aData"]['rows'], $aTableData["aHeaders"], $aTableData["aAttrs"]);
        $this->fnAddPagination($aTableData["aData"]);

        // HTML
        $aTableData["sPagination"] = HTML::TagPagination($aTableData['pagination']);
        $aTableData["sTable"] = HTML::TagTable(
            $aTableData['rows'], 
            $aTableData["aHeaders"], 
            $aTableData["aAttrs"]
        );
        $aTableData["sPanelButtons"] = $this->fnPrepareButtonsForPanel();

        return $aTableData;
    }

    public function fnPrepareURLForAction($sMethod, $aRow=[])
    {
        $sURL = $this->aMethodsToURLs[$sMethod];
        $aAttributes = [];
        if (isset($aRow["id"])) {
            $aAttributes = [ "id" => $aRow["id"] ];
        }
        $oURL = $this->oRequest->fnPrepareURL($sURL, $aAttributes, true);
        return (string) $oURL;
    }

    public function fnAddPagination(&$aData)
    {
        $aData["pagination"]["page_first"] = (string) $this->oRequest->fnPrepareURLFromCurrent([ "page" => "1" ]);
        if ($aData['current_page']-1>=1) {
            $aData["pagination"]["page_prev"] = (string) $this->oRequest->fnPrepareURLFromCurrent([ "page" => $aData['current_page']-1 ]);
        } else {
            $aData["pagination"]["page_prev"] = "#";
        }
        if ($aData['current_page']+1<=$aData['total_pages']) {
            $aData["pagination"]["page_next"] = (string) $this->oRequest->fnPrepareURLFromCurrent([ "page" => $aData['current_page']+1 ]);
        } else {
            $aData["pagination"]["page_next"] = "#";
        }
        $aData["pagination"]["page_last"] = (string) $this->oRequest->fnPrepareURLFromCurrent([ "page" => $aData['total_pages'] ]);

        $aData["pagination"]["current_page"] = $aData['current_page'];
        $aData["pagination"]["total_pages"] = $aData['total_pages'];
    }

    public function fnPrepareButtonsForRow($aRow)
    {
        BaseHTMLHelper::fnBeginBuffer();
        foreach (static::$aRowButtons as $aButton) {
            HTML::TagA(
                $aButton[1],
                $this->fnPrepareURLForAction($aButton[2], $aRow),
                [
                    "title" => $aButton[0],
                ]
            );
        }
        $aHTML = BaseHTMLHelper::fnEndBuffer();
        BaseHTMLHelper::fnBeginBuffer();
        HTML::TagDiv(join('', $aHTML), [ "class" => "table-actions" ]);
        $aHTML = BaseHTMLHelper::fnEndBuffer();
        return join('', $aHTML);
    }

    public function fnPrepareButtonsForPanel()
    {
        BaseHTMLHelper::fnBeginBuffer();
        foreach (static::$aPanelButtons as $aButton) {
            HTML::TagA(
                $aButton[1],
                $this->fnPrepareURLForAction($aButton[2]),
                [
                    "class" => "btn btn-secondary",
                    "title" => $aButton[0],
                ]
            );
        }
        $aHTML = BaseHTMLHelper::fnEndBuffer();
        BaseHTMLHelper::fnBeginBuffer();
        HTML::TagDiv(join('', $aHTML), [ "class" => "table-panel-actions" ]);
        $aHTML = BaseHTMLHelper::fnEndBuffer();
        return join('', $aHTML);
    }

    public function fnAddToDataCRUDActionsColumn(&$aData, &$aHeaders=[], &$aAttrs=[])
    {
        foreach ($aData as &$aRow) {
            $aRow["actions"] = static::fnPrepareButtonsForRow($aRow);
        }

        $aHeaders[] = "actions";
    }
    
    /**
     * HTML Страница с таблицей с пагинацией
     *
     * @return void
     */
    public function fnListWithPaginationCrudHTML()
    {
        $aEntity = $this->fnPrepareVarsForStaticTable(
            API::class,
            TestTable::class,
            $this->oRequest,
            [],
            [
                "id" => static::$sTableID
            ]
        );

        View::fnAddVars(["aEntity" => $aEntity]);
    }

    // NOTE: Основные методы CRUD

    public function fnDeleteHTML()
    {
        $this->fnDeleteJSON();
        $this->fnRedirectToRefer();
    }

    public function fnDeleteListHTML()
    {
        $this->fnDeleteListJSON();
        $this->fnRedirectToRefer();
    }

    public function fnOptionsHTML()
    {
        $this->fnRedirectBack();
    }

    public function fnCreateHTML()
    {
        $this->fnRedirectBack();
    }

    public function fnUpdateHTML()
    {
        $this->fnRedirectBack();
    }

    public function fnViewHTML()
    {
        $this->fnRedirectBack();
    }
}