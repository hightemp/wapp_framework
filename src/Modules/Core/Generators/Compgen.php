<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Generators;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseGenerator;

class Compgen extends BaseGenerator
{
    const TEMPLATES_PATH = __DIR__."/../templates";
    const GENERATOR_TYPE = "compgen";

    public static $aDefaultOptions = [
        "templates" => [
            "compgen/base.php" => "{{root_path}}/compgen.gen.sh",
        ],
        "vars" => [

        ],
    ];
}