<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Lib;

class Module 
{
    const NAME = "[NONAME]";

    public static $sDefaultController = null;
    public static $sDefaultMethod = null;

    /**
     * Список контроллеров
     */
    public static $aControllers = [];

    /**
     * Загрузка переменных и доп. html
     */
    public static $aPreloadViews = [];

    /**
     * Список контроллеров используемых для генерации OpenAPI yaml, json
     */
    public static $aUseForOpenAPI = [];
}