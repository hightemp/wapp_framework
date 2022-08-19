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
    public static $sAvailableMethodTypes = 'JSON|HTML';

    public static function fnPrepareMethodName($sMethod, $sSep="_")
    {
        $sReg = '/^fn(.*)('.static::$sAvailableMethodTypes.')$/';
        $aPregM = [];

        if (!preg_match($sReg, $sMethod, $aPregM)) {
            return false;
        }

        $sExt = strtolower($aPregM[2]);
        $sAlias = preg_replace($sReg, "$1", $sMethod);
        $bF = true;
        $sAlias = preg_replace_callback("/[A-Z]/", function ($aM) use ($sSep, &$bF) {
            return ($bF ? $bF=false : $sSep).strtolower($aM[0]);
        }, $sAlias);

        return $sAlias."_".$sExt;
    }

    public static function fnPrepareMethodNameForAlias($sMethod, $sSep="_")
    {
        $sAlias = static::fnPrepareMethodName($sMethod, $sSep);

        $sModule = Utils::fnExtractModuleName(static::class);
        $sModule = strtolower($sModule);

        $sAlias = $sModule."/".$sAlias;

        return $sAlias;
    }

    public static function fnGenerateAliases()
    {
        $aResult = [];

        $aMethods = get_class_methods(static::class);

        array_map(function ($sMethod) use (&$aResult) {
            $sAlias = static::fnPrepareMethodNameForAlias($sMethod);

            if (!$sAlias) return;

            $aResult[$sAlias] = [static::class, $sMethod];
        }, $aMethods);

        return $aResult;
    }
    
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
    
    /**
     * fnGetTableInfoJSON - gettableinfo
     *
     * @return array
     */
    public function fnGetTableInfoJSON()
    {
        $oModel = $this->_fnBuildModel();
        $aList = $oModel->fnGetTableInfo($this->oRequest->aRequest);
        return $aList;
    }
    
    /**
     * fnListJSON - list
     *
     * @return array
     */
    public function fnListJSON()
    {
        $oModel = $this->_fnBuildModel();
        $aList = $oModel->fnList($this->oRequest->aRequest);
        return $aList;
    }
    
    /**
     * fnListWithPaginationJSON - listwithpagination
     *
     * @return array
     */
    public function fnListWithPaginationJSON()
    {
        $oModel = $this->_fnBuildModel();
        $aList = $oModel->fnListWithPagination($this->oRequest->aRequest);
        return $aList;
    }

    public function fnListLastJSON()
    {
        $oModel = $this->_fnBuildModel();
        $aList = $oModel->fnListLast($this->oRequest->aRequest);
        return $aList;
    }

    public function fnDeleteJSON()
    {
        $oModel = $this->_fnBuildModel();
        $aList = $oModel->fnDelete([$this->oRequest->aRequest['id']]);
        return $aList;
    }

    public function fnDeleteListJSON()
    {
        $oModel = $this->_fnBuildModel();
        $aList = $oModel->fnDelete($this->oRequest->aRequest['ids']);
        return $aList;
    }

    public function fnCreateJSON()
    {
        $oModel = $this->_fnBuildModel();
        $oItem = $oModel->fnCreate($this->oRequest->aRequest);
        return $oItem;
    }

    public function fnUpdateJSON()
    {
        $oModel = $this->_fnBuildModel();
        $oItem = $oModel->fnUpdate($this->oRequest->aRequest);
        return $oItem;
    }
}