<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Generators;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseGenerator;

class AliasesList extends BaseGenerator
{
    const TEMPLATES_PATH = __DIR__."/../templates";
    const GENERATOR_TYPE = "aliases_list";

    public static $aDefaultOptions = [
        "templates" => [
            "aliases_list/base.php" => "{{root_path}}/cache/aliases_list.php",
        ],
        "vars" => [

        ],
    ];
}