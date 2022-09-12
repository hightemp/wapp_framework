<?php

namespace Hightemp\WappFramework\Modules\Debug\Controllers;

use Hightemp\WappFramework\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappFramework\Modules\Debug\View;
use Hightemp\WappFramework\Project;
use Hightemp\WappFramework\Modules\Core\Helpers\Utils;
use Hightemp\WappFramework\Modules\Bootstrap\Lib\View\Helpers\HTML;
use Hightemp\WappFramework\Modules\Core\Lib\View\Helpers\HTML as CoreHTML;
use Hightemp\WappFramework\Modules\Debug\Aliases;

class Index extends BaseController
{
    public static $sDefaultViewClass = View::class;
    public static $aDefaultTemplates = [
        "fnModulesIndexHTML" => ['pages/modules/index.php', null, 'DEBUG - Модули'],
        "fnControllersIndexHTML" => ['pages/controllers/index.php', null, 'DEBUG - Контроллеры'],
        "fnAliasesIndexHTML" => ['pages/aliases/index.php', null, 'DEBUG - Альясы'],
        "fnCommandsIndexHTML" => ['pages/commands/index.php', null, 'DEBUG - Команды'],
        "fnGeneratorsIndexHTML" => ['pages/generators/index.php', null, 'DEBUG - Генераторы'],
    ];

    public function fnIndexHTML()
    {
        $aList = [
            [Aliases::BASE_ALIAS_MODULES, "Модули"],
            [Aliases::BASE_ALIAS_CONTROLLERS, "Контроллеры"],
            [Aliases::BASE_ALIAS_ALIASES, "Алясы|Роутинг"],
            [Aliases::BASE_ALIAS_COMMANDS, "Команды"],
            [Aliases::BASE_ALIAS_GENERATORS, "Генераторы"],
        ];

        HTML::fnBeginBuffer();
        HTML::LinksListGroups($aList, [], [ "target" => "main-right-iframe" ]);
        $sList = HTML::fnEndBuffer(true);

        View::fnSetParams([
            "sList" => $sList
        ]);
    }

    public function fnModulesIndexHTML()
    {
        $aList = Project::$aModules;
        $aTable = [];

        CoreHTML::$bReturnBuffered = true;

        foreach ($aList as $sItem) {
            $aTable[] = [
                $sItem, 
                CoreHTML::TagA("vscode", Utils::fnGetVSCodeLinkForClassModule($sItem))
            ];
        }

        CoreHTML::$bReturnBuffered = false;

        View::fnSetParams([
            "aTable" => $aTable
        ]);
    }

    public function fnControllersIndexHTML()
    {
        $aList = BaseController::fnGetControllersByModules();
        $aTable = [];
        foreach ($aList as $sItem) {
            $aTable[] = [$sItem, Utils::fnGetVSCodeLinkForClassModule($sItem)];
        }
        View::fnSetParams([
            "aTable" => $aTable
        ]);
    }

    public function fnAliasesIndexHTML()
    {

    }

    public function fnCommandsIndexHTML()
    {

    }

    public function fnGeneratorsIndexHTML()
    {

    }
}