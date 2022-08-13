<?php

namespace Hightemp\WappTestSnotes\Modules\Categories\Controllers;

use Hightemp\WappTestSnotes\Modules\Core\Lib\BaseController;
use Hightemp\WappTestSnotes\Modules\Categories\View;

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