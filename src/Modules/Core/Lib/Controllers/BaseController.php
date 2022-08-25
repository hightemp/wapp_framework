<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers;

use Exception;
use Hightemp\WappTestSnotes\Project;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Request as LibRequest;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Response;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Responses\HTML as HTMLResponse;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Responses\JSON as JSONResponse;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Responses\NotFound as NotFoundResponse;
use Hightemp\WappTestSnotes\Modules\Core\Lib\View;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Request;
use Hightemp\WappTestSnotes\Modules\Core\Helpers\Utils;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Responses\Forward301;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Responses\Forward302;

class BaseController
{
    const METHOD_KEY = "method";
    const CONTROLLER_KEY = "controller";
    const MODULE_KEY = "module";
    const ALIAS_KEY = "alias";

    const DEFAULT_MODULE = "Core";

    const CC_FORWARD_302 = 302;
    const CC_FORWARD_301 = 301;
    const CP_FORWARD = "forward";

    public static $aAvailableMethodTypes = ['JSON', 'HTML'];

    public static $oGlobalRequest = null;
    public $oRequest = null;
    public $sViewClass = null;
    public static $sDefaultViewClass = View::class;

    /** @var string[] $aPreloadViews список View для предварительной загрузки head html и переменных */
    public static $aPreloadViews = [];
    public static $aMiddlewaresBefore = [];
    public static $aMiddlewaresAfter = [];

    public static $aDefaultTemplates = [
        //     "fnListWithPaginationAjaxHTML" => ['tables/ajax_table.php', null, 'Тест - ajax таблица'],
        //     "fnListWithPaginationCrudHTML" => ['tables/crud_table.php', null, 'Тест - crud таблица'],
    ];

    public function __construct($oRequest=new LibRequest(), $sViewClass=null)
    {
        $this->oRequest = $oRequest;
        $this->sViewClass = is_null($sViewClass) ? static::$sDefaultViewClass : $sViewClass;
    }

    public static function fnGetMethodValidatorRegExp()
    {
        $sReg = '/^fn(.*)('.join('|', static::$aAvailableMethodTypes).')$/';
        return $sReg;
    }

    public static function fnIsMethodValid($sMethod)
    {
        $sReg = static::fnGetMethodValidatorRegExp();
        return preg_match($sReg, $sMethod);
    }

    public static function fnGetValidMethods()
    {
        $aMethods = get_class_methods(static::class);

        return array_filter($aMethods, function($sI) { return static::fnIsMethodValid($sI); });
    }

