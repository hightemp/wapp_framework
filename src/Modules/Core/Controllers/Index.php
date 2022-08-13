<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Controllers;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseController;
use Hightemp\WappTestSnotes\Modules\Core\View;

class Index extends BaseController
{
    public static $sDefaultViewClass = View::class;

    public function fnIndexHTML()
    {
        View::fnSetParams(
            [
                "test_var" => "test"
            ]
        );
    }
}