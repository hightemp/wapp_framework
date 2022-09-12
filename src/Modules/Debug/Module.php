<?php

namespace Hightemp\WappFramework\Modules\Debug;

use Hightemp\WappFramework\Modules\Core\Lib\BaseModule;
use Hightemp\WappFramework\Modules\Debug\Models\SimpleJSONLLogger;

class Module extends BaseModule
{
    const NAME = "Debug";

    /** @var string|BaseLogger $sLoggerClass */
    public static $sLoggerClass = SimpleJSONLLogger::class;

    public static $aModulesDependencies = [
        \Hightemp\WappFramework\Modules\Bootstrap\Module::class,
    ];

    public static $aPreloadViews = [
        \Hightemp\WappFramework\Modules\Bootstrap\View::class,
    ];

    public static $aControllers = [
        \Hightemp\WappFramework\Modules\Debug\Controllers\Index::class,
    ];
}