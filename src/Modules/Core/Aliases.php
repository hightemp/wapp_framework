<?php

namespace Hightemp\WappTestSnotes\Modules\Core;

class Aliases 
{
    public static $aMethods = [
        "core_index" => [\Hightemp\WappTestSnotes\Modules\Core\Controllers\Index::class, 'fnIndexHTML'],
    ];
}