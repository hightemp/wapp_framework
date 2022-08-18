<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Helpers;

use Hightemp\WappTestSnotes\Project;
use Hightemp\WappTestSnotes\Modules\Core\Lib\Controllers\BaseController;

class Utils 
{
    public static function fnGetBaseURL($sPath="")
    {
        $aS = BaseController::$oGlobalRequest->aServer;
        $sURL = (isset($aS['HTTPS']) && $aS['HTTPS'] === 'on' ? "https" : "http");
        $sURL .= "://".$aS['HTTP_HOST'];

        return $sURL."/".trim($sPath, "/");
    }

    public static function fnPrepareRelPath($sFullPath)
    {
        return str_replace(ROOT_PATH, "", $sFullPath);
    }

    public static function fnGetProjectRelPath()
    {
        static $sPath = null;
        if (!is_null($sPath)) return $sPath;
        return $sPath = static::fnPrepareRelPath(Project::$sProjectRootPath);
    }

    public static function fnGetRelPathForClass($sClass)
    {
        $sPath = ClassFinder::getNamespaceDirectory($sClass);
        return static::fnPrepareRelPath($sPath);
    }

    public static function fnGetRelPathForClassModule($sClass, $sRelPath="")
    {
        $sPath = static::fnGetGlobalPathForClassModule($sClass, $sRelPath);
        return static::fnPrepareRelPath($sPath);
    }

    public static function fnGetGlobalPathForClassModule($sClass, $sRelPath="")
    {
        $aModuleName = static::fnExtractModuleName($sClass);

        $sPath = Project::$sProjectRootPath."/Modules/".$aModuleName;
        return $sPath.$sRelPath;
    }

    public static function fnGetModuleModels($sModuleClass)
    {
        $sModels = Utils::fnGetModulesClassNamespace(Utils::fnExtractModuleName($sModuleClass), "Models");
        $sModels = "\\".$sModels;

        $aClasses = ClassFinder::getClassesInNamespace($sModels);
        
        return $aClasses;
    }

    public static function fnGetModulesClassNamespace($sModuleName, $sClass="Module")
    {
        return Project::$sProjectClassPath."\\Modules\\".$sModuleName."\\{$sClass}";
    }

    public static function fnExtractModuleName($sFullClassPath)
    {
        $sFullClassPath = str_replace(Project::$sProjectClassPath."\\Modules\\", "", $sFullClassPath);
        $aPath = explode("\\", $sFullClassPath);
        return $aPath[0];
    }

    public static function fnIsCli()
    {
        return php_sapi_name() == "cli";
    }

    public static function fnPrepareTableLine($aHeaders)
    {
        $aLines = [];
        foreach ($aHeaders as $aHeader) {
            $aLines[] = str_repeat("-", $aHeader[1]);
        }
        return "--".join("---", $aLines)."--\n";
    }

    public static function fnPreparePrintfMask($aHeaders)
    {
        $aMask = [];
        foreach ($aHeaders as $aHeader) {
            $aMask[] = "%-".$aHeader[1]."s";
        }
        return "| ".join(" | ", $aMask). " |\n";
    }

    public static function fnPrintTable($aData, $aOptions=[])
    {
        $aHeaders = isset($aOptions['headers']) ? $aOptions['headers'] : [];

        if (!$aHeaders) {
            $aDefaultRow = isset($aData[0]) ? $aData[0] : [];
            $aMaxLength = array_fill(0, count($aDefaultRow), 0);

            foreach ($aData as $iN => $aRow) {
                foreach ($aRow as $iI => $sText) {
                    $sText = (string) $sText;
                    $aMaxLength[$iI] = max(strlen($sText)+2, $aMaxLength[$iI]);
                }
            }

            foreach ($aMaxLength as $iL) {
                $aHeaders[] = [
                    '',
                    $iL,
                ];
            }
        }

        $sLine = static::fnPrepareTableLine($aHeaders);
        $sMask = static::fnPreparePrintfMask($aHeaders);

        echo $sLine;

        $aHeadersTitles = array_map(function($aI) { return $aI[0]; }, $aHeaders);
        $aHeadersFiltered = array_filter($aHeadersTitles, function ($sI) { return trim($sI); });

        if ($aHeadersFiltered) {
            printf($sMask, ...$aHeadersTitles);
            echo $sLine;
        }

        foreach ($aData as $aRow) {
            printf($sMask, ...$aRow);
        }

        echo $sLine;
    }
}