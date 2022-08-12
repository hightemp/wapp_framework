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
    const CONTROLLER_KEY = "controller";
    const MODULE_KEY = "module";
    const ALIAS_KEY = "alias";

    const DEFAULT_MODULE = "Core";

    public static $oGlobalRequest = null;
    public $oRequest = null;
    public $sViewClass = View::class;

    public function __construct($oRequest=new LibRequest())
    {
        $this->oRequest = $oRequest;
    }

    public static function fnGetControllersByModules()
    {
        static $aControllers = [];

        if ($aControllers) return $aControllers;

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

    public static function fnExtractModuleName($sPath)
    {
        $aP = explode("\\", $sPath);
        array_pop($aP);
        return array_pop($aP);
    }
    
    /**
     * fnFindMethodByPathAlias
     *
     * @param  string $sPath альяс
     * @param  array $aControllers массив сгруппированный по назв. модулей
     * @return void|array|Controller[][]|string[][]
     */
    public static function fnFindMethodByPathAlias($sPath, $aControllers=null)
    {
        if (is_null($aControllers)) {
            $aControllers = static::fnGetControllersByModules();

            $aModuleAliases = \Hightemp\WappTestSnotes\Modules::$aAliases;

            foreach ($aModuleAliases as $sAliasClass) {
                $aMethods = $sAliasClass::$aMethods;
                if (isset($aMethods[$sPath])) {
                    return $aMethods[$sPath];
                }

                $sPath = trim($sPath, "/");

                if (isset($aMethods[$sPath])) {
                    return $aMethods[$sPath];
                }
            }
        }
    }

    public static function fnFindAndExecuteMethod($oRequest, $aControllers=null)
    {
        static::$oGlobalRequest = $oRequest;

        View::$aVars['oRequest'] = $oRequest;

        $oResponse = null;
        $sCurrentMethod = $oRequest->aGet[static::METHOD_KEY] ?? '';
        $sCurrentController = $oRequest->aGet[static::CONTROLLER_KEY] ?? '';
        $sCurrentModule = $oRequest->aGet[static::MODULE_KEY] ?? static::DEFAULT_MODULE;

        $aURI = parse_url($oRequest->aServer['REQUEST_URI']);
        $sCurrentAlias = $oRequest->aGet[static::ALIAS_KEY] ?? $aURI['path'];

        if ($sCurrentAlias) {
            $aFound = static::fnFindMethodByPathAlias($sCurrentAlias, $aControllers);
            if ($aFound) {
                if (method_exists($aFound[0], $aFound[1])) {
                    $oResponse = static::fnGetResponseFromController($aFound[0], $aFound[1], $oRequest);
                }
            }
        }

        if (!$oResponse) {
            if (is_null($aControllers)) {
                $aControllers = static::fnGetControllersByModules();
            }

            foreach ($aControllers as $sModuleClass => $aControllers) {
                if (!$sCurrentModule) {
                    $sCurrentModule = static::DEFAULT_MODULE;
                }

                $sModuleClassName = static::fnExtractModuleName($sModuleClass);

                if ($sCurrentModule == $sModuleClassName) {
                    foreach ($aControllers as $sController) {
                        $sControllerName = array_pop(explode("\\", $sController));

                        // NOTE: Метод и контроллер по умолчанию первый попавшийся
                        if (!$sCurrentController && !$sCurrentMethod)  {
                            $sCurrentController = $sModuleClass::$sDefaultController;
                            $sCurrentMethod = $sModuleClass::$sDefaultMethod;
                        }

                        if ($sControllerName == $sCurrentController) {
                            if (method_exists($sController, $sCurrentMethod)) {
                                $oResponse = static::fnGetResponseFromController($sController, $sCurrentMethod, $oRequest);
                                break 2;
                            }
                        }
                    }
                }
            }
        }

        if (!$oResponse) {
            $oResponse = new NotFoundResponse();
        }

        return $oResponse;
    }
}