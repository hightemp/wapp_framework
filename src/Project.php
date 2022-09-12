<?php

namespace Hightemp\WappFramework;

use Hightemp\WappFramework\Modules\Core\Lib\BaseProject;

class Project extends BaseProject
{
    public static $sProjectClassPath = __NAMESPACE__;
    public static $sProjectRootPath = __DIR__;

    /** @var string|BaseLogger $sLoggerClass */
    public static $sLoggerClass = \Hightemp\WappFramework\Modules\Debug\Loggers\SimpleJSONLLogger::class;

    public static $sDefaultCommand = \Hightemp\WappFramework\Modules\Core\Commands\ListCommands::class;

    public static $aPreload = [
        \Hightemp\WappFramework\Modules\Core\Module::class,
        \Hightemp\WappFramework\Modules\Debug\Module::class,
        \Hightemp\WappFramework\Modules\CEasyUI\Module::class,
        \Hightemp\WappFramework\Modules\CBootstrapTable\Module::class,
        \Hightemp\WappFramework\Modules\TestTables\Module::class,
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
        \Hightemp\WappFramework\Modules\Core\View::class,
    ];
}