    public static function fnPrepareMethodName($sMethod, $sSep="_")
    {
        $sReg = static::fnGetMethodValidatorRegExp();
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

        // NOTE: Пример list_with_pagination_json
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

    public static function fnGenerateMethodsAliasesList()
    {
        $aResult = [];

        $aMethods = get_class_methods(static::class);

        array_map(function ($sMethod) use (&$aResult) {
            $sAlias = static::fnPrepareMethodNameForAlias($sMethod);

            if (!$sAlias) return;

            $aResult[$sMethod] = [$sAlias, static::class, $sMethod];
        }, $aMethods);

        return $aResult;
    }

    public static function fnGetControllersByModules()
    {
        static $aControllers = [];

        if ($aControllers) return $aControllers;

        $aModules = Project::$aModules;
        $aControllers = [];
        foreach ($aModules as $sModule) {
            isset($aControllers[$sModule]) ?: $aControllers[$sModule] = [];
            $aControllers[$sModule] = array_merge(
                $aControllers[$sModule], 
                $sModule::$aControllers
            );
        }

        return $aControllers;
    }

    public static function fnPrepareViewsRelations($aViewsList)
    {
        $aResult = [];

        foreach ($aViewsList as $sViewClass) {
            $sModule = Utils::fnExtractModuleName($sViewClass);
            $sModuleClass = Utils::fnGetModulesClassNamespace($sModule);

            $aResult[] = $sViewClass;

            $aPreloadViews = (array) $sModuleClass::$aPreloadViews;
            $aResult = array_merge($aResult, $aPreloadViews);
        }

        return $aResult;
    }

    public static function fnPrepareAllViewsForController($oController, $sMethod, $aControllers=null)
    {
        if (is_null($aControllers)) {
            $aControllers = static::fnGetControllersByModules();
        }

        $aViewsList = [];

        // NOTE: предзагруза View из Project
        $aPreloadViews = (array) Project::$aPreloadViews;
        $aViewsList = $aPreloadViews;

        // NOTE: предзагруза View из модулей
        $aViewsList = array_merge($aViewsList, (Request::$sCurrentModuleClass)::$aPreloadViews);
        
        // NOTE: предзагруза View из контроллеров
        $sControllerClass = get_class($oController);
        $aPreloadViews = (array) $sControllerClass::$aPreloadViews;
        $aViewsList = array_merge($aViewsList, $aPreloadViews);

        $aViewsList = array_unique($aViewsList);

        // NOTE: Подключаем переменные
        foreach ($aViewsList as $sViewClass) {
            $sViewClass::fnPrepareVars();
        }
        
        // NOTE: Рендрим все header.php шаблоны
        foreach ($aViewsList as $sViewClass) {
            $sViewClass::fnPrepareHTMLHeader();
        }

        $sViewClass = $oController->sViewClass;
        
        $aTemplates = null;

        if ($sViewClass && $sViewClass::$aTemplates) {
            // NOTE: Используем шаблоны из View модуля, если они есть
            if (isset($sViewClass::$aTemplates[$sControllerClass])) {
                $aRefMethods = &$sViewClass::$aTemplates[$sControllerClass];
                if (isset($aRefMethods[$sMethod])) {
                    $aTemplates = &$sViewClass::$aTemplates[$sControllerClass][$sMethod];
                }
            }
        }

        if (is_null($aTemplates)) {
            // NOTE: Иначе используем шабоны по умолчанию из контроллера
            if (isset($sControllerClass::$aDefaultTemplates[$sMethod])) {
                $aTemplates = &$sControllerClass::$aDefaultTemplates[$sMethod];
            }
        }

        if (!is_null($aTemplates)) {
            isset($aTemplates[0]) ?: $aTemplates[0] = null;
            isset($aTemplates[1]) ?: $aTemplates[1] = null;
            // NOTE: sTitle - подстановка заголовока из aTemplates
            isset($aTemplates[2]) ?: $aTemplates[2] = '';

            $sViewClass::fnSetParams([
                "sTitle" => $aTemplates[2]
            ], $aTemplates[0], $aTemplates[1]);
        }

        $sViewClass::fnPrepareContentVar();
    }

    public static function fnGetResponseFromController($aAlias, $oRequest)
    {
        if (!$aAlias) return;

        isset($aAlias[0]) ?: $aAlias[0]='';
        isset($aAlias[1]) ?: $aAlias[1]='';
        isset($aAlias[2]) ?: $aAlias[2]='';

        list($sController, $sMethod) = $aAlias;
        
        $oResponse = null;
        $sController = "\\".$sController;
        $oController = new $sController($oRequest);

        $mResult = $oController->$sMethod();

        if (preg_match('/HTML$/i', $sMethod)) {
            // NOTE: Подготовка $sContent и переменных для текущего контроллера
            static::fnPrepareAllViewsForController($oController, $sMethod);

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
     * @return void|array|Controller[][]|string[][]|string[][]
     */
    public static function fnFindMethodByPathAlias($sPath, $aControllers=null)
    {
        if (is_null($aControllers)) {
            $aControllers = static::fnGetControllersByModules();

            $aModuleAliases = static::fnGetProjectAliases();

            foreach ($aModuleAliases as $sAliasClass) {
                $aMethods = $sAliasClass::fnPrepareAliases();
                if (isset($aMethods[$sPath])) {
                    return $aMethods[$sPath];
                }

                $sPath = trim($sPath, "/");

                if (isset($aMethods[$sPath])) {
                    return $aMethods[$sPath];
                } else {
                    $sRegExpKey = Utils::fnFindStringInRegExpArr($sPath, array_keys($aMethods));
                    if ($sRegExpKey) {
                        return $aMethods[$sRegExpKey];
                    }
                }
            }
        }
    }

    public static function fnGetProjectAliases()
    {
        return \Hightemp\WappTestSnotes\Project::$aAliases;
    }

    public static function fnGetAllAliases($sModuleClass=null)
    {
        $aResult = [];
        $aProjectAliases = static::fnGetProjectAliases();
        $sModule = "";
        if ($sModuleClass) $sModule = Utils::fnExtractModuleName($sModuleClass);

        foreach ($aProjectAliases as $sAliasClass) {
            if ($sModule) {
                $sAliasModule = Utils::fnExtractModuleName($sAliasClass);
                if ($sAliasModule != $sModule) {
                    continue;
                }
            }

            $aResult = array_merge($aResult, $sAliasClass::fnPrepareAliases());
        }

        return $aResult;
    }

    public static function fnGetAllAliasesLinks($sModuleClass=null, $bExcludeForwards=true)
    {
        $aResult = [];
        $aProjectAliases = static::fnGetAllAliases($sModuleClass);

        foreach ($aProjectAliases as $sAlias => $aMethod) {
            if (!class_exists($aMethod[0]) && $bExcludeForwards) {
                continue;
            }

            $sURL = Utils::fnGetBaseURL($sAlias);
            $aResult[] = [$sURL, $sAlias, ...$aMethod];
        }

        return $aResult;
    }

    public static function fnFindAndExecuteMethod($oRequest, $aControllers=null)
    {
        static::$oGlobalRequest = $oRequest;

        View::$aVars['oRequest'] = $oRequest;

        $oResponse = null;
        $sCurrentMethod = isset($oRequest->aGet[static::METHOD_KEY]) ? $oRequest->aGet[static::METHOD_KEY] : '';
        $sCurrentController = isset($oRequest->aGet[static::CONTROLLER_KEY]) ? $oRequest->aGet[static::CONTROLLER_KEY] : '';
        $sCurrentModule = isset($oRequest->aGet[static::MODULE_KEY]) ? $oRequest->aGet[static::MODULE_KEY] : static::DEFAULT_MODULE;

        $aURI = parse_url($oRequest->aServer['REQUEST_URI']);
        $sCurrentAlias = isset($oRequest->aGet[static::ALIAS_KEY]) ? $oRequest->aGet[static::ALIAS_KEY] : $aURI['path'];
        $bIsRoot = trim($sCurrentAlias, "/") == "";

        if ($sCurrentAlias) {
            $aAlias = static::fnFindMethodByPathAlias($sCurrentAlias, $aControllers);
            if ($aAlias) {
                if (!class_exists($aAlias[0])) {
                    if ($aAlias[0] == BaseController::CP_FORWARD) {
                        $sCurrentAlias = $aAlias[1];
                        $aAlias = static::fnFindMethodByPathAlias($sCurrentAlias, $aControllers);
                    }
                    if ($aAlias[0] == BaseController::CC_FORWARD_301) {
                        return (new Forward301("/".$aAlias[1]));
                    }
                    if ($aAlias[0] == BaseController::CC_FORWARD_302) {
                        return (new Forward302("/".$aAlias[1]));
                    }
                }

                if (method_exists($aAlias[0], $aAlias[1])) {
                    Request::$sCurrentModuleClass = Utils::fnGetModulesClassNamespace(Utils::fnExtractModuleName($aAlias[0]));
                    Request::$sCurrentMethod = $aAlias[1];
                    Request::$sCurrentControllerClass = $aAlias[0];

                    $oResponse = static::fnGetResponseFromController($aAlias, $oRequest);
                }
            }
        }

        if (!$oResponse) {
            if (is_null($aControllers)) {
                $aControllers = static::fnGetControllersByModules();
            }

            foreach ($aControllers as $sModuleClass => $aControllers) {
                $sModuleClassName = static::fnExtractModuleName($sModuleClass);

                if ($sCurrentModule == $sModuleClassName) {
                    foreach ($aControllers as $sController) {
                        $aController = explode("\\", $sController);
                        $sControllerName = array_pop($aController);

                        // NOTE: Метод и контроллер по умолчанию первый попавшийся
                        if (!$sCurrentController && !$sCurrentMethod && $bIsRoot)  {
                            $sCurrentController = $sModuleClass::$sDefaultController;
                            $sCurrentMethod = $sModuleClass::$sDefaultMethod;
                        }

                        if ($sController == $sCurrentController || $sControllerName == $sCurrentController) {
                            if (method_exists($sController, $sCurrentMethod)) {
                                $aAlias = [$sController, $sCurrentMethod];

                                Request::$sCurrentModuleClass = $sModuleClass;
                                Request::$sCurrentMethod = $sCurrentMethod;
                                Request::$sCurrentControllerClass = $sCurrentController;

                                $oResponse = static::fnGetResponseFromController($aAlias, $oRequest);
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