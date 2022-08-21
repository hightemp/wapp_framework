<?php

namespace Hightemp\WappTestSnotes\Modules\CEasyUI;

use Hightemp\WappTestSnotes\Modules\Core\Lib\View as LibView;

use Hightemp\WappTestSnotes\Modules\CEasyUI\Lib\Tags\Fields\{
    TagCEPanelBegin,
    TagCEPanelEnd,
    TagCEPasswordBox,
    TagCETextBox,
    TagCETextarea,
    TagCECheckbox,
    TagCEDatebox,
    TagCEButton,
    TagCESearchBox,
    TagCECombobox,
    TagCEComboTree,
    TagCEMaskedBox,
    TagCETimePicker,
    TagCECalendar,
    TagCESlider,
    TagCETimespinner,
    TagCEDatagrid,
    TagCEDatalist,
    TagCEProgressBar,
    TagCESwitchButton,
    TagCEPropertygrid,
    TagCETree,
    TagCEFileBox,
    TagCENumberBox,
    TagCERadioButton,
    TagCETabs,
};
use Hightemp\WappTestSnotes\Modules\CEasyUI\Lib\Tags\Fields\MaskedBox\{
    TagCEMaskedBoxPhone,

};
use Hightemp\WappTestSnotes\Modules\CEasyUI\Controllers\{
    Index,
    Demo01,
};

class View extends LibView
{
    const STATIC_PATH = "static";
    const STATIC_IMAGES_PATH = "static";
    const STATIC_CSS_PATH = "static";
    const STATIC_JS_PATH = "static";

    const THEME = 'metro-blue';

    public static $aTemplates = [
        Index::class => [
            "fnIndexHTML" => ['pages/index.php']
        ],
        Demo01::class => [
            "fnIndexHTML" => ['pages/demo1.php']
        ],
    ];

    public static function fnPrepareVars()
    {
        self::$aVars['sTheme'] = static::THEME;

        parent::fnPrepareVars();

        self::$aVars['oTagCETabs'] = new TagCETabs();
        self::$aVars['oTagCERadioButton'] = new TagCERadioButton();
        self::$aVars['oTagCENumberBox'] = new TagCENumberBox();
        self::$aVars['oTagCEFileBox'] = new TagCEFileBox();
        self::$aVars['oTagCETree'] = new TagCETree();
        self::$aVars['oTagCEPropertygrid'] = new TagCEPropertygrid();
        self::$aVars['oTagCESwitchButton'] = new TagCESwitchButton();
        self::$aVars['oTagCEDatagrid'] = new TagCEDatagrid();
        self::$aVars['oTagCEDatalist'] = new TagCEDatalist();
        self::$aVars['oTagCEProgressBar'] = new TagCEProgressBar();
        self::$aVars['oTagCETimespinner'] = new TagCETimespinner();
        self::$aVars['oTagCETimePicker'] = new TagCETimePicker();
        self::$aVars['oTagCECalendar'] = new TagCECalendar();
        self::$aVars['oTagCESlider'] = new TagCESlider();
        self::$aVars['oTagCEPasswordBox'] = new TagCEPasswordBox();
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
        self::$aVars['oTagCECombobox'] = new TagCECombobox();
        self::$aVars['oTagCEComboTree'] = new TagCEComboTree();
    }
}