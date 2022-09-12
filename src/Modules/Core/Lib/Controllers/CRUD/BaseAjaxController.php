<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Controllers\CRUD;

use Exception;
use Hightemp\WappFramework\Modules\CBootstrapTable\Helpers\Utils as HelpersUtils;
use Hightemp\WappFramework\Modules\Core\Lib\View;
use Hightemp\WappFramework\Modules\Core\Lib\BaseHTMLHelper;
use Hightemp\WappFramework\Modules\Core\Lib\View\Helpers\HTML;
use Request;
use \RedBeanPHP\OODBBean;

/**
 * Статический контроллер 
 * 
 * Нужен для работы с моделью стандартными действиями CRUD (create, read, update, delete).
 * Все действия выполняются на отдельных страницах.
 * 
 * #### Основные методы
 * 
 * * `info_json` `fnGetTableInfoJSON` - получение информации о таблице
 * * `list_all_json` `fnListJSON` - весь список
 * * `list_last_json` `fnListLastJSON` - получить последние элементы
 * * `list_json` `fnListWithPaginationJSON` - список с парамтерами и пагинацией
 * * `delete_json` `fnDeleteJSON` - удалить один элемент
 * * `delete_list_json` `fnDeleteListJSON` - удалить список
 * * `create_json` `fnCreateJSON` - создать элемент
 * * `update_json` `fnUpdateJSON` - обновить элемент
 * 
 * #### Дополнительные
 * 
 * * `fnGetAliasesList` - получить список ссылок
 * 
 * 
 */
class BaseAjaxController extends BaseController
{
    public static $aDefaultTemplates = [
        "fnListWithPaginationAjaxHTML" => ['tables/ajax/index.php', null, 'AJAX API таблицы'],
    ];

    // NOTE: Дополнительные методы

    /**
     * Подготовка опций для AJAX таблицы
     *
     * @param  string|BaseController $sControllerClass
     * @param  Request $oRequest
     * @param  array $aAttrs
     * 
     * @return array
     */
    public function fnPrepareVarsForAjaxTable()
    {
        $aTableData = [];

        // View::fnAddVars([ "bUseDefaultTableResponseHandler" => true ]);

        $aTableData["sID"] = static::$aTableAttrs['id'];

        // NOTE: Получение списка ссылок-методов для работы с таблицей
        $aTableData["aURLs"] = static::$aAliasesToMethods;
        $aTableData["aAttrs"] = static::$aTableAttrs;

        if (static::$aTableHeaders) {
            $aTableData["aHeaders"] = static::$aTableHeaders;
        } else {
            $sModelClass = $this->oModel::class;
            $aTableData["aHeaders"] = HelpersUtils::fnPrepareHeadersByColumns($sModelClass::COLUMNS);
            $aTableData["aHeaders"] = array_merge($aTableData["aHeaders"], HelpersUtils::fnPrepareHeadersByRelations($sModelClass::RELATIONS));
            $aTableData["aHeaders"][] = [
                "formatter" => "operateFormatter",
            ];
        }

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

    public function fnListWithPaginationAjaxHTML()
    {
        $aEntity = $this->fnPrepareVarsForAjaxTable(
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

    /**
     * fnGetTableInfoJSON
     *
     * @return array
     */
    public function fnGetTableInfoJSON()
    {
        $aList = $this->oModel->fnGetTableInfo($this->oRequest->aRequest);
        return $aList;
    }
    
    /**
     * 
     *
     * @return array
     */
    public function fnListJSON()
    {
        $aList = $this->oModel->fnList($this->oRequest->aRequest);
        return $aList;
    }
    
    /**
     * JSON Список с пагинацией
     *
     * @return array
     */
    public function fnListWithPaginationJSON()
    {
        $aList = $this->oModel->fnListWithPagination($this->oRequest->aRequest);
        return $aList;
    }

    public function fnListLastJSON()
    {
        $aList = $this->oModel->fnListLast($this->oRequest->aRequest);
        return $aList;
    }

    public function fnDeleteJSON()
    {
        $aList = $this->oModel->fnDelete([$this->oRequest->aRequest['id']]);
        return $aList;
    }

    public function fnDeleteListJSON()
    {
        $aList = $this->oModel->fnDelete($this->oRequest->aRequest['ids']);
        return $aList;
    }

    public function fnCreateJSON()
    {
        $oItem = $this->oModel->fnCreate($this->oRequest->aRequest);
        return $oItem;
    }

    public function fnUpdateJSON()
    {
        $oItem = $this->oModel->fnUpdate($this->oRequest->aRequest);
        return $oItem;
    }
}