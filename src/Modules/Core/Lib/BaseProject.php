<?php

namespace Hightemp\WappFramework\Modules\Core\Lib;

class BaseProject 
{
    public static $sProjectClassPath = __NAMESPACE__;
    public static $sProjectRootPath = __DIR__;

    public static $sDefaultCommand = \Hightemp\WappFramework\Modules\Core\Commands\ListCommands::class;

    /** 
     * @var array $aPreload Предварительная загрузка файлов, выполнение методов модулей
     * 
     * ```php
     * [
     *   // Подключить файл
     *   "file/path/to_include.php",
     *   // Выполнить метод
     *   [\Hightemp\WappFramework\Modules\Debug\Module::class, "fnMethod"],
     *   // Подключить модуль
     *   \Hightemp\WappFramework\Modules\Debug\Module::class
     * ]
     * ```
     * */
    public static $aPreload = [
    ];

    public static $aModules = [
    ];

    public static $aAliases = [
    ];

    public static $aCommands = [
    ];

    public static $aGenerators = [
    ];

    public static $aControllers = [
    ];

    public static $aPreloadViews = [
    ];

    public static $aModels = [
    ];

    public static $aMiddlewares = [
    ];
    
    /**
     * Предварительная загрузка файлов, выполнение методов модулей
     *
     * @return void
     */
    public static function fnPreload()
    {
        foreach (static::$aPreload as $mElement) {
            if (is_string($mElement)) {
                if (class_exists($mElement)) {
                    static::fnPreloadModule($mElement);
                } else {
                    $aResult = require_once($mElement);
                }
            } else {
                $mElement[0]::$mElement[1]();
            }
        }
    }

    public static function fnPreloadModule($sClass)
    {
        static::$aModules = array_merge(static::$aModules, (array) $sClass);
        static::$aControllers = array_merge(static::$aControllers, (array) $sClass::$aControllers);
        static::$aAliases = array_merge(static::$aAliases, (array) $sClass::$aAliases);
        // static::$aPreloadViews = array_merge(static::$aPreloadViews, (array) $sClass::$aPreloadViews);
        static::$aModels = array_merge(static::$aModels, (array) $sClass::$aModels);
        static::$aMiddlewares = array_merge(static::$aMiddlewares, (array) $sClass::$aMiddlewares);
        static::$aGenerators = array_merge(static::$aGenerators, (array) $sClass::$aGenerators);

        static::$aCommands = array_merge(static::$aCommands, (array) $sClass::fnGetCommandsClass());
        static::$aAliases = array_merge(static::$aAliases, (array) $sClass::fnGetAliasesClass());

        static::$aModules = array_unique(static::$aModules);
        static::$aControllers = array_unique(static::$aControllers);
        // static::$aPreloadViews = array_unique(static::$aPreloadViews);
        static::$aModels = array_unique(static::$aModels);
        static::$aMiddlewares = array_unique(static::$aMiddlewares);
        static::$aGenerators = array_unique(static::$aGenerators);

        static::$aCommands = array_unique(static::$aCommands);
        static::$aAliases = array_unique(static::$aAliases);
    }
}
