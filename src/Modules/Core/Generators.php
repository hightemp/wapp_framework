<?php

namespace Hightemp\WappFramework\Modules\Core;

use Hightemp\WappFramework\Modules\Core\Lib\BaseGenerators;

class Generators extends BaseGenerators
{
    public static $aGenerators = [
        \Hightemp\WappFramework\Modules\Core\Generators\Command::class,
    ];
}