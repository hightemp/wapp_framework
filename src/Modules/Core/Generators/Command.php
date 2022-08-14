<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Generators;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseGenerator;

class Command extends BaseGenerator
{
    const GENERATOR_TYPE = "command";

    public static $aDefaultOptions = [
        "templates" => [
            "commands/base_command_class.php" => "Commands/{{output_file_name}}.php",
        ],
        "vars" => [

        ],
    ];
}