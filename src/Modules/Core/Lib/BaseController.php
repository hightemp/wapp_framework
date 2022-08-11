<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

use Exception;
use Hightemp\WappTestSnotes\Modules;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Request as LibRequest;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Response;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Responses\HTML as HTMLResponse;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Responses\JSON as JSONResponse;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Responses\NotFound as NotFoundResponse;
use Request;

class BaseController
{
    const METHOD_KEY = "method";

    public static $oGlobalRequest = null;
    public $oRequest = null;
    public $sViewClass = View::class;

    public function __construct($oRequest=new LibRequest())
    {
        $this->oRequest = $oRequest;
    }

    public static function fnGetControllersByModules()
    {
        $aModules = Modules::$aModules;
        $aControllers = [];
        foreach ($aModules as $sModule) {
            $aControllers[$sModule] ?? $aControllers[$sModule] = [];
            $aControllers[$sModule] = array_merge(
                $aControllers[$sModule], 
                $sModule::$aControllers
            );
        }

        return $aControllers;
    }

    public static function fnGetResponseFromController($sController, $sMethod, $oRequest)
    {
        $oResponse = null;
        $sController = "\\".$sController;
        $oController = new $sController($oRequest);

        $mResult = $oController->$sMethod();

        if (preg_match('/html$/i', $sMethod)) {
            $sViewClass = $oController->sViewClass;
            $mResult = $sViewClass::fnRender();

            $oResponse = new HTMLResponse();
        } else if (preg_match('/json$/i', $sMethod)) {
            $oResponse = new JSONResponse();
        }

        $oResponse->fnSetContent($mResult);

        return $oResponse;
    }

    public static function fnFindAndExecuteMethod($oRequest, $aControllers=null)
    {
        static::$oGlobalRequest = $oRequest;
        $oResponse = null;
        $sMethod = $oRequest->aGet[static::METHOD_KEY] ?? '';

        if (is_null($aControllers)) {
            $aControllers = static::fnGetControllersByModules();
        }

        foreach ($aControllers as $sModuleClass => $aControllers) {
            foreach ($aControllers as $sController) {
                // NOTE: Метод и контроллер по умолчанию первый попавшийся
                if (!$sMethod)  {
                    $sController = $sModuleClass::$sDefaultController;
                    $sMethod = $sModuleClass::$sDefaultMethod;
                }

                if (method_exists($sController, $sMethod)) {
                    $oResponse = static::fnGetResponseFromController($sController, $sMethod, $oRequest);
                    break 2;
                }
            }
        }

        if (!$oResponse) {
            $oResponse = new NotFoundResponse();
        }

        return $oResponse;
    }
}