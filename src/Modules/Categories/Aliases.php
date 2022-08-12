<?php

namespace Hightemp\WappTestSnotes\Modules\Categories;

class Aliases 
{
    public static $aMethods = [
        "categories_index" => [\Hightemp\WappTestSnotes\Modules\Categories\Controllers\Index::class, 'fnIndexHTML'],
    ];
}