<?php

namespace Hightemp\WappFramework\Modules\Core\Helpers;

use Hightemp\WappFramework\Project;
use Hightemp\WappFramework\Modules\Core\Lib\Controllers\BaseController;
use Hightemp\WappFramework\Modules\Core\Lib\Config;
use Hightemp\WappFramework\Modules\Core\Lib\Request;
use \League\Url\Url;
class Utils 
{
    public static function fnFindStringInRegExpArr($sString, $aRegExpList, $bStrict=true)
    {
        foreach ($aRegExpList as $sKey) {
            $sRegExp = $bStrict ? "|^".$sKey."$|" : "|".$sKey."|";
            if (preg_match($sRegExp, $sString)) {
                return $sKey;
            }
        }
    }

    public static function fnFindKeyByRegExp($sKeyRegExp, $aList, $bStrict=true)
    {
        foreach ($aList as $sKey => $mValue) {
            $sKeyRegExp = $bStrict ? "|^".$sKeyRegExp."$|" : "|".$sKeyRegExp."|";
            if (preg_match($sKeyRegExp, $sKey)) {
                return $sKey;
            }
        }
    }

    public static function fnGetBaseURL($sPath="")
    {
        $aS = BaseController::$oGlobalRequest->aServer;
        $sURL = (isset($aS['HTTPS']) && $aS['HTTPS'] === 'on' ? "https" : "http");
        $sURL .= "://".$aS['HTTP_HOST'];

        return $sURL."/".trim($sPath, "/");
    }

