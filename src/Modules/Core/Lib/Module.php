<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

use \Hightemp\WappTestSnotes\Modules\Core\Lib\Models\BaseModel;
use \Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\BaseController;
use \Hightemp\WappTestSnotes\Modules\Core\Lib\View;

class Module 
{
    /** @var string Название модуля */
    const NAME = "[NONAME]";
    const VERSION = "1.0.0";

    /** @var string|BaseController Дефолтный контроллер */
    public static $sDefaultController = null;
    /** @var string Дефолтный метод */
    public static $sDefaultMethod = null;

    /** @var BaseController[] Список контроллеров */
    public static $aControllers = [];

    /** @var View[] Загрузка переменных и доп. html */
    public static $aPreloadViews = [];

    /** @var BaseController[] Список контроллеров используемых для генерации OpenAPI yaml, json */
    public static $aUseForOpenAPI = [];

    /** @var BaseModel[] $aModels Список моделей */
    public static $aModels = [];

    /** @var BaseModel[] $aModulesDependencies Зависимости от других модулей */
    public static $aModulesDependencies = [];
}