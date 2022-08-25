<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers;

use Exception;
use Hightemp\WappTestSnotes\Modules\CBootstrapTable\Helpers\Utils as HelpersUtils;
use Hightemp\WappTestSnotes\Modules\Core\Helpers\Utils;
use Hightemp\WappTestSnotes\Project;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Request as LibRequest;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Response;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Responses\HTML as HTMLResponse;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Responses\JSON as JSONResponse;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Responses\NotFound as NotFoundResponse;
use Hightemp\WappTestSnotes\Modules\Core\Lib\View;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Tags\TagA;
use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseTag;
use Request;
use \RedBeanPHP\OODBBean;

/**
 * CRUDController - контроллер нужен для работы с моделью стандартными действиями CRUD (create, read, update, delete)
 * 
 * #### Основные методы
 * 
 * * `info_json` `fnGetTableInfoJSON` - получение информации о таблице
 * * `list_all_json` `fnListJSON` - весь список
 * * `list_last_json` `fnListLastJSON` - получить последние элементы
 * * `list_json` `fnListWithPaginationJSON` - список с парамтерами и пагинацией
 * * `list_html` `fnListWithPaginationHTML` - Страница с таблицей с парамтерами и пагинацией
 * * `delete_json` `fnDeleteJSON` - удалить один элемент
 * * `delete_list_json` `fnDeleteListJSON` - удалить список
 * * `create_json` `fnCreateJSON` - создать элемент
 * * `update_json` `fnUpdateJSON` - обновить элемент
 * * `delete_html` `fnDeleteHTML` - HTML страница - удалить один элемент
 * * `delete_list_html` `fnDeleteListHTML` - HTML страница - удалить список
 * * `create_html` `fnCreateHTML` - HTML страница - создать элемент
 * * `update_html` `fnUpdateHTML` - HTML страница - обновить элемент
 * 
 * #### Дополнительные
 * 
 * * `fnGetAliasesList` - получить список ссылок
 */
class CRUDController extends BaseController
{
    public static $sModelClass = '';

    /** @var CRUDModel $oModel - модель класса */
    public $oModel = null;

    public $aAliasesToMethods = [];
    public $aMethodsToAliases = [];

    public static $sTableID = "";
    public static $aTableAttrs = [];
    public static $aTableHeaders = [];

    public static $aDefaultTemplates = [
        "fnListWithPaginationAjaxHTML" => ['tables/ajax_table.php', null, 'Тест - ajax таблица'],
        "fnListWithPaginationCrudHTML" => ['tables/crud_table.php', null, 'Тест - crud таблица'],
    ];
        
    /**
     * Получаем список ссылок альясов для текущего контроллера
     *
     * @return string[]
     */
    public static function fnGetAliasesList()
    {
        $aResult = [];

        $aMethods = get_class_methods(static::class);

        array_map(function ($sMethod) use (&$aResult) {
            $sAlias = static::fnPrepareMethodNameForAlias($sMethod);

            if (!$sAlias) return;

            $sModMethod = static::fnPrepareMethodName($sMethod, "");

            if (!$sModMethod) return;

            $aResult[$sModMethod] = "/".$sAlias;
        }, $aMethods);

        return $aResult;
    }

    public function _fnBuildModel()
    {
        /** @var CRUDModel $oModel */
        $oModel = (static::$sModelClass)::fnBuild();
        return $oModel;
    }

    public function __construct($oRequest=new LibRequest(), $sViewClass=null)
    {
        parent::__construct($oRequest, $sViewClass);

        $this->oModel = $this->_fnBuildModel();
        $this->aAliasesToMethods = $this->fnGenerateAliases();
        $this->aMethodsToAliases = $this->fnGenerateMethodsAliasesList();
    }

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
            // $aTableData["aHeaders"] = static::fnPrepareHeadersByColumns($sModelClass::COLUMNS);
            // $aTableData["aHeaders"] = array_merge($aTableData["aHeaders"], static::fnPrepareHeadersByRelations($sModelClass::RELATIONS));
            // $aTableData["aHeaders"][] = [
            //     "formatter" => "operateFormatter",
            // ];
        }

        return $aTableData;
    }

    /**
     * fnPrepareVarsForCRUDTable
     *
     * @param  string|CRUDController $sControllerClass
     * @param  string|CRUDModel $sModelClass
     * @param  Request $oRequest
     * @param  string[] $aHeaders
     * @param  string[] $aAttrs
     * @return array
     */
    public function fnPrepareVarsForCRUDTable()
    {
        $aTableData = [];

        $aTableData["aData"] = $this->oModel->fnListWithPagination($this->oRequest->aPost);

        // NOTE: Получение списка ссылок-методов для работы с таблицей
        $aTableData["aURLs"] = static::fnGetAliasesList();
        $aTableData["aAttrs"] = static::$aTableAttrs;

        if (static::$aTableHeaders) {
            $aTableData["aHeaders"] = static::$aTableHeaders;
        } else {
            // $aTableData["aHeaders"] = static::fnPrepareHeadersByColumnsShort($sModelClass::COLUMNS);
            // $aTableData["aHeaders"] = array_merge($aTableData["aHeaders"], static::fnPrepareHeadersByRelationsShort($sModelClass::RELATIONS));
        }

        $this->fnAddToDataCRUDActionsColumn($aTableData["aData"]['rows'], $aTableData["aHeaders"], $aTableData["aAttrs"]);

        return $aTableData;
    }

    public function fnAddToDataCRUDActionsColumn(&$aData, &$aHeaders=[], &$aAttrs=[])
    {
        $oTagA = new TagA();

        foreach ($aData as &$aRow) {
            BaseTag::fnBeginBuffer();
            $oTagA('edit', $this->aMethodsToAliases['fnUpdateHTML'][0]);
            $oTagA('delete', $this->aMethodsToAliases['fnDeleteHTML'][0]);
            $aHTML = BaseTag::fnEndBuffer();
            $aRow["actions"] = join('', $aHTML);
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
        $aEntity = $this->fnPrepareVarsForCRUDTable(
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

    public function fnDeleteHTML()
    {

    }

    public function fnDeleteListHTML()
    {

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

    public function fnCreateHTML()
    {

    }

    public function fnUpdateHTML()
    {

    }
}