<?php

namespace Hightemp\WappFramework\Modules\Core\Lib\Controllers\CRUD;

use Exception;
use Hightemp\WappFramework\Modules\Core\Lib\Controllers\BaseController as Base;
use Hightemp\WappFramework\Modules\Core\Lib\Request as LibRequest;

/**
 * CRUDController 
 * 
 * Базовые класс для классов наследников. Содержит базовые общие методы.
 * 
 */
class BaseController extends Base
{
    public static $sModelClass = '';

    /** @var CRUDModel $oModel - модель класса */
    public $oModel = null;

    public $aAliasesToMethods = [];
    public $aMethodsToAliases = [];
    public $aMethodsToURLs = [];

    public static $sTableID = "";
    public static $aTableAttrs = [];
    public static $aTableHeaders = [];

    public static $aDefaultTemplates = [
    ];

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
        $this->aMethodsToURLs = $this->fnGenerateMethodsURLsList();
    }

    // NOTE: Дополнительные методы

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
}