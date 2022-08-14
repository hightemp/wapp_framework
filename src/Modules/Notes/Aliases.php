<?php

namespace Hightemp\WappTestSnotes\Modules\Notes;

use \Hightemp\WappTestSnotes\Modules\Notes\Controllers;

class Aliases 
{
    public static $aMethods = [
        "notes_index" => [Controllers\Index::class, 'fnIndexHTML'],
        "notes_list" => [Controllers\Index::class, 'fnIndexHTML'],
        "notes_create" => [Controllers\Index::class, 'fnIndexHTML'],
        "notes_update" => [Controllers\Index::class, 'fnIndexHTML'],
        "notes_delete" => [Controllers\Index::class, 'fnIndexHTML'],
    ];
}