<?php

namespace Hightemp\WappFramework\Modules\Core\Generators;

use Hightemp\WappFramework\Modules\Core\Lib\BaseGenerator;

class OpenAPI extends BaseGenerator
{
    const TEMPLATES_PATH = __DIR__."/../templates";
    const GENERATOR_TYPE = "openapi";

    public static $aDefaultOptions = [
        "templates" => [
            "openapi/base_openapi.php" => "Commands/{{output_file_name}}.php",
        ],
        "vars" => [
        ],
    ];
}