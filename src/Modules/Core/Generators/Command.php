<?php

namespace Hightemp\WappFramework\Modules\Core\Generators;

use Hightemp\WappFramework\Modules\Core\Lib\BaseGenerator;

class Command extends BaseGenerator
{
    const TEMPLATES_PATH = __DIR__."/../templates";
    const GENERATOR_TYPE = "command";

    public static $aDefaultOptions = [
        "templates" => [
            "commands/base_command_class.php" => "Commands/{{output_file_name}}.php",
        ],
        "vars" => [

        ],
    ];
}