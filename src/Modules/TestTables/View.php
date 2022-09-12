<?php

namespace Hightemp\WappFramework\Modules\TestTables;

use Hightemp\WappFramework\Modules\TestTables\Controllers\Index;
use Hightemp\WappFramework\Modules\Core\Lib\View as LibView;

class View extends LibView
{
    public static $aTemplates = [
        Index::class => [
            "fnIndexHTML" => ['index.php', null, 'Начальная страница - Заголовок'],
        ],
    ];
}