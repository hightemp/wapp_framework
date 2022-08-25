<?php

namespace Hightemp\WappTestSnotes\Modules\TestTables;

use Hightemp\WappTestSnotes\Modules\TestTables\Controllers\Index;
use Hightemp\WappTestSnotes\Modules\Core\Lib\View as LibView;

class View extends LibView
{
    public static $aTemplates = [
        Index::class => [
            "fnIndexHTML" => ['index.php', null, 'Начальная страница - Заголовок'],
        ],
    ];
}