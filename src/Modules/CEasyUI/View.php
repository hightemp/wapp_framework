<?php

namespace Hightemp\WappFramework\Modules\CEasyUI;

use Hightemp\WappFramework\Modules\Core\Lib\View as LibView;

use Hightemp\WappFramework\Modules\CEasyUI\Lib\Tags\Fields\{
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
use Hightemp\WappFramework\Modules\CEasyUI\Lib\Tags\Fields\MaskedBox\{
    TagCEMaskedBoxPhone,

};
use Hightemp\WappFramework\Modules\CEasyUI\Controllers\{
    Index,
    Demo,
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
            "fnIndexHTML" => ['pages/index.php', null, 'Начальная страница - Заголовок']
        ],
        Demo::class => [
            "fnDemo1HTML" => ['pages/demo1.php', null, 'Демо 1 - Формы и элементы ввода'],
            "fnDemo2HTML" => ['pages/demo2.php', null, 'Демо 2 - Таблица - datagrid'],
            "fnDemo3HTML" => ['pages/demo3.php', null, 'Демо 3 - Таблица - crud функционалом'],
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