<?php

namespace Hightemp\WappFramework\Modules\Core\Commands;

use Hightemp\WappFramework\Modules\Core\Generators;
use Hightemp\WappFramework\Modules\Core\Helpers\Utils;
use Hightemp\WappFramework\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappFramework\Modules\Core\Lib\Command;
use Hightemp\WappFramework\Project;
use Hightemp\WappFramework\Modules\Core\Helpers\ClassFinder;

class GetModuleInfo extends Command
{
    const FULL_COMMAND = "get_module_info";

    public function fnExecute($aArgs)
    {
        $sModule = array_shift($aArgs);

        if (!$sModule) {
            die("\n[-] нужно ввести название модуля\n");
        }

        $sClass = Utils::fnGetModulesClassNamespace($sModule);

        $aControllers = (array) $sClass::$aControllers;
        $aAliases = (array) $sClass::$aAliases;
        $aPreloadViews = (array) $sClass::$aPreloadViews;
        $aModels = (array) $sClass::$aModels;
        $aMiddlewares = (array) $sClass::$aMiddlewares;

        $aGenerators = (array) $sClass::fnGetGeneratorsClass();
        $aCommands = (array) $sClass::fnGetCommandsClass();
        $aAliases = (array) $sClass::fnGetAliasesClass();

        $aControllers = array_map(function ($sI) { return [$sI]; }, $aControllers);

        $aAliases = array_map(function ($sI) { return [$sI]; }, $aAliases);
        $aAliasesNew = [];
        foreach ($aAliases as $aI) {
            $aAliasesNew[] = [$aI[0]];
            $aAssocAliases = $aI[0]::fnPrepareAliases();
            foreach ($aAssocAliases as $sAliasKey => $aValue) {
                $aAliasesNew[] = [$sAliasKey, ...$aValue];
            }
        }
        $aAliases = $aAliasesNew;

        $aPreloadViews = array_map(function ($sI) { return [$sI]; }, $aPreloadViews);
        $aModels = array_map(function ($sI) { return [$sI]; }, $aModels);
        $aMiddlewares = array_map(function ($sI) { return [$sI]; }, $aMiddlewares);
        $aGenerators = array_map(function ($sI) { return [$sI]; }, $aGenerators);
        $aCommands = array_map(function ($sI) { return [$sI]; }, $aCommands);

        $aData = [
            '> Controllers',
            ...$aControllers,
            '> Aliases',
            ...$aAliases,
            '> Preload views',
            ...$aPreloadViews,
            '> Models',
            ...$aModels,
            '> Middlewares',
            ...$aMiddlewares,
            '> Generators',
            ...$aGenerators,
            '> Commands',
            ...$aCommands,
        ];

        Utils::fnPrintTable($aData);
    }
}