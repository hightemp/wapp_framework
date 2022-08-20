<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI;

use Hightemp\WappTestSnotes\Modules\Core\Lib\View as LibView;

use Hightemp\WappTestSnotes\Modules\CEasyUi\Lib\Tags\TagCETextBox;

class View extends LibView
{
    public static $sDefaultLayoutTemplate = "layout.php";

    public static function fnPrepareVars()
    {
        parent::fnPrepareVars();

        self::$aVars['oTagCETextBox'] = new TagCETextBox();
    }
}