    public static function fnIsURLCurrent($sURL, $bStrict=false)
    {
        $oGlobalRequest = BaseController::$oGlobalRequest;
        $oCurrentURL = $oGlobalRequest->fnCopyURL($oGlobalRequest->oCurrentURL);
        $oURL = null;
    
        if (strpos($sURL, "/")===0) {
            $oURL = $oGlobalRequest->fnCopyURL($oGlobalRequest->oBaseURL);
            $oURL->setPath($sURL);
            $sURL = $oURL."";
        } else {
            $oURL = Url::createFromUrl($sURL);
        }

        if ($bStrict) {
            $sCurrentURL = $oCurrentURL."";
        } else {
            $sCurrentURL = $oCurrentURL->setQuery("")."";
            $sURL = $oURL->setQuery("")."";
        }
        return strpos($sCurrentURL, $sURL)===0;
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

    public static function fnGetVSCodeLinkForClassModule($sClass)
    {
        $sPath = static::fnGetGlobalPathForClassModule($sClass);
        return "vscode:///file/".$sPath;
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

    public static function fnFormatPrint(array $format=[],string $text = '') {
        $codes=[
            'bold'=>1,
            'italic'=>3, 'underline'=>4, 'strikethrough'=>9,
            'black'=>30, 'red'=>31, 'green'=>32, 'yellow'=>33,'blue'=>34, 'magenta'=>35, 'cyan'=>36, 'white'=>37,
            'blackbg'=>40, 'redbg'=>41, 'greenbg'=>42, 'yellowbg'=>44,'bluebg'=>44, 'magentabg'=>45, 'cyanbg'=>46, 'lightgreybg'=>47
        ];
        $formatMap = array_map(function ($v) use ($codes) { return $codes[$v]; }, $format);
        return "\e[".implode(';',$formatMap).'m'.$text."\e[0m";
    }

    public static function fnFormatPrintLn(array $format=[], string $text='') {
        return static::fnFormatPrint($format, $text)."\r\n";
    }

    public static function fnSetPrintColor($str, $type = 'i')
    {
        switch ($type) {
            case 'e': //error
                return "\033[31m$str \033[0m\n";
            break;
            case 's': //success
                return "\033[32m$str \033[0m\n";
            break;
            case 'w': //warning
                return "\033[33m$str \033[0m\n";
            break;  
            case 'i': //info
                return "\033[36m$str \033[0m\n";
            break;      
            default:
                return $str;
            break;
        }
    }
    
    public static $bUseBufferedOutput = true;
    public static $aBuffer = [];

    public static function fnFlush()
    {
        echo join("", static::$aBuffer);
    }

    public static function fnGetBufferLastRecord()
    {
        return static::$aBuffer ? static::$aBuffer[count(static::$aBuffer)-1] : "";
    }

    public static function fnPrintOnce($sMessage)
    {
        $sLast = static::fnGetBufferLastRecord();
        if ($sLast != $sMessage) {
            static::fnPrint($sMessage);
        }
    }

    public static function fnPrint($sMessage)
    {
        if (static::$bUseBufferedOutput) {
            static::$aBuffer[] = $sMessage;
        } else {
            echo $sMessage;
        }
    }

    public static function fnPrintFormated($sMask, ...$aHeadersTitles)
    {
        if (static::$bUseBufferedOutput) {
            static::$aBuffer[] = sprintf($sMask, ...$aHeadersTitles);
        } else {
            printf($sMask, ...$aHeadersTitles);
        }
    }

    public static function fnPrintSuccess($sMessage)
    {
        static::fnSetPrintColor("[+] ".$sMessage, 's');
    }

    public static function fnPrintError($sMessage)
    {
        static::fnSetPrintColor("[E] ".$sMessage, 'e');
    }

    public static function fnPrintTable($aData, $aOptions=[])
    {
        $aHeaders = isset($aOptions['headers']) ? $aOptions['headers'] : [];

        if (!$aHeaders) {
            $aDefaultRow = (array) (isset($aData[0]) ? $aData[0] : []);
            $aMaxLength = array_fill(0, count($aDefaultRow), 0);

            foreach ($aData as $iN => $aRow) {
                $aRow = (array) $aRow;
                foreach ($aRow as $iI => $sText) {
                    $sText = (string) $sText;
                    $iL = isset($aMaxLength[$iI]) ? $aMaxLength[$iI] : 0;
                    $aMaxLength[$iI] = max(strlen($sText)+2, $iL);
                }
            }

            foreach ($aMaxLength as $iL) {
                $aHeaders[] = [
                    '',
                    $iL,
                ];
            }
        }

        $iMaxColCount = count($aHeaders);
        $aHeadersByColCount = [];
        $aMasksByColCount = [];

        for ($iI=0; $iI<count($aHeaders); $iI++) {
            $iSumLen = 0;
            foreach ($aHeaders as $iJ => $aI) {
                if ($iJ>=$iI) {
                    $iSumLen += $aI[1] + 3;
                }
            }
            $iSumLen -= 3;
            $iC = $iI+1;
            $aHeadersByColCount[$iC] = array_slice($aHeaders, 0, $iI);
            $aHeadersByColCount[$iC][] = ['', $iSumLen];
            $aMasksByColCount[$iC] = static::fnPreparePrintfMask($aHeadersByColCount[$iC]);
        }

        $sLine = static::fnPrepareTableLine($aHeaders);
        // $sMask = static::fnPreparePrintfMask($aHeaders);

        static::fnPrintOnce($sLine);

        $aHeadersTitles = array_map(function($aI) { return $aI[0]; }, $aHeaders);
        $aHeadersFiltered = array_filter($aHeadersTitles, function ($sI) { return trim($sI); });

        if ($aHeadersFiltered) {
            $iC = count($aHeadersFiltered);
            $sMask = $aMasksByColCount[$iC];
            static::fnPrintFormated($sMask, ...$aHeadersTitles);
            static::fnPrintOnce($sLine);
        }

        $iC = count((array) $aData[0]);
        $iOldC = $iC;
        foreach ($aData as $mRow) {
            $bIsStr = is_string($mRow);
            $aRow = (array) $mRow;
            $sCol = $aRow[0];

            if ($bIsStr && $sCol[0] == "-") {
                static::fnPrintOnce($sLine);
                continue;
            }

            $iOldC = $iC;
            $iC = count($aRow);

            $sMask = $aMasksByColCount[$iC];

            if ($iC != $iOldC) {
                static::fnPrintOnce($sLine);
            }
            if ($bIsStr && $sCol[0] == ">") {
                static::fnPrintOnce($sLine);
            }

            static::fnPrintFormated($sMask, ...$aRow);

            if ($bIsStr && $sCol[0] == ">") {
                static::fnPrintOnce($sLine);
            }
        }

        static::fnPrintOnce($sLine);
    }

    public static function fnPrepareURL($sURL)
    {
        return rtrim(Config::$aConfig["sBasePath"], "/")."/".ltrim($sURL, "/");
    }
}