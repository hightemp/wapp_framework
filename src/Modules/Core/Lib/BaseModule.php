<?php

namespace Hightemp\WappFramework\Modules\Core\Lib;

use \Hightemp\WappFramework\Modules\Core\Lib\Models\BaseModel;
use \Hightemp\WappFramework\Modules\Core\Lib\BaseMiddleware;
use \Hightemp\WappFramework\Modules\Core\Lib\Controllers\BaseController;
use \Hightemp\WappFramework\Modules\Core\Lib\BaseGenerator;
use \Hightemp\WappFramework\Modules\Core\Lib\View;
use Hightemp\WappFramework\Modules\Core\Helpers\Utils;

class BaseModule 
{
    /** @var string Название модуля */
    const NAME = "[NONAME]";
    const DESCRIPTION = "";
    const VERSION = "1.0.0";

    /** @var string|BaseController Дефолтный контроллер */
    public static $sDefaultController = null;
    /** @var string Дефолтный метод */
    public static $sDefaultMethod = null;

    /** @var string[]|BaseController[] Список контроллеров */
    public static $aControllers = [];

    /** @var string[]|View[] Загрузка переменных и доп. html */
    public static $aPreloadViews = [];

    /** @var string[]|BaseController[] Список контроллеров используемых для генерации OpenAPI yaml, json */
    public static $aUseForOpenAPI = [];

    /** @var string[]|BaseModel[] $aModels Список моделей */
    public static $aModels = [];

    /** @var string[]|BaseModel[] $aModulesDependencies Зависимости от других модулей */
    public static $aModulesDependencies = [];

    /** @var string[]|BaseMiddleware[] $aMiddlewares Прослойка для выполнения кода */
    public static $aMiddlewares = [];

    /** @var string[]|BaseGenerator[] Список генератиоров */
    public static $aGenerators = [];

    /** @var string[] (Автоподгружаемое из Commands) Список команд */
    public static $aCommands = [];

    /** @var string[] (Автоподгружаемое из Aliases) Список альясов */
    public static $aAliases = [];

        
    /**
     * fnGetCommandsClass
     *
     * @return string|null
     */
    public static function fnGetCommandsClass()
    {
        $sClass = Utils::fnGetModulesClassNamespace(Utils::fnExtractModuleName(static::class), "Commands");
        return class_exists($sClass) ? $sClass : null;
    }
    
    /**
     * fnGetAliasesClass
     *
     * @return string|null
     */
    public static function fnGetAliasesClass()
    {
        $sClass = Utils::fnGetModulesClassNamespace(Utils::fnExtractModuleName(static::class), "Aliases");
        return class_exists($sClass) ? $sClass : null;
    }

    public static function fnGetGeneratorsClass()
    {
        $sClass = Utils::fnGetModulesClassNamespace(Utils::fnExtractModuleName(static::class), "Generators");
        return class_exists($sClass) ? $sClass : null;
    }
}