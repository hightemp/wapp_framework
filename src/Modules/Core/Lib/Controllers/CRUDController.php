<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers;

use Exception;
use Hightemp\WappTestSnotes\Modules\Core\Helpers\Utils;
use Hightemp\WappTestSnotes\Project;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Request as LibRequest;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Response;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Responses\HTML as HTMLResponse;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Responses\JSON as JSONResponse;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Responses\NotFound as NotFoundResponse;
use Hightemp\WappTestSnotes\Modules\Core\Lib\View;
use Request;
use \RedBeanPHP\OODBBean;

class CRUDController extends BaseController
{
    public static $sModelClass = '';

    public static function fnGenerateAliases()
    {
        $aResult = [];

        $aMethods = get_class_methods(static::class);

        array_map(function ($sMethod) use (&$aResult) {
            $sReg = '/^fn(.*)(JSON|HTML)$/';
            
            if (!preg_match($sReg, $sMethod)) {
                return;
            }

            $sAlias = preg_replace($sReg, "$1", $sMethod);
            $sAlias = preg_replace_callback("/[A-Z]/", function ($aM) {
                return "_".strtolower($aM[0]);
            }, $sAlias);

            $sModule = Utils::fnExtractModuleName(static::class);
            $sModule = strtolower($sModule);

            $sAlias = $sModule.$sAlias;

            $aResult[$sAlias] = [static::class, $sMethod];
        }, $aMethods);

        return $aResult;
    }

    public function _fnBuildModel()
    {
        /** @var CRUDModel $oModel */
        $oModel = (static::$sModelClass)::fnBuild();
        return $oModel;
    }

    public function fnListJSON()
    {
        $oModel = $this->_fnBuildModel();
        $aList = $oModel->fnList($this->oRequest->aPost);
        return $aList;
    }

    public function fnListWithPaginationJSON()
    {
        $oModel = $this->_fnBuildModel();
        $aList = $oModel->fnListWithPagination($this->oRequest->aPost);
        return $aList;
    }

    public function fnListLastJSON()
    {
        $oModel = $this->_fnBuildModel();
        $aList = $oModel->fnListLast($this->oRequest->aPost);
        return $aList;
    }

    public function fnDeleteJSON()
    {
        $oModel = $this->_fnBuildModel();
        $aList = $oModel->fnDelete([$this->oRequest->aPost['id']]);
        return $aList;
    }

    public function fnDeleteListJSON()
    {
        $oModel = $this->_fnBuildModel();
        $aList = $oModel->fnDelete($this->oRequest->aPost['ids']);
        return $aList;
    }

    public function fnCreateJSON()
    {
        $oModel = $this->_fnBuildModel();
        $oItem = $oModel->fnCreate($this->oRequest->aPost);
        return $oItem;
    }

    public function fnUpdateJSON()
    {
        $oModel = $this->_fnBuildModel();
        $oItem = $oModel->fnUpdate($this->oRequest->aPost);
        return $oItem;
    }
}