<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI;

use Hightemp\WappTestSnotes\Modules\Core\Lib\View as LibView;

use Hightemp\WappTestSnotes\Modules\CEasyUI\Lib\Tags\Fields\{
    TagCEPanelBegin,
    TagCEPanelEnd,
    TagCETextBox,
    TagCETextarea,
    TagCECheckbox,
    TagCEDatebox,
    TagCEButton,
    TagCESearchBox,
    TagCESelect,
    TagCEComboTree,
    TagCEMaskedBox,
};
use Hightemp\WappTestSnotes\Modules\CEasyUI\Lib\Tags\Fields\MaskedBox\{
    TagCEMaskedBoxPhone,
};
use Hightemp\WappTestSnotes\Modules\CEasyUI\Controllers\Demo01;

class View extends LibView
{
    const STATIC_PATH = "static";
    const STATIC_IMAGES_PATH = "static";
    const STATIC_CSS_PATH = "static";
    const STATIC_JS_PATH = "static";

    const THEME = 'metro-blue';

    public static $aTemplates = [
        Demo01::class => [
            "fnIndexHTML" => ['pages/demo1.php']
        ]
    ];

    public static function fnPrepareVars()
    {
        self::$aVars['sTheme'] = static::THEME;

        parent::fnPrepareVars();

        self::$aVars['oTagCEMaskedBoxPhone'] = new TagCEMaskedBoxPhone();
        self::$aVars['oTagCEMaskedBox'] = new TagCEMaskedBox();
        self::$aVars['oTagCESearchBox'] = new TagCESearchBox();
        self::$aVars['oTagCEButton'] = new TagCEButton();
        self::$aVars['oTagCETextBox'] = new TagCETextBox();
        self::$aVars['oTagCETextarea'] = new TagCETextarea();
        self::$aVars['oTagCECheckbox'] = new TagCECheckbox();
        self::$aVars['oTagCEDatebox'] = new TagCEDatebox();
        self::$aVars['oTagCEPanelBegin'] = new TagCEPanelBegin();
        self::$aVars['oTagCEPanelEnd'] = new TagCEPanelEnd();
        self::$aVars['oTagCESelect'] = new TagCESelect();
        self::$aVars['oTagCEComboTree'] = new TagCEComboTree();
    }
}